<?php
namespace app\modules\social\controllers;

class YoutubeController extends BaseController implements SocialInterface{
    private $_youtube;

    private $_next_page_token;

    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        $this->_youtube = new \zhexiao\youtube\zxYoutube(\Yii::$app->params['GOOGLE_API_KEY']);

        $this->_next_page_token = $this->request->post('next_page', null); 
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
            $this->cache_name = 'youtube_' . $this->keyword .'_' .$this->keyword_type.'_'.$this->_next_page_token;

            $response = $this->cache->get( $this->cache_name );
            if($response === false){
                $parameters = [
                    'q' => $this->keyword,
                    'maxResults' => $this->count
                ];

                if($this->_next_page_token){
                    $parameters['pageToken'] = $this->_next_page_token;
                }

                switch ($this->keyword_type) {
                    case 'text':
                        $response = $this->_youtube->search($parameters);               
                    break;
                    
                    case 'people':
                        $parameters['type'] = 'channel';
                        $response = $this->_youtube->search($parameters);                     
                    break;
                }         

                if(count($response['items']) > 0){
                    // set new cache
                    $this->cache->set( $this->cache_name, $response, CACHE_TIME);
                }                       
            }


            if(count($response['items']) > 0){
                if(isset($response['nextPageToken'])){
                    $this->_output['next_page'] = $response['nextPageToken'];
                }

                $this->_output['data'] = $response['items'];                  
                $this->outputJson( $this->_output );
            }
        }
    }
}