<?php
namespace app\controllers;
use Yii;

class GitController extends \yii\web\Controller{
    public $enableCsrfValidation = false;

    public function actionIndex(){
        echo 'test';
        exit();
        if(Yii::$app->request->isPost){
            $payload = Yii::$app->request->post('payload');
            $data = json_decode($payload);

            if($data->ref == "refs/heads/master"){          
                exec("git pull", $output);
                var_dump($output);
            }else{
                echo "This branch is not master branch.";
            }
        }else{
            echo "Invalid request.";
        }
    }
}

