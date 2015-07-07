<?php
namespace app\modules\social\controllers;

class InstagramController extends BaseController implements SocialInterface{
    private $_instagram;

    private $_next_max_id;

    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        $this->_instagram = new \zhexiao\instagram\zxInstagram(\Yii::$app->params['INSTAGRAM_CLIENT_ID'], \Yii::$app->params['INSTAGRAM_CLIENT_SECRET'], \Yii::$app->params['INSTAGRAM_REDIRECT_URL']);


        $this->_next_max_id = $this->request->post('next_page', null); 
    }

    /**
     * connect social account
     * @return [type] [description]
     */
    public function actionConnect(){
        $authLink = $this->_instagram->authLink();

        $this->redirect($authLink);
    }

    /**
     * save access token
     * @return [type] [description]
     */
    public function actionAuth(){
        $code = $this->request->get('code');
        $res = $this->_instagram->authToken($code);
        $resJson = json_decode($res, true);    
        if(isset($resJson['access_token'])){
            // save to database
            $parameters = [
                'uid' => $this->uid,
                'instagram_id' => $resJson['user']['id'],
                'username' => $resJson['user']['username'],
                'full_name' => $resJson['user']['full_name'],
                'profile_picture' => $resJson['user']['profile_picture'],
                'access_token' => $resJson['access_token'],
            ];

            // check data exist or not
            $ezInstagramData = \app\models\EzInstagram::findOne(['instagram_id' => $parameters['instagram_id']]);
            if($ezInstagramData){
                \app\models\EzInstagram::updateDt($ezInstagramData->id, $parameters);
            }else{
                \app\models\EzInstagram::insertDt($parameters);
            }

            $this->redirect('/');
        }
    }

    public function actionSearch(){
        if(!empty($this->keyword)){
            // set cache name
            $this->cache_name = 'instagram_' . $this->keyword .'_' .$this->keyword_type.'_'.$this->_next_max_id;

            // check social account
            $uInstagram = \app\models\EzInstagram::userInstagram($this->uid);
            if(count($uInstagram) > 0){
                foreach ($uInstagram as $act) {
                    // get cache data
                    $response = $this->cache->get( $this->cache_name );
                    if($response === false){
                        $parameters = [
                            'q' => $this->keyword,
                            'token' => $act->access_token
                        ];

                        if($this->_next_max_id){
                            $parameters['MAX_TAG_ID'] = $this->_next_max_id;
                        }

                        // get api data
                        switch ($this->keyword_type) {
                            case 'text':
                                $response = $this->_instagram->tags_recent($parameters);                
                            break;
                            
                            case 'people':
                                $response = $this->_instagram->users_search($parameters);                     
                            break;
                        }         

                        if($response['meta']['code'] == 200 ){    
                            // set new cache
                            $this->cache->set( $this->cache_name, $response, CACHE_TIME);
                        }      
                    }

                    // check return status
                    if($response['meta']['code'] == 200 ){    
                        if(isset($response['pagination']['next_max_id'])){
                            $this->_output['next_page'] = $response['pagination']['next_max_id'];
                        }

                        $this->_output['data'] = $response['data'];                  
                        $this->outputJson( $this->_output );

                        // if http status success, break loop
                        break;
                    }

                    // if http status failed, continue loop account
                    continue;
                }
            }else{
                $this->_output['error'] = true;
                $this->_output['message'] = $this->renderPartial('no_account', array(), true);

                $this->outputJson($this->_output); 
            }
        }
    }
}