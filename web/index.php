<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');


// define social constants
define('TWITTER_ACCOUNT', 10);
define('INSTAGRAM_ACCOUNT', 20);
define('YOUTUBE_ACCOUNT', 30);
define('REDDIT_ACCOUNT', 40);
define('VIMEO_ACCOUNT', 50);

// define cache constants
define('CACHE_TIME', 60);


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
