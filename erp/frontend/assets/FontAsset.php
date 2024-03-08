<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" ,
        "https://fonts.googleapis.com/icon?family=Material+Icons" ,
        "https://fonts.googleapis.com/css2?family=Lato&display=swap"
    ];
   
   
    public $cssOptions = [
        'type' => 'text/css',
    ];
}
