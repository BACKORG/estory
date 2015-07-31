<?php  
namespace zhexiao\wordpress;

use zhexiao;

/**
* wordpress xmlrpc libs
*/
class zxWordpress{
    private $xmlrpc_url = null;
    private $username  = null;
    private $password = null;

    // save the user credential
    private $credential = [];

    // pass parameters
    private $parameters = [];

    // call method name
    private $methodName;

    // response data
    private $resDt = [];

    /**
     * construct
     * @param [type] $xmlrpcurl [description]
     * @param [type] $username  [description]
     * @param [type] $password  [description]
     */
    public function __construct($xmlrpcurl, $username, $password) {
        $this->xmlrpc_url = $xmlrpcurl;
        $this->username  = $username;
        $this->password = $password;

        $this->credential = [
            0,
            $this->username,
            $this->password
        ];
    } 

    public function getUser(){
        $this->methodName = 'metaWeblog.getUsersBlogs';

        $xml = $this->_postData();

        // load xml string
        $xmlObj = simplexml_load_string($xml);

        // parse string
        if(isset($xmlObj->params->param->value->array->data->value->struct->member)){
            $member = $xmlObj->params->param->value->array->data->value->struct->member;
            foreach ($member as $val) {
                $this->resDt[(string)$val->name] = (string)$val->value->string;
            }
        }

        return $this->resDt;
    }


    /**
     * create a new post
     * @param  [type] $title    [description]
     * @param  [type] $body     [description]
     * @param  [type] $category [description]
     * @param  string $keywords [description]
     * @param  string $encoding [description]
     * @return [type]           [description]
     */
    public function newPost($parameters){
        $this->methodName = 'metaWeblog.newPost';

        $this->parameters = [
            'title' => $parameters['title'],
            'description' => $parameters['description'],
            'mt_allow_comments' => 0,  
            'mt_allow_pings' => 0,  
            'post_type' => 'post',
        ];

        // keyword exist
        if(isset($parameters['keywords'])){
            $this->parameters['mt_keywords'] = $parameters['keywords'];
        }

        // category exist
        if(isset($parameters['category'])){
            $this->parameters['categories'] = $parameters['category'];
        }

        $xml = $this->_postData();   

        // load xml string
        $xmlObj = simplexml_load_string($xml);

        // parse string
        if(!isset($xmlObj->params->param->value)){
           throw new \Exception("No Data Response", 1);
        }else{
            $this->resDt['id'] = (string)$xmlObj->params->param->value->string;
        }

        return $this->resDt;
    }

    /**
     * generate the xml rpc 
     * @return [type] [description]
     */
    private function generateXmlrpc(){
        $xml = new \SimpleXMLElement('<xml />');
        $methodCall = $xml->addChild('methodCall');

        // method name
        $methodCall->addChild('methodName', $this->methodName);

        // params
        $params = $methodCall->addChild('params');

        // add credential 
        foreach ($this->credential as $val) {
            $ct = $params->addChild('param');
            $value = $ct->addChild('value');
            if(gettype($val) == 'integer'){
                $type = 'int';
            }else{
                $type = gettype($val);
            }
            $value->addChild($type, $val);
        }

        // add post content
        if(count($this->parameters) > 0){
            $postDt = $params->addChild('param');
            $pvalue = $postDt->addChild('value');
            $pstruct = $pvalue->addChild('struct');
            foreach ($this->parameters as $key => $val) {
                $member = $pstruct->addChild('member');
                $member->addChild('name', $key);
                $mv = $member->addChild('value');

                if(gettype($val) == 'integer'){
                    $type = 'int';
                }else{
                    $type = gettype($val);
                }
                $mv->addChild($type, $val);
            }
        }
       
        // publish the post, set to true
        $lt = $params->addChild('param');
        $lv = $lt->addChild('value');
        $lv->addChild(gettype(true), (int)true);

        // save as xml
        $xmlDt = $xml->asXML();

        // remove <xml> and </xml> tags
        $searchDt = [ '<xml>', '</xml>'];

        $xmlDt = str_replace($searchDt, '', $xmlDt);
        return $xmlDt;
    }

    /**
     * post data 
     * @return [type] [description]
     */
    private function _postData(){
        $resDt = [];

        // generate the xmlrpc xml data
        $data = $this->generateXmlrpc();  
        
        // send request
        $res = $this->sendPost($data);

        return $res;
    }


    /**
     * send post data
     * @param  [type] $methodName [description]
     * @param  [type] $params      [description]
     * @return [type]              [description]
     */
    public function sendPost($data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_URL, $this->xmlrpc_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $results = curl_exec($ch);
        curl_close($ch);

        return $results;
    }
}
?>