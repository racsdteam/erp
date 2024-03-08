<?php
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\Url;
$user=Yii::$app->user->identity;
$query = new Query;
                                     $query	->select([
                                         'p.*',
                                         
                                     ])->from('erp_org_positions as p ')->join('INNER JOIN', 'erp_persons_in_position as pp',
                                         'p.id=pp.position_id')->where(['person_id'=>$user->user_id]);
                         
                                     $command = $query->createCommand();
                                     $row= $command->queryOne();
                                     
                                     $user_image=$user->user_image;
                              
                                     if(!empty($user_image)|| $user_image=null){
                                         
                                      $path='@web/'.$user_image;   
                                     }else{
                                         
                                        $path='@web/img/avatar-user.png';    
                                     }
?>

  <header class="main-header">
    <!-- Logo -->
    
    <a href="site/" class="logo">
       
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">M<b>A</b>L</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">RAC<b>ERP</b>PORTAL</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
              
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?= Html::img( $path, ['class' => 'user-image', 'alt'=>'User Image']) ?>
              <span class="hidden-xs"><?=$user->first_name." ".$user->last_name?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                 
                <?= Html::img($path, ['class' => 'img-circle', 'alt'=>'User Image']) ?>

                
                <p>
                <?=$user->first_name." ".$user->last_name?> -<?=$row['position']?>
                </p>
                
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-12">
                       <?=Html::a(' Change Password', ['user/change-password'],['data' => ['method' => 'post'],'class'=>["btn btn-sm btn-flat user-action"]]) ?>
                  
                  </div>
                 
                  
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                  
                 <div class="pull-left">
                 <?=Html::a('My Profile', ['user/profile-update','id'=>Yii::$app->user->identity->user_id],['data' => ['method' => 'post'],'class'=>["btn bg-blue btn-sm btn-flat user-action"],'title'=>'User Profile']) ?>
                </div>
                <div class="pull-right">
               <?=Html::a(' Sign Out', ['site/logout'],['data' => ['method' => 'post'],'class'=>["btn bg-blue btn-sm btn-flat"]]) ?>
                </div>
                
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
     
    </nav>
    
     
   
  </header>
 
  
  
  
        