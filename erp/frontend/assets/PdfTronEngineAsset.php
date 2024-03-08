<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PdfTronEngineAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      
    ];
    public $js = [
        'lib/webviewer.min.js',
       // 'lib/old-browser-checker.js',
       
    ];
   
    public $depends = [
       //'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];
     public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
