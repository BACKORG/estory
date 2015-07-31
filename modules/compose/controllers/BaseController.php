<?php

namespace app\modules\compose\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
    // define the output data
    public $_output = ['error' => true];

    // define session component
    public $session;

    // define request component
    public $request;

    // define user id
    public $uid;


    /**
     * init variable
     * @return [type] [description]
     */
    public function init(){
        $this->session = \Yii::$app->session;

        $this->request = \Yii::$app->request;

        $this->uid = \Yii::$app->user->identity->id;
    }
}