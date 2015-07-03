<?php
namespace app\modules\social\controllers;

class VimeoController extends BaseController implements SocialInterface{
    private $_vimeo;

    private $_page;

    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        $this->_vimeo = new \Vimeo\Vimeo(\Yii::$app->params['VIMEO_CLIENT_ID'], \Yii::$app->params['VIMEO_CLIENT_SECRET']);
        $this->_vimeo->setToken(\Yii::$app->params['VIMEO_ACCESS_TOKEN']);

        $this->_page = $this->request->post('next_page') ? $this->request->post('next_page') : 1;
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
            $this->cache_name = 'vimeo_' . $this->keyword .'_' .$this->keyword_type.'_'.$this->_page;

            $response = $this->cache->get( $this->cache_name );
            if($response === false){
                switch ($this->keyword_type) {
                    case 'text':
                        $response = $this->_vimeo->request('/videos', [
                            'page' => $this->_page,
                            'per_page' => $this->count,
                            'query' => $this->keyword,
                            'sort' => 'relevant',
                            'direction' => 'desc'
                        ], 'GET');          
                    break;
                    
                    case 'people':
                        $response = $this->_vimeo->request('/users', [
                            'page' => $this->_page,
                            'per_page' => $this->count,
                            'query' => $this->keyword,
                            'sort' => 'relevant',
                            'direction' => 'desc'
                        ], 'GET');           
                    break;
                }

                // set new cache
                if($response['status'] == 200){
                    $this->cache->set( $this->cache_name, $response, CACHE_TIME); 
                }
            }


            if($response['status'] == 200){    
                if(isset($response['body']['paging']['next'])){
                    $this->_output['next_page'] = $this->_page + 1;
                }

                $this->_output['data'] = $response['body']['data'];                  
                $this->outputJson( $this->_output );
            }
        }
    }
}