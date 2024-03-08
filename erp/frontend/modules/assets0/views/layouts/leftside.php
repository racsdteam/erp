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
  <aside class="main-sidebar sidebar-dark-green elevation-4">
    <!-- Brand Logo -->
    <a href="<?=Url::to(['/site'])?>" class="brand-link navbar-warning">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">RAC Assets  </span>
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
           <i class="nav-icon fas fa-toolbox"></i>
              <p>
              Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                
               <li class="nav-item">
                <a href="<?=Url::to(['asset-types/index'])?>" title="Asset Types " 
                class="nav-link">
               <i class="nav-icon fas fa-cog"></i>
                  <p>Asset Types</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['asset-conditions/index'])?>" title="Assets Conditions " 
                class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                  <p>Asset Conditions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['asset-statuses/index'])?>" title="Assets Statuses " 
                class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                  <p>Asset Statuses</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['asset-dspl-reasons/index'])?>" title="Asset Disposal Reasons " 
                class="nav-link">
                 <i class="nav-icon fas fa-cog"></i>
                  <p>Disposal Reasons</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="<?=Url::to(['asset-sec-categories/index'])?>" title="Asset Security Categories " 
                class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                  <p>Asset Security Categories</p>
                </a>
              </li>   
             
            </ul>
          </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-laptop-house"></i>
              <p>
              Assets
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <?php
            if($user->isAdminUser()):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['assets/create'])?>" title="Add New Asset " 
                class="nav-link">
                 <i class="nav-icon fas fa-plus-circle"></i>
                  <p>Add Asset</p>
                </a>
              </li>
              <?php 
              endif
              ?>
               <li class="nav-item">
                <a href="<?=Url::to(['assets/index'])?>" title="Assets List " 
                class="nav-link">
                 <i class="nav-icon fas fa-database"></i>
                  <p>Assets List</p>
                </a>
              </li>
                   <?php
            if($user->isAdminUser()):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['asset-allocations/index'])?>" title="Allocated" 
                class="nav-link">
                  <i class="nav-icon fas fa-people-carry"></i>
                  <p>Allocated</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['asset-dispositions/index'])?>" title="Disposed" 
                class="nav-link">
                  <i class="nav-icon fas fa-dumpster"></i>
                  <p>Disposed</p>
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
  
  