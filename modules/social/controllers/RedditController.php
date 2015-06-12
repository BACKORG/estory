<?php
namespace app\modules\social\controllers;

class RedditController extends BaseController implements SocialInterface{
    private $_reddit;

    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();      
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
            $this->cache_name = 'reddit_' . $this->keyword .'_' .$this->keyword_type;

            // get cache data
            $response = $this->cache->get( $this->cache_name );
            if(true){
                // get api data
                switch ($this->keyword_type) {
                    case 'text':
                        $url = 'http://www.reddit.com/r/'.$this->keyword.'/.rss';    
                    break;

                    case 'people':
                        $url = 'http://www.reddit.com/user/'.$this->keyword.'/.rss';    
                    break;
                }   

                // get rss data
                $rss = new \zhexiao\rss\zxRss($url);
                $response = $rss->get();
                
                $this->cache->set( $this->cache_name, $response, CACHE_TIME);            
            }

            $this->_output['data'] = $response['items'];                  
            $this->outputJson( $this->_output );
        }
    }
}