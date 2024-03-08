<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class TimeLineAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/bs4-timeline';
  
   public $css = [
       
   'css/bs4-timeline.css'
    ];
   
   public $js = [

    
      
      
     
   ];
 
   
    public $depends = [
          'yii\web\YiiAsset',
          'yii\bootstrap\BootstrapAsset',
        
    ];
  
   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
