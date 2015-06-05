<?php

namespace app\modules\social\controllers;

use yii\web\Controller;

class BaseController extends Controller{
    // define the output data
    public $_output = ['error' => false];
    
    // define session component
    public $session;

    // define request component
    public $request;

    // define cache component
    public $cache;

    // define user id
    public $uid;

    // define search keyword
    public $keyword;

    // define search keyword type
    public $keyword_type;

    // define search count
    public $count = 30;

    // define cache name
    public $cache_name;
    
    /**
     * init variable
     * @return [type] [description]
     */
    public function init(){
        $this->session = \Yii::$app->session;

        $this->request = \Yii::$app->request;

        $this->cache = \Yii::$app->cache;

        $this->uid = \Yii::$app->user->identity->id;

        $this->keyword = $this->request->post('keyword');

        $this->keyword_type = $this->request->post('keyword_type');
    }


    /**
     * output json data
     * @return [type] [description]
     */
    public function outputJson($data){
        echo \yii\helpers\Json::encode($data);
    }
}
