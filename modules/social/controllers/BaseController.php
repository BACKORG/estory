<?php

namespace app\modules\social\controllers;

use yii\web\Controller;

class BaseController extends Controller{
    // define session variable
    public $session;

    // define request variable
    public $request;

    public function init(){
        $this->session = \Yii::$app->session;
        $this->request = \Yii::$app->request;
    }


    /**
     * output json data
     * @return [type] [description]
     */
    public function outputJson($data){
        echo \yii\helpers\Json::encode($data);
    }
}
