<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PdfTronViewerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
   
  
    
    public $css = [
       
       'css/viewer.css',
       
       
        
    ];
    public $js = [
        
        'lib/viewer.js',
        'lib/stamp.js',
      
    ];
    public $depends = [
         
         'frontend\assets\PdfTronEngineAsset',
     
    ];
   
  //-----------prevent caching--------------------------------------- 
    public $publishOptions = [
    //'forceCopy' => true,
];
    
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}
