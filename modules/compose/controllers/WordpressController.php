<?php
namespace app\modules\compose\controllers;

class WordpressController extends BaseController{
    private $_wp_xmlrpc;
    
    /**
     * initialization controller
     * @return [type] [description]
     */
    public function init(){
        // overload parent controller
        parent::init();

        // $this->_wp_xmlrpc = new \zhexiao\wordpress\zxWordpress('http://zocle.itmwpb.com/xmlrpc.php', 'zocle1', 'intertech01');
    }

    /**
     * post data
     * @return [type] [description]
     */
    public static function post($dt){
        $ezPostwp = new \app\models\EzPostWordpress;
        $ezPostwp->setAttributes([
            'uid' => $dt->uid,
            'title' => $dt->title,
            'content' => $dt->content
        ]);
        
        if( !($ezPostwp->validate() && $ezPostwp->save()) ){
            print_r($ezPostwp->getErrors());
        }
    }

    /**
     * save a new wordpress accounts
     * @return [type] [description]
     */
    public function actionSaveAccount(){
        $parameters = [
            'uid' => $this->uid,
            'username' => $this->request->post('username'),
            'password' => base64_encode($this->request->post('password')),
            'link' => $this->request->post('link'),
            'title' => $this->request->post('title')
        ];

        // add xmlrpc to the link
        $link = rtrim($parameters['link'], '/') . '/xmlrpc.php';

        // init wp
        $this->_wp_xmlrpc = new \zhexiao\wordpress\zxWordpress($link, $parameters['username'], $this->request->post('password'));
        // valid wordpress account
        $valid = $this->validateWpAccount();

        if($valid){
            $model = new \app\models\EzWordpress;
            $model->setAttributes($parameters);
            if( $model->validate() && $model->save($parameters) ){
                $this->_output['error'] = false;
                $this->_output['data'] = $model;
            }else{
                $this->_output['message'] = $model->getErrors();
            }
        }else{
            $this->_output['message'] = 'Sorry, you account is invalid, please try again!';
        }       

        \zhexiao\helper\zxHelper::outputJson( $this->_output );
    }

    /**
     * validate this wordpress account
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    private function validateWpAccount(){
        $res = $this->_wp_xmlrpc->getUser();   
        if(isset($res['blogName'])){
            return true;
        }else{
            return false;
        }
    }
}