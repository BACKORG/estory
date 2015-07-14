<?php
namespace app\modules\compose\controllers;

class WordpressController extends BaseController implements BaseInterface{
    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();
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

        $model = new \app\models\EzWordpress;
        $model->setAttributes($parameters);
        if( $model->validate() && $model->save($parameters) ){
            \zhexiao\helper\zxHelper::outputJson( $model );
        }else{
            \zhexiao\helper\zxHelper::outputJson($model->getErrors());
        }
    }
}