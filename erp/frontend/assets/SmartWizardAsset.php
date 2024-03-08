<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SmartWizardAsset extends AssetBundle
{
   //public $basePath = '@webroot';
   //public $baseUrl = '@web';
   public $sourcePath = '@vendor/smartwizard';
   public $css = [
    //---------------------------smart wizard------------------------------------------------------------
       
         'dist/css/smart_wizard_all.min.css'
        
   
   ];
   public $js = [

       
        //------------------------------------smart wizard---------------------------
       'dist/js/jquery.smartWizard.min.js',
        'dist/js/jquery.number.js',
        'dist/js/init.js',
      
      
   ];
   public $depends = [

 
    
      'yii\web\YiiAsset',
      'frontend\assets\PdfTronViewerAsset'

        
     
       
   ];

   public $jsOptions = ['position' => \yii\web\View::POS_END];
}
