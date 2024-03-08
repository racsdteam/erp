<?php
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\Url;
use common\models\UserHelper;
?>

<?php

                                   $user=Yii::$app->user->identity;

                                     
                                     $user_image=$user->user_image;
                                     $path='';
                                     if($user_image!=''){
                                         
                                      $path='@web/'.$user_image;   
                                     }else{
                                         
                                        $path='@web/img/avatar-user.png';    
                                     }
                                     
                                     $res=UserHelper::getPositionInfo($user->user_id);
?>

<style>


.user-image{
    
    float: left;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    margin-right: 10px;
    margin-top: -2px;
    
   /* navbar-dark navbar-success*/
}

</style>

   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-light navbar-success ">
       
       <div class="container">
           
           <a href="<?=url::to(['/'])?>" class="navbar-brand">
        <img src="/erp/img/logo.png" alt="RAC ERP Logo" class="brand-image img-circle elevation-3 bg-white" style="opacity: .8">
        <span class="brand-text text-dark font-weight-light">RAC ERP</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
           
     

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
       
            
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=url::to(['/'])?>" class="nav-link"><i class="fas fa-home"></i> Home</a>
      </li>        
    
      
      <!-- User info Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <?= Html::img( $path, ['class' => 'user-image', 'alt'=>'User Image']) ?>
          <span class="hidden-xs"><?=$user->first_name." ".$user->last_name?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <div class="card-body box-profile">
                <div class="text-center">
                    
                      <?= Html::img( $path, ['class' => 'profile-user-img img-fluid img-circle', 'alt'=>'User Image']) ?>
                  
                </div>

                <h3 class="profile-username text-center"><?=$user->first_name." ".$user->last_name?></h3>

                <p class="text-muted text-center"><?=$res['position']?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
  <?=Html::a('My Profile', ['/user/user/profile-update','id'=>$user->user_id],
  ['data' => ['method' => 'post'],'class'=>["btn btn-outline-success btn-sm  user-action"],'title'=>'User Profile']) ?>
 <?=Html::a(' Change Password', ['/user/user/change-password'],
 ['data' => ['method' => 'post'],'class'=>["btn btn-sm btn-outline-success float-right user-action"]]) ?>
                  </li>
                
                </ul>
 <?=Html::a(' Sign Out', ['/site/logout'],['data' => ['method' => 'post'],'class'=>["btn btn-success active btn-block"]]) ?>
                
              </div>
        </div>
      </li>
    
    </ul>
    
     </div>
  </nav>
  <!-- /.navbar -->
        