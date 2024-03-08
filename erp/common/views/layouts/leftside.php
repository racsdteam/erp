<?php


use yii\helpers\Html;
use yii\helpers\Url;


?>

<?php

$user=Yii::$app->user->identity;
$user_image=$user->user_image;
$path='';
 if($user_image!='' && file_exists('@web/'.$user_image)){
                                         
    $path='@web/'.$user_image;   
    
}else{
                                         
    $path='@web/img/avatar-user.png';    
   
    }                                    
                               
                                     
?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=Url::to(['/'])?>" class="brand-link navbar-info">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">
         <?= $title?>

</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         
           <?= Html::img($path, ['class' => 'img-circle elevation-2', 'alt'=>'User Image']) ?>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$user->first_name." ".$user->last_name?></a>
        
        </div>
      </div>
     

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <?php if (isset($this->blocks['sidebar-menu'])): ?>
    <?= $this->blocks['sidebar-menu'] ?>
<?php else: ?>
    
<?php endif; ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  