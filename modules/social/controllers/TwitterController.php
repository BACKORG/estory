<?php
namespace app\modules\social\controllers;

use yii\web\Controller;

class TwitterController extends BaseController implements SocialInterface{
    // define the codebird variable
    private $_codebird;

    // define the output data
    private $_output = ['error' => false];

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
            'screen_name' => $twitterUser[0]['screen_name'],
            'profile_image_url' => $twitterUser[0]['profile_image_url'],
            'auth_token' => $oauth_token,
            'auth_secret' => $oauth_secret
        ];
        $ezTwitter = new \app\models\EzTwitter;
        $ezTwitter->setAttributes($parameters);
        $ezTwitter->save();
    }

    /**
     * search 
     * @return [type] [description]
     */
    public function actionSearch(){

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
