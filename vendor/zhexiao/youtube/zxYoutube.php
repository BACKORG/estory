<?php  
namespace zhexiao\youtube;

use zhexiao;

/**
* Youtube library (php)
*/
class zxYoutube{
    private $_api_http = 'https://www.googleapis.com/youtube/v3';

    private $_google_api_key;

    /**
     * class construct
     */
    public function __construct($api_key){
        $this->_google_api_key = $api_key;
    }

    /**
     * youtube search
     * @return [type] [description]
     */
    public function search(array $parameters){
        $defaultParameters = [
            'safeSearch' => 'moderate',
            'type' => 'video',
            'maxResults' => 20,
            'part' => 'snippet',
            'key' => $this->_google_api_key
        ];

        $newParameters = $parameters + $defaultParameters;

        $url = $this->_api_http . '/search?' . http_build_query($newParameters);

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