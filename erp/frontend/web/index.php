<?php

//enable cors
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); 
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); 
header('Access-Control-Allow-Credentials: true'); 
header('Access-Control-Allow-Headers: Content-Type,ContentContent-Length,Accept-Encoding,X-Requested-with, Origin');
header('Access-Control-Expose-Headers:  Content-Range');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php'
);

(new yii\web\Application($config))->run();
