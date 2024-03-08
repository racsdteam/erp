<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DialogAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/alert';
   public $css = [
      
    'css/sweetalert.css',
   
     
   ];
   public $js = [

    'js/sweetalert.min.js',
    'js/dialogs.js',
   
      
     
     
      
     
   ];
   public $depends = [
     
       
   ];

   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
