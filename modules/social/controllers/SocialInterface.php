<?php  
namespace app\modules\social\controllers;

/**
 * social account interface
 */
interface SocialInterface {
    // connect social account
    public function actionConnect();

    // get token
    public function actionAuth();

    public function actionSearch();
}
