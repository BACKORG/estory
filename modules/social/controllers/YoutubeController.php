<?php
namespace app\modules\social\controllers;

class YoutubeController extends BaseController implements SocialInterface{
    private $_youtube;

    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        $this->_youtube = new \zhexiao\youtube\zxYoutube(\Yii::$app->params['GOOGLE_API_KEY']);
    }

    /**
     * connect social account
     * @return [type] [description]
     */
    public function actionConnect(){
        
    }

    /**
     * save access token
     * @return [type] [description]
     */
    public function actionAuth(){
  

    }

    public function actionSearch(){
        if(!empty($this->keyword)){
            // set cache name
            $this->cache_name = 'youtube_' . $this->keyword .'_' .$this->keyword_type;

            $response = $this->cache->get( $this->cache_name );
            if($response === false){
                switch ($this->keyword_type) {
                    case 'text':
                        $response = $this->_youtube->search([
                            'q' => $this->keyword,
                            'maxResults' => $this->count
                        ]);               
                    break;
                    
                    case 'people':
                        $response = $this->_youtube->search([
                            'q' => $this->keyword,
                            'maxResults' => $this->count,
                            'type' => 'channel'
                        ]);                     
                    break;
                }                                
            }


            if(count($response['items']) > 0){
                // set new cache
                $this->cache->set( $this->cache_name, $response, CACHE_TIME);

                $this->_output['data'] = $response['items'];                  
                $this->outputJson( $this->_output );
            }
        }
    }
}