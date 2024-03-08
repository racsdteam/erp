<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DatePickerAsset extends AssetBundle
{
   //public $basePath = '@webroot';
   //public $baseUrl = '@web';
   public $sourcePath = '@vendor/bower/materialadminlte';
   public $css = [
      'https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext',
      'https://fonts.googleapis.com/icon?family=Material+Icons',
      'plugins/node-waves/waves.css',
      'plugins/animate-css/animate.css',
      'plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
      'plugins/waitme/waitMe.css',

  
     
   ];
   public $js = [
       'plugins/jquery/jquery-2.2.3.min.js',
       //'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
       'plugins/autosize/autosize.js',
    'plugins/momentjs/moment.js',
    'dist/js/bootstrap-material-datetimepicker.js',
    //'dist/js/basic-form-elements.js',
   
    
   
      
     
     
      
     
   ];
   public $depends = [
     
       
   ];

   //controlling asset position

   public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
