<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
?>

<?php $this->beginContent('@frontend/modules/racdms/views/layouts/main.php') ?>

  
   <?php

$this->params['sidemenu']=1; 
  ?>
  
 <?php $this->beginBlock('sidebar-menu') ?>
 <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
         <li class="nav-header">NAVIGATION MENU</li>
          
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user-lock"></i>
              <p>
               Security Groups
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['tblgroups/index'])?>" title="All Security Groups" class="nav-link">
                  <i class="fa fa-cubes nav-icon"></i>
                  <p>All Security Groups</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['tblgroups/create'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fa fa-plus-square nav-icon"></i>
                  <p> New Security Goup</p>
                </a>
              </li>
              
            </ul>
          </li>
          
            <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
               Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['tblusers/index'])?>" title="All Users" class="nav-link">
                  <i class="fa fa-cubes nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['tblusers/create'])?>" title="New User " 
                class="nav-link">
                  <i class="fa fa-plus-square nav-icon"></i>
                  <p> Add User</p>
                </a>
              </li>
              
            </ul>
          </li>
          
            <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hotel"></i>
              <p>
               Manage Organisations
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['tblorgs/index'])?>" title="All Org" class="nav-link">
                  <i class="fa fa-cubes nav-icon"></i>
                  <p>All Organisations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['tblorgs/create'])?>" title="Add organisation " 
                class="nav-link">
                  <i class="fa fa-plus-square nav-icon"></i>
                  <p> Add Organisation</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['tblorgpositions/create'])?>" title="Add Position " 
                class="nav-link">
                  <i class="fa fa-plus-square nav-icon"></i>
                  <p> Add Position</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['tblorgpositions/index'])?>" title="All Positions " 
                class="nav-link">
                  <i class="fa fa-cubes nav-icon"></i>
                  <p> All Positions</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
         
        </ul>
      </nav>
 <?php $this->endBlock() ?>
  
 
 <?= $content ?>

<?php $this->endContent() ?>

 

