<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\UserHelper;
use common\models\User
?>

<?php

  $user=Yii::$app->user->identity;
  $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
  $userposition=$userinfo['position_code'];

  $user_image=$user->user_image;
  $path='';
 if($user_image!='' && file_exists('@web/'.$user_image)){
                                         
    $path='@web/'.$user_image;   
    
}else{
                                         
    $path='@web/img/avatar-user.png';    
   
    }                                    
                                 
 $employee=Yii::$app->empUtil->getEmpByUser(Yii::$app->user->identity->user_id); 


 $empCreateUrl=Url::to(['employees/create']);
 $typeMode=(isset($this->params['typeMode'])&& $this->params['typeMode']!=null)?$this->params['typeMode']:null;
 $typeEmp=(isset($this->params['typeEmp'])&& $this->params['typeEmp']!=null)?$this->params['typeEmp']:null;

if($typeMode!=null && $typeEmp!=null){
  $empCreateUrl=Url::to(['employees/create','mode'=>$typeMode,'empType'=>$typeEmp]);  
    
}


?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=Url::to(['/site'])?>" class="brand-link navbar-gray">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">RAC HR  </span>
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
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
         <li class="nav-header">NAVIGATION MENU</li>
    
             <li class="nav-item">
                <a href="<?=Url::to(['default/index'])?>" title="Dashboard" 
                class="nav-link">
               
                 <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p> Dashboard </p>
                </a>
              </li>
         
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-hand-holding-medical nav-icon"></i>
              <p>
              RCR
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <?php
            if($user->isAdminUser() || $user->isRCR_Ass_User()):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['aerodrome-condition-report/not-shared'])?>" title="Not shared RCR " 
                class="nav-link">
                  <i class="fas fa-drafting-compass nav-icon"></i>
                  <p>Unshared Reports</p>
                </a>
              </li>
              <?php 
              endif
              ?>
               <li class="nav-item">
                <a href="<?=Url::to(['aerodrome-condition-report/shared'])?>" title="shared RCR " 
                class="nav-link">
                  <i class="fas fa-drafting-compass nav-icon"></i>
                  <p>Shared Reports</p>
                </a>
              </li>
                   <?php
            if($user->isAdminUser()):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['aerodrome-info/index'])?>" title="Aerodrome Info" 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>Aerodrome Information</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['aerodrome-condition-type/index'])?>" title="Aerodrome Condition Type" 
                class="nav-link">
                  <i class="fas fa-inbox nav-icon"></i>
                  <p>Condition Type</p>
                </a>
              </li>
                  <li class="nav-item">
                <a href="<?=Url::to(['aerodrome-segment/index'])?>" title="Aerodrome Segment" 
                class="nav-link">
                  <i class="fas fa-inbox nav-icon"></i>
                  <p>Aerodrome Segments</p>
                </a>
              </li>
              <?php
              endif;
              ?>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  