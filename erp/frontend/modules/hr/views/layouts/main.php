<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AdminLte3Asset;
$asset=AdminLte3Asset::register($this);
$baseUrl    = $asset->baseUrl;
use frontend\assets\FontAsset;
FontAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <?php $this->head() ?>
    
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/logo.png" type="image/x-icon" />
   
    <style>
   
    </style>
</head>

<body class="hold-transition sidebar-mini pace-primary">
    
 
<?php $this->beginBody() ?>

<div class="wrapper">
   <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/erp/img/logo.png" alt="RACLogo" height="60" width="60">
  </div>

 <?=$this->render('header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?> 
<?= $this->render('leftside.php', ['baserUrl' => $baseUrl]) ?>
<?= $this->render('content.php', ['content' => $content]) ?>
<?= $this->render('footer.php', ['baserUrl' => $baseUrl]) ?>
   
   
</div>

 <div class="modal  fade modal-action" id="modal-action" data-keyboard="false" >
        <div class="modal-dialog modal-lg">
          <div class="modal-content bg-success ">
            <div class="modal-header">
              <h4 id="defaultModalLabel" class="modal-title">Modal Title</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <div style="margin:0 auto; background:white;text-align:center"><img src="/erp/img/m-loader.gif"></div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



<?php $this->endBody() ?>

<script type="text/javascript">

$(document).ready(function($){
 
 jQuery('head link').each( function() { 

jQuery(this).css("cursor","context-menu");
jQuery(this).css("pointer-events","none");
});

 
 
 $('.table  tbody').on('click', '.action-view', function () {
   
var url = $(this).attr('href'); 
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
}); 

$('.action-create').on('click',function () {
   
var url = $(this).attr('href'); 
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
});

$('.action-modal').on('click',function () {
   
var url = $(this).attr('href'); 
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
}); 
 
  var vTable=$('.table').DataTable( {
        retrieve: true,//to be able to reintinialize
	  paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      // responsive: true,
      dom: '<"d-flex justify-content-between mt-3" Blf>'+
       'tr' +
       '<"d-flex justify-content-between"ip>',
     buttons: {
        buttons: [{
          extend: 'print',
          text: '<i class="fas fa-print"></i> Print',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true,
          autoPrint: true
        }, {
          extend: 'pdf',
          text: '<i class="far fa-file-pdf"></i> PDF',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        ,{
          extend: 'excel',
          text: '<i class="far fa-file-excel"></i> Excel',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        
        
        ],
        
        
        dom: {
          container: {
            className: 'dt-buttons'
          },
          button: {
            className: 'btn btn-default dt-button'
          }
        }
      }
		
	
	} );

var table = $('.table-custom').DataTable({
      destroy:true,
      lengthChange: true,
      info: true,
      ordering: false,
      autoWidth: false,
    
      /*columnDefs: [{
        targets: 'sort',
        orderable: true
      }],*/
   dom: '<"row"<"col-sm-4"B><"col-sm-4" l><"col-sm-4"f>>'+
       '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
       '<"row"<"col-sm-5"i><"col-sm-7"p>>',
      fixedHeader: {
        header: true
      },
     
      buttons: {
        buttons: [{
          extend: 'print',
          text: '<i class="fas fa-print"></i> Print',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true,
          autoPrint: true
        }, {
          extend: 'pdf',
          text: '<i class="far fa-file-pdf"></i> PDF',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        ,{
          extend: 'excel',
          text: '<i class="far fa-file-excel"></i> Excel',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        
        
        ],
        
        
        dom: {
          container: {
            className: 'dt-buttons'
          },
          button: {
            className: 'btn btn-default dt-button'
          }
        }
      }
    });	
 
  $('.modal-action').on('hidden.bs.modal', function () {
       
       $('.modal-action .modal-body').empty();
       $('.modal-action .modal-body ').html('<div style="margin:0 auto; background:white; text-align:center"><img src="/erp/img/m-loader.gif"></div>'); 
       
    });
    
     // $('.modal-action').modal({backdrop: 'static', keyboard: false})  

/*$('.modal-action ').on('shown.bs.modal', function() {
  
 $(".select2").select2({theme: 'bootstrap4'});
 
});*/
 
});

var getCleanUrl = function(url) {
  return url.replace(/#.*$/, '').replace(/\?.*$/, '');
};

var route=<?php echo json_encode($this->context->route); ?>;
var qstr=<?php echo json_encode(\Yii::$app->getRequest()->queryString) ;?>;

if(qstr!==''){route+='?'+qstr;}

var base=<?php echo json_encode(Url::base('https')); ?>;

 /** add active class and stay opened when selected */
var url= base+'/'+route;



// for sidebar menu entirely but not cover treeview
$('ul.nav-sidebar a').filter(function() {
 
   return this.href == url;
  
}).addClass('active');


$('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({'display': 'block'})
        .addClass('menu-open').prev('a')
        .addClass('active');


/*// for treeview
$('ul.nav-treeview a').filter(function() {
   return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open');
  
// for treeview
$('ul.nav-treeview a').filter(function() {
   return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").children().addClass('active');*/



</script>

</body>
</html>
<?php $this->endPage() ?>

 

