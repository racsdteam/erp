

<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\auction;
use common\models\ErpMemoCateg;
use common\models\User;
?>
<?php

$identity=Yii::$app->user->identity;
$user=User::find()->where(['user_id'=>$identity->user_id])->One();
if($user->isAdmin())
$this->params['showSideMenu'] =1;
$this->params['title'] ="Auction";

?>

   
<?php $this->beginContent('@common/views/layouts/main.php') ?>


 <?php $this->beginBlock('sidebar-menu') ?>

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
              
       
           <i class="fas fa-gavel  nav-icon"></i>
              <p>
                   Manage Auction(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/auctions/create'])?>" title="Add Auction" 
                class="nav-link">
                 
                 <i class="fas fa-plus-circle nav-icon"></i>
                 
                  <p>Add New Auction</p>
                </a>
              </li>
              
                    <li class="nav-item">
                <a href="<?=Url::to(['/auction/auctions/drafts'])?>" title="Drafts Auction" 
                class="nav-link">
                 
                 <i class="fas fa-edit nav-icon"></i>
                 
                  <p>Drafts Auctions</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['/auction/auctions/active'])?>" title="All Lot(s)" 
                class="nav-link">
                   <i class="fas fa-cubes nav-icon"></i> 
                 
                  <p> Active Auction(s)</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['/auction/auctions/index'])?>" title="All Lot(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Auction(s)</p>
                </a>
              </li>
              
              
                
              
            </ul>
          </li>
          
          <!--------------------Auctions lots--------------------------------->
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
           <i class="fas fa-cubes nav-icon"></i>
              <p>
                   Manage Auction Lots
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots/create'])?>" title="Add Lot" 
                class="nav-link">
                 
                 <i class="fas fa-plus-circle nav-icon"></i>
                 
                  <p>Add New Lot</p>
                </a>
              </li>
              
              
                <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots/index'])?>" title="All Lot(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All lots(s)</p>
                </a>
              </li>
              
              
                
              
            </ul>
          </li>
          
          <!------------------------------------------------------------------------------>
                <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
           <i class="fas fa-cubes nav-icon"></i>
              <p>
                   Manage  Lots Item(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots-items/create'])?>" title="Add Lot Item" 
                class="nav-link">
                 
                 <i class="fas fa-plus-circle nav-icon"></i>
                 
                  <p>Add New Item</p>
                </a>
              </li>
              
              
                <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots-items/index'])?>" title="All Lot Item(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Items(s)</p>
                </a>
              </li>
              
              
                
              
            </ul>
          </li>
          <!----------------------Lot categories---------------------------------->
                   <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
           <i class="fas fa-cubes nav-icon"></i>
              <p>
                 Auction lots Catgories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots-categories/create'])?>" title="Add Category" 
                class="nav-link">
                 
                 <i class="fas fa-plus-circle nav-icon"></i>
                 
                  <p>Add New Category</p>
                </a>
              </li>
              
              
                <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots-categories/index'])?>" title="All Catgorie(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Categorie(s)</p>
                </a>
              </li>
              
              
                
              
            </ul>
          </li>
              
              
               <!----------------------Lot categories---------------------------------->
                   <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       <i class="fas fa-map-marker-alt nav-icon"></i>
           
              <p>
               lots Location(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots-locations/create'])?>" title="Add Location" 
                class="nav-link">
                 
                 <i class="fas fa-plus-circle nav-icon"></i>
                 
                  <p>Add New Location</p>
                </a>
              </li>
              
              
                <li class="nav-item">
                <a href="<?=Url::to(['/auction/lots-locations/index'])?>" title="All Location(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Location(s)</p>
                </a>
              </li>
              
              
                
              
            </ul>
          </li>
          
          <!-- ----------------------------------->
                        <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       <i class="fas fa-gavel nav-icon"></i>
           
              <p>
               Manage Biddings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/bids/active'])?>" title="Active Biddings" 
                class="nav-link">
                 
            
              <i class="far nav-icon fa-calendar-alt"></i>
                 
                  <p>Active biddings</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['/auction/bids/index'])?>" title="All Biddings" 
                class="nav-link">
                 
              <i class="fas fa-cubes nav-icon"></i>
                 
                  <p>All biddings</p>
                </a>
              </li>
              
              
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/bids/all-bids'])?>" title="All Biddings" 
                class="nav-link">
                 
              <i class="fas fa-cubes nav-icon"></i>
                 
                  <p>All biddings Detail</p>
                </a>
              </li>
                
              
            </ul>
          </li>
          
          <!-- ----------------------------------->
                        <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       <i class="fas fa-users nav-icon"></i>
           
              <p>
               Manage Bidders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="<?=Url::to(['/auction/user/index'])?>" title="All bidders" 
                class="nav-link">
                 
                <i class="fas fa-cubes nav-icon"></i>
                 
                  <p>All bidders</p>
                </a>
              </li>
              
              
              
              
                
              
            </ul>
          </li>
              
            </ul>
          </li>
         
        </ul>
      </nav>
 <?php $this->endBlock() ?>
  
 
 <?= $content ?>

<?php $this->endContent() ?>

 



 

