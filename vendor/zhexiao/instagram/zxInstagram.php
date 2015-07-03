<?php  
namespace zhexiao\instagram;

use zhexiao;

/**
* Instagram library (php)
*/
class zxInstagram{
    private $_client_id;
    private $_client_secret;
    private $_redirect_url;

    // api url
    private $_api_host = 'https://api.instagram.com/v1';

    /**
     * class construct
     */
    public function __construct($client_id, $client_secret, $redirect_url){
        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;
        $this->_redirect_url = $redirect_url;
    }

    /**
     * return the auth link
     * @param  [type] $client_id    [description]
     * @param  [type] $redirect_url [description]
     * @return [type]               [description]
     */
    public function authLink(){
        return 'https://api.instagram.com/oauth/authorize/?client_id='.$this->_client_id.'&redirect_uri='.$this->_redirect_url.'&response_type=code';
    }

    /**
     * get the auth token
     * @return [type] [description]
     */
    public function authToken($code){
        $link = 'https://api.instagram.com/oauth/access_token/';
        $parameter = [
            'client_id' => $this->_client_id,
            'client_secret' => $this->_client_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->_redirect_url,
            'code' => $code
        ];   

        return $this->curl_post($link, $parameter);
    }

    /**
     * get my posts
     * @param  [type] $userid       [description]
     * @param  [type] $access_token [description]
     * @return [type]               [description]
     */
    public function getMyPosts($uid, $token)
    {
        $url = $this->_api_host. '/users/'. $uid. "/media/recent/?access_token=".$token;
        $res = $this->curl_get($url);       
        return  json_decode($res, true);
    }

    /**
     * Get a list of recently tagged media
     * @param  [type] $q     [description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function tags_recent($parameters){
        $url = $this->_api_host. '/tags/'. $parameters['q']. "/media/recent?access_token=".$parameters['token'];
        if(isset($parameters['MAX_TAG_ID'])){
            $url .= '&MAX_TAG_ID='.$parameters['MAX_TAG_ID'].'&max_tag_id='.$parameters['MAX_TAG_ID'];
        }

        $res = $this->curl_get($url);       
        return  json_decode($res, true);
    }

    public function users_search($parameters){
        $url = $this->_api_host. '/users/search?q='. $parameters['q']. "&access_token=".$parameters['token'];
        $res = $this->curl_get($url);       
        return  json_decode($res, true);
    }

    /**
     * curl post
     * @return [type]      [description]
     */
    public function curl_post($url, $data, $curl_extra = array()){   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'); 
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_MAXREDIRS      , 5);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE );

        // extra parameter
        if(count($curl_extra) > 0){
            foreach ($curl_extra as $key => $val) 
                curl_setopt($ch, $key, $val); 
        }

        $result  = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * curl get data 
     * @return [type] [description]
     */
    public function curl_get($url, $curl_extra = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_MAXREDIRS      , 5);
        // extra parameter
        if(count($curl_extra) > 0) {
            foreach ($curl_extra as $key => $val) 
                curl_setopt($ch, $key, $val); 
        }

        $result  = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}