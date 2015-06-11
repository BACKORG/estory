<?php
namespace zhexiao\reddit;

/**
* Reddit PHP SDK
* access token configuration from https://ssl.reddit.com/prefs/apps
*/
class zxReddit{
    // api url
    private $api_host = 'https://oauth.reddit.com';
    private $auth_host = 'https://ssl.reddit.com/api/v1/authorize';

    private $_client_id;
    private $_client_secret;
    private $_redirect_url;

    private $_access_token;

    public function __construct($client_id, $client_secret, $redirect_url){
        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;
        $this->_redirect_url = $redirect_url;
    }

    /**
     * get auth link
     * @return [type] [description]
     */
    public function authLink(){
        $parameter = [
            'response_type' => 'code',
            'client_id' => $this->_client_id,
            'redirect_uri' => $this->_redirect_url,
            'scope' => 'identity,save,modposts,edit,submit,vote,history,read',
            'state' => uniqid(),
            'duration' => 'permanent'
        ];
        
        return $this->auth_host . '?' . http_build_query($parameter);
    }

    /**
     * get user
     * @return [type] [description]
     */
    public function getToken($code) {
        // auth link
        $url = "https://ssl.reddit.com/api/v1/access_token";
        $postData = [
            'code' => $code, 
            'redirect_uri' => $this->_redirect_url,
            'client_id' => $this->_client_id, 
            'grant_type' => 'authorization_code',
        ];

        // extra auth 
        $auth_value = 'Basic ' . base64_encode($this->_client_id .  ':' . $this->_client_secret);
        $curl_extra = [
            CURLOPT_HTTPHEADER => array("Authorization: ".$auth_value),
        ];
        $res = $this->curl_post($url, $postData, $curl_extra);
        $data = json_decode($res);
       
       return $data;
    }

    /**
     * refresh token
     * @return [type] [description]
     */
    public function refreshToken($refreshToken){
        $url = "https://ssl.reddit.com/api/v1/access_token";
        $postData = array(
            'redirect_uri' => $this->_redirect_url,
            'client_id' => $this->_client_id, 
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        );
        // reddit需要额外的auth 认证
        $auth_value = 'Basic ' . base64_encode($this->_client_id .  ':' . $this->_client_secret);
        $curl_extra = [
            CURLOPT_HTTPHEADER => array("Authorization: ".$auth_value),
        ];
        $res = $this->curl_post($url, $postData, $curl_extra);
        return json_decode($res);
    }


    /**
     * get api data
     * @param  array  $parameter [description]
     * @return [type]            [description]
     */
    public function get(array $parameter){
        $this->_access_token = $parameter['token'];

        $url = $this->api_host . $parameter['link'];

        $data = $this->exec($url);
        return $data;
    }

    /**
     * remove posts
     * @return [type] [description]
     */
    public function delete(array $parameter){
        $this->_access_token = $parameter['token'];
        $parameter = [
            'id' => $parameter['id'],
        ];

        $url = $this->api_host . '/api/del';

        $data = $this->exec($url, $parameter);
        return $data;
    }


    /**
     * exec api
     * @return [type] [description]
     */
    public function exec($url, $data = []){
        // extra auth 
        $curl_extra = [
            CURLOPT_HTTPHEADER => [ "Authorization: bearer ".$this->_access_token ],
        ];

        if( count($data) > 0 ){
            $res = $this->curl_post($url, $data, $curl_extra);
        } else {
            $res = $this->curl_get($url, $curl_extra);
        }

        return json_decode($res, true);
    }

    /**
     * curl post
     * @return [type]      [description]
     */
    public function curl_post($url, $data, $curl_extra = []){   
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
    public function curl_get($url, $curl_extra = []) {
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
?>
