<?php
namespace zhexiao\rss;

/**
* Parse rss
*/
class zxRss{
    // parse url
    private $_url;

    // simplexml object
    private $_xml;

    // data object
    private $_xmlDt;

    // return array
    private $_return = [];

    /**
     * [__construct description]
     * @param [type] $url [parse url]
     */
    function __construct($url){
        $this->_url = $url;
    }

    /**
     * get data
     * @return [type] [description]
     */
    public function get(){
        $page = $this->curl_get();
        $this->_xml = simplexml_load_string($page); 
       
        $this->loopXml();

        return $this->_return;
    }

    /**
     * loop simplexml object
     * @return [type] [description]
     */
    private function loopXml(){
        foreach ($this->_xml as $xK => $xObj) {
            switch ($xK) {
                case 'channel':
                    $this->_xmlDt = $this->_xml->{$xK};
                    $this->loopChannel();
                break;
            }
        }
    }

    /**
     * loop channel
     * @return [type] [description]
     */
    private function loopChannel(){
        // get rss info
        $arr = $this->getRssInfo($this->_xmlDt);

        // merge to return array
        $this->_return = $this->_return + $arr;

        // loop items
        $this->loopItems();
    }

    /**
     * get rss info
     */
    private function getRssInfo($dt){
        $arr = [];

        // rss title
        if(isset($dt->title)){
            $arr['title'] = (string)$dt->title;
        }

        // rss link
        if(isset($dt->link)){
            $arr['link'] = (string)$dt->link;
        }

        // rss description
        if(isset($dt->description)){
            $arr['description'] = (string)$dt->description;
        }

        // rss image
        if(isset($arr['description'])){
            preg_match('/<img[^>]+src="(.*?)"[^>]*>/i', $arr['description'], $matches);
            if(count($matches) > 0){
                $arr['image'] = $matches[1];

                // remove the image from description            
                $arr['description'] = preg_replace('/(<img[^>]+>)/i', '', $arr['description']);
            }
        }

        // rss date
        if(isset($dt->pubDate)){
            $arr['datetime'] = strtotime($dt->pubDate);
        }else{
            // parse dc:date
            $dc = $dt->children('http://purl.org/dc/elements/1.1/');
            $arr['datetime'] = strtotime($dc->date);
        }

        return $arr;
    }

    /**
     * loop items
     */
    private function loopItems(){
        // if exist item
        if(isset($this->_xmlDt->item) && count($this->_xmlDt->item) > 0){
            $itemsDt = $this->_xmlDt->item;
        }

        $i = 0;
        foreach ($itemsDt as $iObj) {         
            $this->_return['items'][$i] = [];

            // get item data
            $arr = $this->getRssInfo($iObj);
            // merge to array
            $this->_return['items'][$i] = $this->_return['items'][$i] + $arr;

            ++$i;
        }
    }

    /**
     * debug data
     * @return [type] [description]
     */
    public function debug(){
        echo '<pre>';
        print_r($this->_xml);
        echo '</pre>';
    }


    /**
     * curl get data 
     * @return [type] [description]
     */
    public function curl_get() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_MAXREDIRS      , 5);

        $result  = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}