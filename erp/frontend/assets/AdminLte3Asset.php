<?php
namespace frontend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLte3Asset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/adminlte3';
    public $css = [
        //--------------------------theme css---------------------------------------//
       // 'plugins/fontawesome-free/css/all.min.css',
        'dist/css/ionicons.min.css',
        'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'plugins/jqvmap/jqvmap.min.css',
        'dist/css/adminlte.min.css',
        'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'plugins/daterangepicker/daterangepicker.css',
        'plugins/summernote/summernote-bs4.css',
        //-----------------datatabale--------------------------------
        'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        //---------------respo datatable-------------------------------
        'plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css',
        'plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        //-----------------datatable buttons---------------------------------
        'plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
        //-------------datatable checkboxes-------------------------------------
         //--------------------datatable sect--------------------------------
        'plugins/datatables-select/css/select.dataTables.min.css',
        'plugins/datatables-checkboxes/css/dataTables.checkboxes.css',
        
        'plugins/toastr/toastr.min.css',
        //------------------pace progress---------------------------------------
        'plugins/pace-progress/themes/black/pace-theme-flat-top.css',
      //---------------select2-----------------------------------------------------
       'plugins/select2/css/select2.min.css',
       'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
       //-------------------icheck-------------------------------------
       'plugins/icheck-bootstrap/icheck-bootstrap.min.css',

       
       //--------------------------------------custom---------------------------------//
       
        'dist/css/timeline.css',
        'dist/css/timeline2.css',
        'dist/css/timelinebs4.css',
        'dist/css/bootstrap-material-datetimepicker.css',
        'dist/css/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'dist/css/bootstrap-daterangepicker/daterangepicker.css',
       
        
       
    ];
    public $js = [
        
        'plugins/jquery-ui/jquery-ui.min.js',
        'dist/js/jqui.js',
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'plugins/chart.js/Chart.min.js',
        'plugins/sparklines/sparkline.js',
        'plugins/jqvmap/jquery.vmap.min.js',
        'plugins/jqvmap/maps/jquery.vmap.usa.js',
        'plugins/jquery-knob/jquery.knob.min.js',
        'plugins/moment/moment.min.js',
        'plugins/daterangepicker/daterangepicker.js',
        'dist/js/custom/bootstrap-material-datetimepicker.js',
        'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
        'plugins/summernote/summernote-bs4.min.js',
        'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        'plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        //--------------------------datatable------------------------------------
        'plugins/datatables/jquery.dataTables.min.js',
        'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        
        //-------------------------respo datatable--------------------------------
        'plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js',
        'plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js',
        'plugins/datatables-responsive/js/dataTables.responsive.min.js',
        'plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        
       
        //-----------------buttons----------------------------------
        
        'plugins/datatables-buttons/js/dataTables.buttons.min.js',
        'plugins/datatables-buttons/js/buttons.html5.min.js',
        'plugins/datatables-buttons/js/buttons.print.min.js',
        'plugins/datatables-buttons/js/buttons.colVis.min.js',
        
        //-----------------check boxes------------------------
         'plugins/datatables-select/js/dataTables.select.min.js',
         'plugins/datatables-checkboxes/js/dataTables.checkboxes.min.js',
         
        
        
        //'plugins/pdfmake/pdfmake.min.js',
        'plugins/pdfmake/vfs_fonts.js',
        'plugins/jszip/jszip.min.js',
        //---------------------------------------------------------------------------------
        'plugins/toastr/toastr.min.js',
        'dist/js/adminlte.js',
        
        //-------------------------------select2 js-----------------------------------
        'plugins/select2/js/select2.full.min.js',
        //----------pace process js--------------------------------------------------
        'plugins/pace-progress/pace.min.js',
       
       //-----------------------custom------------------------------- 
        'dist/js/custom/material.min.js',
        'dist/js/custom/ripples.min.js',
        'dist/js/custom/highcharts.js',
        //'dist/js/custom/highcharts-3d.js',
        'dist/js/custom/exporting.js',
        'dist/js/custom/export-data.js',
        'dist/js/custom/accessibility.js',
        'dist/js/jquery.number.js',
        //----------------dyanamic rows-----------------------------------
        'plugins/rows-dynamic/js/dynamicrows.js',
      
     
       
        
    ];
    public $depends = [
        
        
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'frontend\assets\Fontawesome5Asset',
        'dosamigos\tinymce\TinyMceAsset',
        'frontend\assets\PdfTronViewerAsset',
        'frontend\assets\DialogAsset',
        'frontend\assets\VueAsset',
    ];

 
}
