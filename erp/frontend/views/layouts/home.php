<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AdminLte3Asset;
$asset=AdminLte3Asset::register($this);
$baseUrl    = $asset->baseUrl;


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
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
    
    <style>
     
    </style>
</head>

<body class="hold-transition  layout-top-nav  accent-success pace-flash-primary">
    
 
<?php $this->beginBody() ?>

<div class="wrapper">
 
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/logo.png" alt="RACLogo" height="60" width="60">
  </div>


 <?=$this->render('header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?> 
<?= $this->render('content.php', ['content' => $content]) ?>
<?= $this->render('footer.php', ['baserUrl' => $baseUrl]) ?>
   
   
</div>

 <div class="modal fade" id="modal-action">
        <div class="modal-dialog modal-lg">
          <div class="modal-content bg-success">
            <div class="modal-header">
              <h4 class="modal-title">Success Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
           <div style="margin:0 auto; background:white;text-align:center"><img src="/erp/img/m-loader.gif"></div>  
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
             
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





<?php $this->endBody() ?>

<script type="text/javascript">

$(document).ready(function($){
 
  
   
$('.table  tbody').on('click', '.action-view', function () {
   
var url = $(this).attr('href'); 
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
}); 
 
 
  $('.modal-action').on('hidden.bs.modal', function () {
       
       $('.modal-action .modal-body').empty();
       $('.modal-action .modal-body ').html('<div style="margin:0 auto; background:white; text-align:center"><img src="/erp/img/m-loader.gif"></div>'); 
       
    });
    
    var route=<?php echo json_encode($this->context->route); ?>;
var base=<?php echo json_encode(Url::base('https')); ?>;

 /** add active class and stay opened when selected */
var url= base+'/'+route;


// for sidebar menu entirely but not cover treeview
$('ul.nav-sidebar a').filter(function() {
   
   return this.href == url;
}).addClass('active');



// for treeview
$('ul.nav-treeview a').filter(function() {
   return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').children().addClass('active');
 
 $('.table').DataTable( {
	  paging: true,
	  responsive: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      dom: 'Bfrtip',
      buttons: [ 'copy', 'excel', 'pdf','print' ],
		
	
	} );
	

  
 
});



</script>

</body>
</html>
<?php $this->endPage() ?>

 



