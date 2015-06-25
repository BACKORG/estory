<?php
namespace app\modules\social\controllers;

class TwitterController extends BaseController implements SocialInterface{
    // define the codebird variable
    private $_codebird;

    // define the next page url
    private $_next_page_url;

    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        \zhexiao\twitter\Codebird::setConsumerKey(\Yii::$app->params['TWITTER_CONSUMER_KEY'], \Yii::$app->params['TWITTER_CONSUMER_SECRET']);

        $this->_codebird = \zhexiao\twitter\Codebird::getInstance();
        // convert the return data to array
        $this->_codebird->setReturnFormat(CODEBIRD_RETURNFORMAT_ARRAY);

        $this->_next_page_url = $this->request->post('next_page');
    }

    /**
     * link twitter account
     * @return [type] [description]
     */
    public function actionConnect(){
        $reply = $this->_codebird->oauth_requestToken([
            'oauth_callback' => \Yii::$app->params['TWITTER_CALLBACK_URL']
        ]);

        // store the token
        $this->_codebird->setToken($reply['oauth_token'], $reply['oauth_token_secret']);

        $this->session->set('oauth_token_secret', $reply['oauth_token_secret']);

        $auth_url = $this->_codebird->oauth_authorize();

        $this->redirect($auth_url);
    }

    /**
     * auth twitter account and save token
     * @return [type] [description]
     */
    public function actionAuth(){
        $oauth_token = $this->request->get('oauth_token');
        $oauth_verifier = $this->request->get('oauth_verifier');

        $oauth_secret = $this->session->get('oauth_token_secret');
        $this->_codebird->setToken($oauth_token, $oauth_secret);

        $res = $this->_codebird->oauth_accessToken([
            'oauth_verifier' => $oauth_verifier
        ]);

        // using user token to get twitter user data
        $this->_codebird->setToken($res['oauth_token'], $res['oauth_token_secret']);
        $twitterUser = $this->getTwitterUser($res['user_id']);

        // save to database
        $parameters = [
            'uid' => $this->uid,
            'id_str' => $twitterUser[0]['id_str'],
            'screen_name' => $twitterUser[0]['screen_name'],
            'profile_image_url' => $twitterUser[0]['profile_image_url'],
            'auth_token' => $res['oauth_token'],
            'auth_secret' => $res['oauth_token_secret']
        ];

        // check data exist or not
        $ezTwitterData = \app\models\EzTwitter::findOne(['id_str' => $parameters['id_str']]);
        if($ezTwitterData){
            \app\models\EzTwitter::updateDt($ezTwitterData->id, $parameters);
        }else{
            \app\models\EzTwitter::insertDt($parameters);
        }

        $this->redirect('/');
    }

    /**
     * search 
     * @return [type] [description]
     */
    public function actionSearch(){
        if(!empty($this->keyword)){
            // set cache name
            $this->cache_name = 'twitter_' . $this->keyword .'_' .$this->keyword_type;
            
            // check social account
            $uTwitter = \app\models\EzTwitter::userTwitter($this->uid);
            if(count($uTwitter) > 0){
                foreach ($uTwitter as $act) {
                    $this->_codebird->setToken($act->auth_token, $act->auth_secret);

                    // get cache data
                    $response = $this->cache->get( $this->cache_name );
                    if($response === false){
                        // get api data
                        switch ($this->keyword_type) {
                            case 'text':
                                $response = $this->_codebird->search_tweets('q='.$this->keyword.'&count='.$this->count, true);                  
                            break;
                            
                            case 'people':
                                $response = $this->_codebird->users_search(array(
                                    'q' => $this->keyword,
                                    'page'=> '1',
                                    'count'=> $this->count,
                                ));                       
                            break;
                        }

                        // only save to cache when it's return data
                        if($response['httpstatus'] == 200 ){
                            // set new cache
                            $this->cache->set( $this->cache_name, $response, CACHE_TIME);
                        }             
                    }

                    // check return status
                    if($response['httpstatus'] == 200 ){
                        switch ($this->keyword_type) {
                            case 'text':
                                $this->_output['data'] = $response['statuses'];
                                $this->_output['next_page'] = $response['search_metadata']['max_id_str'];
                            break;
                            
                            case 'people':
                               $this->_output['data'] = $response;
                               unset($this->_output['data']['httpstatus']);
                               unset($this->_output['data']['rate']);
                            break;
                        }                       
                    }

                    // check the request reach to the limit
                    if($response['rate']['remaining'] > 0){
                        // if exist remaining request, break loop
                        $this->outputJson( $this->_output );

                        break;
                    }else{
                        // if not exist remaining request, continue change to a new account
                        continue;
                    }
                }
            }else{
                $this->_output['error'] = true;
                $this->_output['message'] = $this->renderPartial('no_account', array(), true);

                $this->outputJson($this->_output); 
            }
        }
    }

    /**
     * api get twitter user
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    private function getTwitterUser($user_id){
        $twitterUser = $this->_codebird->users_lookup([
            'user_id' => $user_id
        ]);

        return $twitterUser;
    }
}
