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
            <li class="nav-item">
                <a href="<?=Url::to(['event-categories/index'])?>" title="Event-Categories" 
                class="nav-link">
               
                 <i class="nav-icon fas fa-list"></i>
                  <p> Event Categories </p>
                </a>
              </li>
         
      
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="far fa-calendar-alt nav-icon"></i> 
              <p>
              Events 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/create'])?>" title="All Security Groups" class="nav-link">
                  <i class="fas fa-edit  nav-icon"></i>
                  <p>Incoming</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/draft'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-calendar-plus nav-icon"></i> 
                  <p>Reviewed</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['procurement-plans/my-plans'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-calendar-check nav-icon"></i>
                  <p>Completed</p>
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
  
  