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
    } 

    /**
     * create a blog
     * @param  [type] $title    [description]
     * @param  [type] $body     [description]
     * @param  [type] $category [description]
     * @param  string $keywords [description]
     * @param  string $encoding [description]
     * @return [type]           [description]
     */
    function create_post($parameters, $encoding='UTF-8'){
        $title = htmlentities($parameters['title'], ENT_NOQUOTES, $encoding);
            
        $content = [
            'title' => $title,
            'description' => $parameters['description'],
            'mt_allow_comments' => 0,  
            'mt_allow_pings' => 0,  
            'post_type' => 'post',
        ];

        if(isset($parameters['keywords'])){
            $keywords = htmlentities($parameters['keywords'], ENT_NOQUOTES, $encoding);
            $content['mt_keywords'] = $keywords;
        }

        if(isset($parameters['category'])){
            $content['categories'] = $parameters['category'];
        }

        $params = array(0,$this->username, $this->password, $content, true);
     
        return $this->send_request('metaWeblog.newPost', $params);
    }

    /**
     * send request
     * @param  [type] $requestname [description]
     * @param  [type] $params      [description]
     * @return [type]              [description]
     */
    public function send_request($requestname, $params){
        $request = xmlrpc_encode_request($requestname, $params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_URL, $this->xmlrpc_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $results = curl_exec($ch);
        curl_close($ch);
        return $results;
    }

    /**
     * all wp xmlrpc functions
     * @return [type] [description]
     */
    private function wp_xmlrpc_server() {
        $this->methods = [
            // WordPress API
            'wp.getUsersBlogs'      => 'this:wp_getUsersBlogs',
            'wp.getPage'            => 'this:wp_getPage',
            'wp.getPages'           => 'this:wp_getPages',
            'wp.newPage'            => 'this:wp_newPage',
            'wp.deletePage'         => 'this:wp_deletePage',
            'wp.editPage'           => 'this:wp_editPage',
            'wp.getPageList'        => 'this:wp_getPageList',
            'wp.getAuthors'         => 'this:wp_getAuthors',
            'wp.getCategories'      => 'this:mw_getCategories',      // Alias
            'wp.getTags'            => 'this:wp_getTags',
            'wp.newCategory'        => 'this:wp_newCategory',
            'wp.deleteCategory'     => 'this:wp_deleteCategory',
            'wp.suggestCategories'  => 'this:wp_suggestCategories',
            'wp.uploadFile'         => 'this:mw_newMediaObject', // Alias
            'wp.getCommentCount'    => 'this:wp_getCommentCount',
            'wp.getPostStatusList'  => 'this:wp_getPostStatusList',
            'wp.getPageStatusList'  => 'this:wp_getPageStatusList',
            'wp.getPageTemplates'   => 'this:wp_getPageTemplates',
            'wp.getOptions'         => 'this:wp_getOptions',
            'wp.setOptions'         => 'this:wp_setOptions',
            'wp.getComment'         => 'this:wp_getComment',
            'wp.getComments'        => 'this:wp_getComments',
            'wp.deleteComment'      => 'this:wp_deleteComment',
            'wp.editComment'        => 'this:wp_editComment',
            'wp.newComment'         => 'this:wp_newComment',
            'wp.getCommentStatusList' => 'this:wp_getCommentStatusList',
            'wp.getMediaItem'       => 'this:wp_getMediaItem',
            'wp.getMediaLibrary'    => 'this:wp_getMediaLibrary',
            'wp.getPostFormats'     => 'this:wp_getPostFormats',
     
            // Blogger API
            'blogger.getUsersBlogs' => 'this:blogger_getUsersBlogs',
            'blogger.getUserInfo' => 'this:blogger_getUserInfo',
            'blogger.getPost' => 'this:blogger_getPost',
            'blogger.getRecentPosts' => 'this:blogger_getRecentPosts',
            'blogger.getTemplate' => 'this:blogger_getTemplate',
            'blogger.setTemplate' => 'this:blogger_setTemplate',
            'blogger.newPost' => 'this:blogger_newPost',
            'blogger.editPost' => 'this:blogger_editPost',
            'blogger.deletePost' => 'this:blogger_deletePost',
     
            // MetaWeblog API (with MT extensions to structs)
            'metaWeblog.newPost' => 'this:mw_newPost',
            'metaWeblog.editPost' => 'this:mw_editPost',
            'metaWeblog.getPost' => 'this:mw_getPost',
            'metaWeblog.getRecentPosts' => 'this:mw_getRecentPosts',
            'metaWeblog.getCategories' => 'this:mw_getCategories',
            'metaWeblog.newMediaObject' => 'this:mw_newMediaObject',
     
            // MetaWeblog API aliases for Blogger API
            // see http://www.xmlrpc.com/stories/storyReader$2460
            'metaWeblog.deletePost' => 'this:blogger_deletePost',
            'metaWeblog.getTemplate' => 'this:blogger_getTemplate',
            'metaWeblog.setTemplate' => 'this:blogger_setTemplate',
            'metaWeblog.getUsersBlogs' => 'this:blogger_getUsersBlogs',
     
            // MovableType API
            'mt.getCategoryList' => 'this:mt_getCategoryList',
            'mt.getRecentPostTitles' => 'this:mt_getRecentPostTitles',
            'mt.getPostCategories' => 'this:mt_getPostCategories',
            'mt.setPostCategories' => 'this:mt_setPostCategories',
            'mt.supportedMethods' => 'this:mt_supportedMethods',
            'mt.supportedTextFilters' => 'this:mt_supportedTextFilters',
            'mt.getTrackbackPings' => 'this:mt_getTrackbackPings',
            'mt.publishPost' => 'this:mt_publishPost',
     
            // PingBack
            'pingback.ping' => 'this:pingback_ping',
            'pingback.extensions.getPingbacks' => 'this:pingback_extensions_getPingbacks',
     
            'demo.sayHello' => 'this:sayHello',
            'demo.addTwoNumbers' => 'this:addTwoNumbers'
        ];
    }
}
?>