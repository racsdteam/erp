<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class XeditableAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/x-editable';
  
   public $css = [
        'bootstrap4-editable/css/bootstrap-editable.css'
 
    ];
   
   public $js = [

     'bootstrap4-editable/js/bootstrap-editable.js'
      
      
     
   ];
 
   
    public $depends = [
          'yii\web\YiiAsset',
          'yii\bootstrap\BootstrapAsset',
        
    ];
  
   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_END];
}
