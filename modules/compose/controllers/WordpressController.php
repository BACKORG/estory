<?php
namespace app\modules\compose\controllers;

class WordpressController extends BaseController implements BaseInterface{
    private $_wp_xmlrpc;
    
    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        $this->_wp_xmlrpc = new \zhexiao\wordpress\zxWordpress('http://zocle.itmwpb.com/xmlrpc.php', 'zocle', 'intertech01');
    }

    /**
     * post data
     * @return [type] [description]
     */
    public function actionPost(){

    }

    /**
     * save a new wordpress accounts
     * @return [type] [description]
     */
    public function actionSaveAccount(){
        $parameters = [
            'uid' => $this->uid,
            'username' => $this->request->post('username'),
            'password' => base64_encode($this->request->post('password')),
            'link' => $this->request->post('link'),
            'title' => $this->request->post('title')
        ];

        $this->validateWpAccount($parameters);

        $model = new \app\models\EzWordpress;
        $model->setAttributes($parameters);
        if( $model->validate() && $model->save($parameters) ){
            \zhexiao\helper\zxHelper::outputJson( $model );
        }else{
            \zhexiao\helper\zxHelper::outputJson($model->getErrors());
        }
    }

    /**
     * validate this wordpress account
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    private function validateWpAccount($parameters){
        $res = $this->_wp_xmlrpc->create_post([
            'title' => 'test 123',
            'description' => 'desc 123'
        ]);
        print_r($res);
    }
}