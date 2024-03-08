<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DualListBoxAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/dual-list-box';
  
   public $css = [
        'icon_font/css/icon_font.css',
        'css/jquery.transfer.css'
    ];
   
   public $js = [

     'js/jquery.transfer.js?v=0.0.6'
      
      
     
   ];
 
   
    public $depends = [
        'frontend\assets\AdminLte3Asset',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        
    ];
  
   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_END];
}
