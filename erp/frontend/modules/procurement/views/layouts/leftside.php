<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\UserHelper;
use common\models\User;
use frontend\modules\hr\models\EmployeeStatuses;

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
                                
 


?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=Url::to(['/site'])?>" class="brand-link navbar-info ">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">RAC Procurement  </span>
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
              <i class="far fa-calendar-alt nav-icon"></i> 
              <p>
              Manage APPs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              
               <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/planning'])?>" title="New Security Group " 
                class="nav-link">
                <i class="fas fa-edit nav-icon"></i>
                  <p>Planning APPs</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/submitted'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-paper-plane nav-icon"></i>
                  <p> Submitted APPs</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['procurement-plan-approvals/pending'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-inbox nav-icon"></i>
                  <p> My APPs Approvals</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/approved'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>Approved APPs</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/published'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-newspaper nav-icon"></i> 
                  <p>Published APPs</p>
                </a>
              </li>
              
               
              <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All APPs</p>
                </a>
              </li>
              
              
            
            </ul>
          </li>
          
            <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-file-prescription nav-icon"></i> 
              <p>
               Manage Tenders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['tenders/create'])?>" title="All Security Groups" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i> 
                  <p>Create Tender</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['tenders/draft'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-edit nav-icon"></i> 
                  <p>Draft Tenders</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['tenders/my-leave'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> Submitted Tenders</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['leave-approval-task-instances/my-approvals'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-newspaper nav-icon"></i> 
                  <p>Published Tenders</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['leave-approval-task-instances/pending'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>In Evaluation</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['leave-approval-task-instances/pending'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>Awarded Tenders</p>
                </a>
              </li>
             
              
               <li class="nav-item">
                <a href="<?=Url::to(['leave-approval-task-instances/my-approvals'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-newspaper nav-icon"></i> 
                  <p>Canceled Tenders</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['tenders/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Tenders</p>
                </a>
              </li>
              
              
            
            </ul>
          </li>
      
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
               <i class="fas fa-cogs nav-icon"></i> 
              <p>
              Configurations
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['procurement-categories/index'])?>" title="All Security Groups" class="nav-link">
                  <i class="fas fa-database  nav-icon"></i>
                  <p>Procurement Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['procurement-methods/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>Procurement Methods</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['procurement-date-types/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>Procurement Date Types</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['funding-sources/index'])?>" title="Setting Fundin" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Funding Sources</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['tender-stages/index'])?>" title="tender stages" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Tender Stages</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['tender-stage-settings/index'])?>" title="Setting tender stages" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Tender Stages Settings</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['currencies/index'])?>" title="Setting currencies" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Currencies</p>
                </a>
              </li>  
              </li>
              <li>
              <a href="<?=Url::to(['envelope-setting/index'])?>" title="Setting Envelope" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Envelope</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['section-settings/index'])?>" title="Setting Section" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Sections</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['documents-settings/index'])?>" title="Setting Documents" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Documents</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['incoterms-setting/index'])?>" title="Setting Documents" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>INCOTERMS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['tender-item-types-setting/index'])?>" title="Setting Documents" class="nav-link">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>Tender Item Types</p>
                </a>
              </li>
            </ul>
          </li>
          
          
       
           
        
            
          
            
            </ul>
          </li>
      
      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  