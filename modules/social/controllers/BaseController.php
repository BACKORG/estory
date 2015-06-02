<?php

namespace app\modules\social\controllers;

use yii\web\Controller;

class BaseController extends Controller{
    // define the output data
    public $_output = ['error' => false];
    
    // define session variable
    public $session;

    // define request variable
    public $request;

    // define user id
    public $uid;

    // define search keyword
    public $keyword;

    // define search count
    public $count = 30;
    

    public function init(){
        $this->session = \Yii::$app->session;

        $this->request = \Yii::$app->request;

        $this->uid = \Yii::$app->user->identity->id;
    }


    /**
     * output json data
     * @return [type] [description]
     */
    public function outputJson($data){
        echo \yii\helpers\Json::encode($data);
    }
}
