<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\UserHelper;
use common\models\User;

?>

<style>
    
    .nav-link-box{text-align:center;
      
       border-radius:0 !important;
   }
</style>

<?php

  $user=Yii::$app->user->identity;
  $muser=Yii::$app->muser;
  $userPos=$muser->getPosInfo(Yii::$app->user->identity->user_id); 
  $auctModule=Yii::$app->getModule('auction');
  

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
    <a href="<?=Url::to(['/site'])?>" class="brand-link navbar-info">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">RAC ERP</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
  <ul class="nav nav-pills nav-sidebar flex-column mt-2" data-widget="treeview" role="menu" data-accordion="false">
      <?php if($user->user_level==User::ROLE_ADMIN): ?>
         <li class="nav-item mb-2">
            <a href="<?=Url::to(['/user']) ?>" class="nav-link nav-link-box bg-secondary" role="button">
              <span style="font-size:0.5rem;"><i class="fa fa-users fa-3x"></i></span></br>
              <p>
               Users Accounts
                
              </p>
            </a>
          </li>
          
          <?php endif;?>
           <li class="nav-item mb-2">
            <a href="<?=Url::to(['/doc']) ?>" class="nav-link nav-link-box bg-teal elevation-2" role="button">
                               <i class="fas fa-file-signature fa-3x"></i><br/>
                               <p>Documents & Approvals </p></a>
          </li>
           <li class="nav-item mb-2">
            <a href="<?=Url::to(['/racdms']) ?>" class="nav-link  nav-link-box bg-warning  " role="button" >
                               <span style="font-size:0.5rem;"><i class="far fa-folder-open fa-3x" aria-hidden="true"></i></span><br/>
                               <p>Documents Mgmt System</p></a>
          </li>
          <?php if($auctModule->canView($user)): ?>
           
            <li class="nav-item mb-2">
            <a  href="<?=Url::to(['/auction']) ?>" class="nav-link nav-link-box bg-info elevation-2" role="button">
                               <span style="font-size:0.5rem;"><i class="fas fa-gavel fa-3x"></i></i></span><br/>
                               <p>Auction</p></a>
          </li>
          <?php endif;?>
           
           <li class="nav-item mb-2">
            <a  href="<?=Url::to(['/hr']) ?>" class="nav-link nav-link-box  bg-success " role="button">
                               <span style="font-size:0.5rem;"><i class="fas fa-users-cog fa-3x"></i></span><br/>
                               <p>Human Resource</p></a>
          </li>
           <li class="nav-item mb-2">
            <a  href="<?=Url::to(['/logistic']) ?>" class="nav-link nav-link-box bg-primary" role="button">
                               <span style="font-size:0.5rem;"><i class="fa fa-cubes fa-3x"></i></span><br/>
                               <p>Logistics</p></a>
          </li>
           <?php if(Yii::$app->getModule('assets0')->canView($user)): ?>
           <li class="nav-item mb-2">
            <a  href="<?=Url::to(['/assets0']) ?>" class="nav-link nav-link-box bg-info" role="button">
                               <span style="font-size:0.5rem;"><i class="fas fa-laptop-house fa-3x"></i></span><br/>
                               <p>Assets</p></a>
          </li>
           <?php endif;?>
           <li class="nav-item mb-2">
            <a  href="<?=Url::to(['/operations']) ?>" class="nav-link nav-link-box bg-fuchsia elevation-2" role="button">
                               <span style="font-size:0.5rem;"><i class="fa fa-tasks fa-3x"></i></span><br/>
                               <p>Operations</p></a>
          </li>
          
          <li class="nav-item mb-2">
              
              <a  href="https://rac.co.rw/erp/uploads/documentation/ERP USER MANUAL.pdf" target="_blank" class="nav-link bg-navy elevation-2 nav-link-box" role="button">
                               <span style="font-size:0.5rem;"><i class="far text-red fa-file-pdf fa-3x"></i></span><br/>
                               <p>User Guidance</p></a>
          </li>
            
        
            </ul>

    </div>
    <!-- /.sidebar -->
  </aside>
  
  