<?php


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use common\models\ErpMemoCateg;
use common\models\UserHelper;
?>
<?php

$this->params['showSideMenu'] =1;
$this->params['title'] ="Docs Sharing";


$user=Yii::$app->user->identity;
 $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
  $userposition=$userinfo['position_code'];
 
 $positions=array();

$hr_unit_pos=getPositionsByUnit(9,$positions);

$fn_depart_pos=getPositionsByUnit(5,$positions);

$fn_depart_pos=array_filter($fn_depart_pos);//remove nulls

$hr_unit_pos=array_filter($hr_unit_pos);//remove nulls

  
if (in_array($userposition, $hr_unit_pos) 
|| $user->user_level==User::ROLE_ADMIN
||$userposition=='DAF'
||$userposition=='MD'
||$userposition=='DMD')
{
 $tr_link_visible=true;
}else{
    
     $tr_link_visible=false;
}

//---------------------------------------------lpo visibility---------------------------------------------------------
if ($user->user_level==User::ROLE_ADMIN 
||$userposition=='MGRFAS'
||$userposition=='BPACC'
||$userposition=='DAF'
||$userposition=='MD'
||$userposition=='DMD') 
{
 $lpo_link_visible=true;
}else{
    
     $lpo_link_visible=false;
}

//-----------------memo visibility-----------------------------------------

if (  
$user->user_level==User::ROLE_ADMIN 
||$userposition=='MD'
||$userposition=='DMD') 
{
 $memo_link_visible=true;
}else{
    
     $memo_link_visible=false;
}

//-------------------------------------requisition-visibility-----------------------

if (  
$user->user_level==User::ROLE_ADMIN 
||$userposition=='MD'
||$userposition=='DMD') 
{
 $req_link_visible=true;
}else{
    
     $req_link_visible=false;
}

  
?>
<?php
  //-----------------------------memo types------------------------------------
    
     $mCategories=ErpMemoCateg::find()->all();
    
     
   ?>
   
   
