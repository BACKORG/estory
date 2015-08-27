<?php
namespace app\modules\compose\controllers;

class SocialController extends BaseController{    
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
        $postDt = json_decode( $this->request->rawBody );
        foreach ($postDt as $type => $dt) {
            $dt->uid = $this->uid;

            switch ($type) {
                case 'wordpress':
                    WordpressController::post($dt);
                break;
                
                case 'twitter':
                    TwitterController::post($dt);
                break;
            }
        }
    }
}