<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DataTableAsset extends AssetBundle
{
   //public $basePath = '@webroot';
   //public $baseUrl = '@web';
   public $sourcePath = '@vendor/bower/datatable';
   public $css = [
    'assets/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
    
   
   ];
   public $assets = [


      
       'assets/jquery-datatable/jquery.dataTables.assets',
       'assets/jquery-datatable/skin/bootstrap/assets/dataTables.bootstrap.assets',
       'assets/jquery-datatable/extensions/export/dataTables.buttons.min.assets',
      
       'assets/jquery-datatable/extensions/export/buttons.flash.min.assets',
       'assets/jquery-datatable/extensions/export/assetszip.min.assets',
       'assets/jquery-datatable/extensions/export/pdfmake.min.assets',
       'assets/jquery-datatable/extensions/export/vfs_fonts.assets',
       'assets/jquery-datatable/extensions/export/buttons.html5.min.assets',
       'assets/jquery-datatable/extensions/export/buttons.print.min.assets',
      
      
      
   ];
   public $depends = [

 
   ];

   //public $assetsOptions = ['position' => \yii\web\View::POS_HEAD];
}