<?php $this->beginContent('@common/views/layouts/main.php') ?>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/erp/img/logo.png" alt="RACLogo" height="60" width="60">
  </div>

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
              
       
           <i class="far fa-folder-open nav-icon"></i>
              <p>
                   Manage Documents
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['erp-document/create'])?>" title="Share Document(s)" class="nav-link">
               
                  <i class="fas fa-share-square nav-icon"></i>
                  <p>Share Document</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['erp-document/drafts'])?>" title="Draft Document(s)" 
                class="nav-link">
                    <i class="fas fa-edit nav-icon"></i>
                
                  <p> Drafts(s)</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-document/my-documents'])?>" title="My Document(s)" 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p> My Document(s)</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['erp-document/in-documents'])?>" title="Pending Document(s)" 
                class="nav-link">
                    <i class="fas fa-inbox nav-icon"></i>
                   
                  
                
                  <p> Pending Document(s)</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-document/approved'])?>" title="Approved Document(s)" 
                class="nav-link">
                    
                   <i class="far fa-thumbs-up nav-icon"></i>
                  <p> Approved Document(s)</p>
                </a>
              </li>
                <?php
            if($memo_link_visible):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-document/index'])?>" title="All Document(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Document(s)</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['erp-document-type/index'])?>" title="All Document(s) Type" 
                class="nav-link">
                    <i class="fas fa-database nav-icon"></i>
                 
                 
                  <p>All Document Types</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="<?=Url::to(['erp-document-type/create'])?>" title="Add Document Type" 
                class="nav-link">
                    <i class="fas fa-plus-circle nav-icon"></i>
                 
                 
                  <p>Add Document Type</p>
                </a>
              </li>
                <?php 
             endif;
             ?>
            </ul>
          </li>
          
          
          
                <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
           
           
      
            <i class="far fa-copy nav-icon"></i>
              <p>
                   Manage Memo(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
             
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-plus-circle"></i>
              <p>
                Create Memo
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <!-- ----------------memo categories-------------------------------->
            <ul class="nav nav-treeview">
              
              
         <?php if(!empty($mCategories)){
         
                  foreach($mCategories as $categ) :?>
                  
                  <?php $url='erp-memo/categ-'.strtolower($categ->categ_code) ?>
          
              <li class="nav-item">
               
                <a href="<?=Url::to([$url])?>" title="Create Memo" class="nav-link">
               
              
                 <i class="fas fa-circle nav-icon"></i>
                  <p><?php echo $categ->categ ?></p>
                </a>
              </li>
         

                <?php endforeach ?>
                <?php }?>
              
            </ul>
          </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-memo/drafts'])?>" title="Draft Memo(s)" 
                class="nav-link">
                    <i class="fas fa-edit nav-icon"></i>
                
                  <p> Drafts(s)</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-memo/my-memo'])?>" title="My Memos(s)" 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p>My Memo(s)</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['erp-memo/pending'])?>" title="Pending Memo(s)" 
                class="nav-link">
                    <i class="fas fa-inbox nav-icon"></i>
                   
                  
                
                  <p> Pending Memo(s)</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-memo/approved-memos'])?>" title="Approved Memo(s)" 
                class="nav-link">
                    
                   <i class="far fa-thumbs-up nav-icon"></i>
                  <p> Approved Memo(s)</p>
                </a>
              </li>
                  <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-memo/index'])?>" title="All Memo(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Memo(s)</p>
                </a>
              </li>
              
                 <li class="nav-item">
                <a href="<?=Url::to(['erp-memo-categ/create'])?>" title="Add Memo Type" 
                class="nav-link">
                    <i class="fas fa-plus-circle nav-icon"></i>
                 
                 
                  <p>Add Memo Type</p>
                </a>
              </li>
                  <?php 
             endif;
             ?>
            </ul>
          </li>
          
          
                <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
     
           <i class="fas fa-cart-arrow-down nav-icon"></i>
              <p>
                   Manage Requisition(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             <!-- <li class="nav-item">
                <a href="<?=Url::to(['erp-requisition/create'])?>" title="Create New Requistion(s)" class="nav-link">
               
              
                 <i class="fas fa-file-medical nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['erp-requisition/drafts'])?>" title="Draft Requisition(s)" 
                class="nav-link">
                    <i class="fas fa-edit nav-icon"></i>
                
                  <p> Drafts(s)</p>
                </a>
              </li>-->
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-requisition/my-requisition'])?>" title="My Requisition(s)" 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p>My Requisition(s)</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['erp-requisition/pending'])?>" title="Pending Requisition(s)" 
                class="nav-link">
                    <i class="fas fa-inbox nav-icon"></i>
                   
                  
                
                  <p>Pending(s)</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-requisition/approved'])?>" title="Approved Requisitions(s)" 
                class="nav-link">
                    
                   <i class="far fa-thumbs-up nav-icon"></i>
                  <p>Approved</p>
                </a>
              </li>
                      <?php
            if($req_link_visible):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-requisition/index'])?>" title="All Requisition(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Requisition(s)</p>
                </a>
              </li>
                  <?php 
             endif;
             ?>
            </ul>
          </li>
            <?php
            if($tr_link_visible):
            ?>
             <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
          
         
           <i class="fas fa-suitcase-rolling nav-icon"></i>
              <p>
                  Travel Request(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['erp-travel-request/create'])?>" title="Create New Travel Request(s)" class="nav-link">
               
              
                 <i class="fas fa-file-medical nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['erp-travel-request/drafts'])?>" title="Draft Travel Request(s)" 
                class="nav-link">
                    <i class="fas fa-edit nav-icon"></i>
                
                  <p> Drafts(s)</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-travel-request/my-travel-request'])?>" title="My Travel Request(s)" 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p>My Request(s)</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['erp-travel-request/pending'])?>" title="Pending Travel Request(s)" 
                class="nav-link">
                    <i class="fas fa-inbox nav-icon"></i>
                   
                  
                
                  <p>Pending(s)</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-travel-request/approved'])?>" title="Approved Travel Request(s)" 
                class="nav-link">
                    
                   <i class="far fa-thumbs-up nav-icon"></i>
                  <p>Approved</p>
                </a>
              </li>
                         <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-travel-request/index'])?>" title="All Travel Request(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Request(s)</p>
                </a>
              </li>
              
                   <?php 
             endif;
             ?>
              
            </ul>
          </li>
              <?php 
             endif;
             ?>
             <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
          
          <i class="fas fa-receipt nav-icon"></i>
              <p>
                 LPO Request(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/create'])?>" title="Create New LPO Request(s)" class="nav-link">
               
              
                 <i class="fas fa-file-medical nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/drafts'])?>" title="Draft Lpo Request(s)" 
                class="nav-link">
                    <i class="fas fa-edit nav-icon"></i>
                
                  <p> Drafts(s)</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/my-requests'])?>" title="My LPO Request(s)" 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p>My Request(s)</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/pending-requests'])?>" title="Pending Request(s)" 
                class="nav-link">
                    <i class="fas fa-inbox nav-icon"></i>
                   
                  
                
                  <p>Pending Request(s)</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/approved'])?>" title="Approved Request(s)" 
                class="nav-link">
                    
                   <i class="far fa-thumbs-up nav-icon"></i>
                  <p>Approved Request(s)</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/my-purchase-orders'])?>" title="My LPO " 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p>My LPO(s)</p>
                </a>
              </li>
                           <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo-request/index'])?>" title="All Request(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Request(s)</p>
                </a>
              </li>
              
                  <?php 
             endif;
             ?>
              
            </ul>
          </li>
           <?php
            if($lpo_link_visible):
            ?>
            <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
         
            <i class="fas fa-receipt nav-icon"></i>
              <p>
                 Manage LPO(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo/create'])?>" title="Create New Lpo" class="nav-link">
               
              
                 <i class="fas fa-file-medical nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo/drafts'])?>" title="Draft LPO(s)" 
                class="nav-link">
                    <i class="fas fa-edit nav-icon"></i>
                
                  <p> Drafts(s)</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo/my-purchase-orders'])?>" title="My LPO(s)" 
                class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                  
                
                  <p>My LPO(s)</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo/pending'])?>" title="Pending LPO(s)" 
                class="nav-link">
                    <i class="fas fa-inbox nav-icon"></i>
                   
                  
                
                  <p>Pending(s)</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo/approved'])?>" title="Approved LPO(s)" 
                class="nav-link">
                    
                   <i class="far fa-thumbs-up nav-icon"></i>
                  <p>Approved</p>
                </a>
              </li>
                            <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-lpo/index'])?>" title="All LPO(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All LPO(s)</p>
                </a>
              </li>
              
                  <?php 
             endif;
             ?>
              
            </ul>
          </li>
            <?php 
             endif;
             ?>
             <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              
       
         <i class="fas fa-people-arrows nav-icon"></i>
              <p>
                 Manage Interim(s)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['erp-person-interim/create'])?>" title="Create New Interim(s)" class="nav-link">
               
              
                       <i class="fas fa-edit nav-icon"></i>
                  <p>Add in Interim</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['erp-person-interim/my-interim'])?>" title="My Interim(s)" 
                class="nav-link">
                     <i class="fas fa-boxes nav-icon"></i>
                
                  <p> My Interim(s)</p>
                </a>
              </li>
           
                                <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
                <li class="nav-item">
                <a href="<?=Url::to(['erp-person-interim/index'])?>" title="All Interims(s)" 
                class="nav-link">
                   <i class="fas fa-database nav-icon"></i> 
                 
                  <p> All Interim(s)</p>
                </a>
              </li>
              
                    <?php 
             endif;
             ?>
              
            </ul>
          </li>
         
        </ul>
      </nav>
      
      
 <?php $this->endBlock() ?>
  
 
 <?= $content ?>

<?php $this->endContent() ?>
   <?php  
        
        function getPositionsByUnit($unit,$positions){

//---------------select all child units  under the unit----------
$query1="SELECT p.* FROM erp_org_positions as p inner join erp_units_positions as up on up.position_id=p.id  where up.unit_id={$unit}";
            $c1 = Yii::$app->db->createCommand($query1);
                  $pos = $c1->queryall(); 
                  
                  if(!empty($pos)){
                      
                    foreach($pos as $p){
                       $positions[]=$p['position_code']; 
                    }
                  
                    }
      
                    $query="SELECT u.* FROM erp_org_units as u inner join erp_org_units as u1 on u.parent_unit=u1.id where u.parent_unit={$unit} and u1.unit_level=3";
      $c = Yii::$app->db->createCommand($query);
            $units = $c->queryall(); 
            
           
                    if(!empty($units)){

            
            
               foreach ($units as $unit1) {
              
                $positions2=array();
                 //new instance of fuction
                $data=getPositionsByUnit($unit1['id'],$positions2); 
                if(!empty($data)){
                    
                    
                    foreach($data as $p){
                        
                       $positions[]=$p;  
                    }
                }
                
            
              }

            }
            
             
             return $positions;
            
            

} 
        
        
        ?>
 

