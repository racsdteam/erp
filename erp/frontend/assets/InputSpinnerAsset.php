<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class InputSpinnerAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/bootstrap-input-spinner';
  
   public $css = [
       
 
    ];
   
   public $js = [

     'js/bootstrap-input-spinner.js'
      
      
     
   ];
 
   
    public $depends = [
          'yii\web\YiiAsset',
          'yii\bootstrap\BootstrapAsset',
        
    ];
  
   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_END];
}
