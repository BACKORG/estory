<?php  
namespace zhexiao\helper;

use zhexiao;

/**
* my helper functions
*/
class zxHelper{
    public static function outputJson($data){
        echo \yii\helpers\Json::encode($data);
    }
}
?>