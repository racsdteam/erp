<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class VueAsset extends AssetBundle
{
   
   public $sourcePath = '@vendor/bower/vue';
  
   public $js = [

     'vue.js',
       'axios.min.js',
      
     
   ];
   public $depends = [
     
       
   ];

   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
