<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\UserHelper;
use common\models\User;
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
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="<?=Url::to(['/site'])?>" class="brand-link navbar-info">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">RAC Logistic</span>
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
          <?php
            if($userposition == "MGRLGX" || $userposition == "STOFC" || $user->user_level==User::ROLE_ADMIN):
            ?>
             <li class="nav-item">
                <a href="<?=Url::to(['default/index'])?>" title="Dashboard" 
                class="nav-link">
                 <i class="fas fa-chart-line nav-icon"></i>
                  <p> Dashboard </p>
                </a>
              </li>
             <?php 
             endif;
             ?>
         <li class="nav-item">
                <a href="<?=Url::to(['items/check'])?>" title=" Items Information " 
                class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p> Check Items Info.</p>
                </a>
              </li>
         
         <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-hand-holding-medical nav-icon"></i>
              <p>
             Stock Voucher
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/create'])?>" title="Request Items to stock" class="nav-link">
                  <i class="fa fa-plus-square  nav-icon"></i>
                  <p>Create Voucher</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/draft'])?>" title="Draft Requests " 
                class="nav-link">
                 <i class="fas fa-drafting-compass nav-icon"></i>
                  <p> Draft Vouchers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/pending'])?>" title="Pending Requests " 
                class="nav-link">
                 <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p> Pending Vouchers</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/my-vouchers'])?>" title="All Requests you worked on  " 
                class="nav-link">
                   <i class="fas fa-inbox nav-icon"></i>
                  <p> My Stock Vouchers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/approved'])?>" title="Your Approved Requests" 
                class="nav-link">
                  <i class="fas fa-thumbs-up nav-icon"></i>
                  <p> Approved Vouchers</p>
                </a>
              </li>
                <?php
            if($userposition == "MGRLGX" || $userposition == "STOFC" || $user->user_level==User::ROLE_ADMIN):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/index'])?>" title="All Requests " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Vouchers</p>
                </a>
              </li>
               <?php 
             endif;
             ?>
            </ul>
          </li>
            <?php
            if($userposition == "MGRLGX" || $userposition == "STOFC" || $user->user_level==User::ROLE_ADMIN):
            ?>
           <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
             <i class="fas fa-cubes nav-icon"></i>
              <p>
             Stock Entries
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['reception-goods/create'])?>" title="Enter Received Goods" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Enter  Entries</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['reception-goods/approved'])?>" title="Approved Received Goods " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> View All  Entries </p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
              Item Categories
                <i class="right fas fa-angle-left "></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['categories/create'])?>" title="Create Item category" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Create Item Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['categories/index'])?>" title="All items categories" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Item Categories</p>
                </a>
              </li>
              
            </ul>
          </li>
          <?php 
          endif;
            if($userposition == "MGRLGX" || $userposition == "STOFC"|| $userposition == "STK" || $user->user_level==User::ROLE_ADMIN):
          ?>
           <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="fas fa-gas-pump nav-icon"></i>
              <p>
              Used Fuel
                <i class="right fas fa-angle-left "></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/fuel-out'])?>" title=" Rediuse Fuel Stock" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Add used fuel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['request-to-stock/fuel-index'])?>" title="All Rediuse Fuel Stock" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>All Used Feul </p>
                </a>
              </li>
              
            </ul>
          </li>
          <?php
          endif;
            if($userposition == "MGRLGX" || $userposition == "STOFC" || $user->user_level==User::ROLE_ADMIN):
          ?>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="far fa-closed-captioning nav-icon"></i>
              <p>
              Item Sub-Categories
                <i class="right fas fa-angle-left  "></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['sub-categories/create'])?>" title="Create Item Sub-category" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Create It. Sub Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['sub-categories/index'])?>" title="All items Sub-categories" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>All It. Sub Categories </p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-parachute-box"></i>
              <p>
              Suppliers Registry
                <i class="right fas fa-angle-left "></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['supplier/create'])?>" title="Create Supply" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Create Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['supplier/index'])?>" title="All Suppliers" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>All Suppliers</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
              Item Registry
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['items/create'])?>" title="Register Items" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Create Item</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['items/index'])?>" title="All Items" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p>All Items</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
             <i class="fas fa-folder-open nav-icon"></i>
              <p>
             Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['reports/actual-stock'])?>" title="Actual Stock Report" class="nav-link">
                  <i class="fas  fa-file  nav-icon"></i>
                  <p>Actual Stock</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['reports/item-history'])?>" title="Item History Report" 
                class="nav-link">
                  <i class="fas fa-file nav-icon"></i>
                  <p> Item history</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['reports/received'])?>" title="Received Items Report" 
                class="nav-link">
                  <i class="fas fa-file nav-icon"></i>
                  <p>Received Items</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['reports/distributed'])?>" title="Distributed Items Report" 
                class="nav-link">
                  <i class="fas fa-file nav-icon"></i>
                  <p> Distributed Items </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['reports/inventory'])?>" title="Fuel Report" 
                class="nav-link">
                  <i class="fas fa-file nav-icon"></i>
                  <p> Inventory Report </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['reports/fuel'])?>" title="Fuel Report" 
                class="nav-link">
                  <i class="fas fa-file nav-icon"></i>
                  <p> Fuel Report </p>
                </a>
              </li>
            </ul>
          </li>
          
          <?php 
            endif;
        ?>
         
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  