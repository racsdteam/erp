<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use common\models\ErpOrgLevels;
use yii\db\Query;
$user=Yii::$app->user->identity;

 $user_image=$user->user_image;
                                     $path='';
                                     if($user_image!=''){
                                         
                                      $path='@web/'.$user_image;   
                                     }else{
                                         
                                        $path='@web/img/avatar-user.png';    
                                     }
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
        <?= Html::img( $path, ['class' => 'img-circle', 'alt'=>'User Image']) ?>
         
        </div>
        <div class="pull-left info">
          <p><?=$user->first_name." ".$user->last_name?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <?php
      
      
      
     
      $query = new Query;
                                     $query	->select([
                                         'p.*',
                                         
                                     ])->from('erp_org_positions as p ')->join('INNER JOIN', 'erp_persons_in_position as pp',
                                         'p.id=pp.position_id')->where(['person_id'=>$user->user_id]);
                         
                                     $command = $query->createCommand();
                                     $row= $command->queryOne();
       
      //-------------------pending documents-------------------------------------------------------------------------
      $q=" SELECT count(*) as tot FROM erp_document_flow_recipients where  recipient='". Yii::$app->user->identity->user_id."' and is_new=1";
      $com = Yii::$app->db->createCommand($q);
            $r = $com->queryall(); 
            

//----------------------- my documents-----------------------------------------------------------------------------------------------------

$q3=" SELECT count(*) as tot FROM erp_document where  creator='". Yii::$app->user->identity->user_id."' and is_new=1 ";
$com3 = Yii::$app->db->createCommand($q3);
      $r3 = $com3->queryall(); 

 //-------------------pending request------------------------------------------------------------------------
 $q0=" SELECT count(*) as tot FROM erp_document_request_for_action where  action_handler='". Yii::$app->user->identity->user_id."' and is_new='1'";
 $com0 = Yii::$app->db->createCommand($q0);
       $r0 = $com0->queryall(); 



 //-------------------pending users-------------------------------------------------------------------------
 $q2=" SELECT count(*) as tot FROM user where  approved=0  ";
 $com2 = Yii::$app->db->createCommand($q2);
       $r2 = $com2->queryall(); 
       
      

 
      
      $items=[
        ['label' => 'Menu', 'options' => ['class' => 'header']],
        ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard', 
            'url' => ['default/index'], 'active' => $this->context->route == 'user/default/index',
           
        ],
     
 
//-----------------------------------------manage users---------------------------------------------------------
[
    'label' => 'Manage Users accounts',
    'icon' => 'fa fa-database',
    'url' => '#',
    'visible'=>$user->user_level==User::ROLE_ADMIN,
   
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'users accounts',
    'icon' => 'fa fa-database',
    'url' =>Url::to(['/user/user/users-list']),
    
    'active' => $this->context->route == 'user/user/users-list'
    ],
    [
    'label' => 'Users Pending '.Html::tag('span',$r2[0]['tot']." Pending", ['class' => 'badge bg-green']),
    'icon' => 'fa fa-user-plus',
    'url' => Url::to(['/user/user/users-pending']),
    'active' => $this->context->route == 'user/user/users-pending'
    ],
    [
    'label' => 'Signature',
    'icon' => 'fa fa-user-plus',
    'url' => Url::to(['/user/signature/index']),
    'active' => $this->context->route == 'user/signature/index'
    ],
    ]
    ],
        
        //['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
        //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],

      /*  [
            'label' => 'Select Your Hotel',
            'icon' => 'fa fa-hotel',
            'url' => Url::to(['site/user-select-hotel']),
            'visible'=>User::isTempUser() ,
            'active' => $this->context->route == 'site/user-select-hotel'
        ]*/
    ]
      
      ?>
      <?=
        Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree','data-widget'=>'tree'],
                    'items' =>$items,'encodeLabels' => false//to be able to display badge 
                ]
        )
        ?>
    </section>
    <!-- /.sidebar -->
  </aside>
