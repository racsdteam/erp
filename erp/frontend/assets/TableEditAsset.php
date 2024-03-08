<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class TableEditAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/jquery-tabledit';
  
   public $css = [
      
 
    ];
   
   public $js = [

     'jquery.tabledit.js'
      
      
     
   ];
 
   
    public $depends = [
          'yii\web\YiiAsset',
          'yii\bootstrap\BootstrapAsset',
        
    ];
  
   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_END];
}
