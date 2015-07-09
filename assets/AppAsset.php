<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/index.css',
    ];

    public $js = [
        'js/libs/angular.min.js',
        'js/libs/angular-route.min.js',
        'js/libs/angular-sanitize.min.js',
        'js/libs/bootstrap.min.js',
        'js/libs/jquery.magnific-popup.min.js',
        'js/libs/jquery.easing.js',
        'js/app.js',
        'js/controller.js'
    ];

    public $depends = [
    ];
}
