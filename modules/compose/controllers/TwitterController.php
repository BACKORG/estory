<?php
namespace app\modules\compose\controllers;

class TwitterController extends BaseController{    
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
    public static function post($dt){
        $ezPostTw = new \app\models\EzPostTwitter;
        $ezPostTw->setAttributes([
            'uid' => $dt->uid,
            'content' => $dt->content
        ]);
        
        if( !($ezPostTw->validate() && $ezPostTw->save()) ){
            print_r($ezPostTw->getErrors());
        }
    }
}