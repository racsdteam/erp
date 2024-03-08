<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PopperAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/adminlte3';
   public $css = [
    
   ];
   public $js = [
  'plugins/popper/umd/popper.min.js',
   
      
     
     
      
     
   ];
   public $depends = [
     
       
   ];

   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_END];
}
