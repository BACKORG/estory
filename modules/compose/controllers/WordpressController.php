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
     * link a new account form
     * @return [type] [description]
     */
    public function actionLinkForm(){
        echo $this->renderPartial('link_form');
    }
}