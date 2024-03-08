<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use app\assets\AppAsset;
//use frontend\assets\AdminLteAsset;
use frontend\assets\MaterialAdminLteAsset;

//AppAsset::register($this);
$asset      = MaterialAdminLteAsset::register($this);
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
   
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
    <?= $this->render('@frontend/views/layouts/header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?>
    <?=$this->render('leftside.php', ['baserUrl' => $baseUrl]) ?>
    <?= $this->render('content.php', ['content' => $content]) ?>
    <?= $this->render('@frontend/views/layouts/footer.php', ['baserUrl' => $baseUrl]) ?>
    <?php// $this->render('rightside.php', ['baserUrl' => $baseUrl]) ?>
    
    <div class="modal modal-info" id="modal-action">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
              <div  id="modalContent"> <div style="text-align:center"><img src="<?=Yii::$app->request->baseUrl?>/img/m-loader.gif"></div></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
   
</div>



<!--footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?//= date('Y') ?></p>

        <p class="pull-right"><?//= Yii::powered() ?></p>
    </div>
</footer-->

<?php $this->endBody() ?>

<script type="text/javascript">


function setUpViewer(){
    
    alert('hello');
}   
  
jQuery(document).ready(function($){
 
   
 
   
   
   
   
   
   $('.user-action').click(function () {
        var url = $(this).attr('href');
 
        
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action #defaultModalLabel').text($(this).attr('title'));
return false;
                        
 // $('#select-person-type-modal.in').modal('hide') 
        });
        
        
$(function () {
 
     $('#modal-action .modal-content').removeAttr('class').addClass('modal-content modal-col-' + 'blue'); 
 
     $('#modal-action').on('hidden.bs.modal', function () {
       
       $('#modal-action .modal-body').empty();
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/mirror/images/m-loader.gif"></div>'); 
    });
});
});






</script>
</body>
</html>
<?php $this->endPage() ?>

 

