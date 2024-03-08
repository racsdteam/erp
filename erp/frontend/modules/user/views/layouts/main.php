

<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use common\models\ErpMemoCateg;
?>
<?php

$this->params['showSideMenu'] =1;
$this->params['title'] ="Users";

?>

   
<?php $this->beginContent('@common/views/layouts/main.php') ?>


 <?php $this->beginBlock('sidebar-menu') ?>
       <?php
            if(\Yii::$app->user->identity->isAdmin()):
            ?>
 <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
         <li class="nav-header">NAVIGATION MENU</li>
         <li class="nav-item">
            <a href="<?=Url::to(['default/index'])?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>DashBoard</p>
            </a>
          </li>
          
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
           <i class="far fa-folder-open nav-icon"></i>
              <p>
                   Manage User Accounts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
             
                <li class="nav-item">
                <a href="<?=Url::to(['/user/user/index'])?>" title="All User(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All User(s)</p>
                </a>
              </li>
              
              
                 <li class="nav-item">
                <a href="<?=Url::to(['/user/signature/index'])?>" title="Add Signature" 
                class="nav-link">
                    <i class="fas fa-box nav-icon"></i>
                 
                 
                  <p>All Signatures</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
              
              
              
            </ul>
          </li>
         
        </ul>
      </nav>
           <?php 
             endif;
             ?>
 <?php $this->endBlock() ?>
  
 
 <?= $content ?>

<?php $this->endContent() ?>

 



 

