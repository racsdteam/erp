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
                                
 $employee=Yii::$app->empUtil->getEmpByUser(Yii::$app->user->identity->user_id); 


 $empCreateUrl=Url::to(['employees/create']);
 $typeMode=(isset($this->params['typeMode'])&& $this->params['typeMode']!=null)?$this->params['typeMode']:null;
 $typeEmp=(isset($this->params['typeEmp'])&& $this->params['typeEmp']!=null)?$this->params['typeEmp']:null;

if($typeMode!=null && $typeEmp!=null){
  $empCreateUrl=Url::to(['employees/create','mode'=>$typeMode,'empType'=>$typeEmp]);  
    
}


?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=Url::to(['/site'])?>" class="brand-link navbar-info ">
      <img src="/erp/img/logo.png" alt="RAC Logo" class="brand-image img-circle elevation-3 bg-white"
           style="opacity: .8">
      <span class="brand-text font-weight-light">RAC HR  </span>
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
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
             <i class="nav-icon fas fa-user-tie"></i>
              <p>
              My details
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                
                <?php if($employee==null) :?>
                <li class="nav-item">
                <a href="<?=Url::to(['employees/create'])?>" title="All New Employee" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Add Details</p>
                </a>
              </li>
              <?php else:?> 
               <li class="nav-item">
                <a href="<?=Url::to(['employees/basic-details','id'=>$employee->id])?>" title="Person Details" class="nav-link">
                 <i class="far fa-user nav-icon"></i>
                  <p>Personal details</p>
                </a>
              </li>
              
              
               <li class="nav-item">
                <a href="<?=Url::to(['employees/contact-details','id'=>$employee->id])?>" title="Contact Details" class="nav-link">
                 <i class="nav-icon fas fa-phone"></i>
                  <p>Contact details</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['employees/address-details','id'=>$employee->id])?>" title="Address Details" class="nav-link">
                  <i class="nav-icon fas fa-map-marker-alt"></i>
                  <p>Address details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['employees/employement-details','id'=>$employee->id])?>" title="Job Details" class="nav-link">
                <i class="nav-icon fas fa-suitcase"></i>
                  <p>Job details</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['employees/bank-details','id'=>$employee->id])?>" title="Bank Details" class="nav-link">
                 <i class="nav-icon fas fa-university"></i>
                  <p>Bank details</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['employees/documents','id'=>$employee->id])?>" title="Documents" class="nav-link">
                 <i class="nav-icon far fa-folder-open"></i>
                  <p>My Documents </p>
                </a>
              </li>
              <?php endif;?>
              
             
           
            </ul>
          </li>
         <li class="nav-item">
                <a href="<?=Url::to(['payslips/my-payslips'])?>" title="Payslips" class="nav-link">
                 <i class="nav-icon fas fa-money-check"></i>
                  <p>My Payslips </p>
                </a>
         </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-hand-holding-medical nav-icon"></i>
              <p>
              Leave Request
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['leave-request/create'])?>" title="All Security Groups" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Request Leave Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-request/draft'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-drafting-compass nav-icon"></i>
                  <p> Draft leave requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-approval-task-instances/pending'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p> Pending leave requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-approval-task-instances/my-approvals'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>Completed Approvals</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['leave-request/my-leave'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-inbox nav-ico"></i>
                  <p> My leave Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-request/approved'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-thumbs-up nav-icon"></i>
                  <p> Approved leave requests</p>
                </a>
              </li>
                 <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-request/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All leave requests</p>
                </a>
              </li>
             <?php 
             endif;
             ?>
            </ul>
          </li>
       <?php
            if($userposition == "MD" || $userposition == "DHR" || $userposition == "MGRHRA"  || $userposition == "HROPOFC" || $userposition == "ADMARCH" || $userposition == "HRPAYOFC" || $userposition == "HRWLFOFC"  || $user->user_level==User::ROLE_ADMIN):
            ?>    
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
               <i class="far fa-closed-captioning nav-icon"></i>
              <p>
              Leave Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['leave-category/create'])?>" title="All Security Groups" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Create Leave Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-category/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All leave Categories</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
               Public Holidays Registry
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['leave-public-holiday/create'])?>" title="All Security Groups" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Create Public Holidays</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['leave-public-holiday/index'])?>" title="New Security Group " 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Public Holidays</p>
                </a>
              </li>
              
            </ul>
          </li>
           
          <!---------------Company setup------------------------------------------>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
               
              <p>
              Company Setup
                <i class="right fas fa-angle-left"></i>
               
              </p>
            </a>
            <ul class="nav nav-treeview">
                
                 <li class="nav-item">
                <a href="#" title="Company Info" 
                class="nav-link">
                
               <i class="nav-icon far fa-building"></i>
                  <p>Company Profile</p>
                </a>
                </li>
                 <li class="nav-item">
                <a href="<?=Url::to(['erp-org-units/index'])?>" title="Company Structure" 
                class="nav-link">
                
               <i class="nav-icon far fa-building"></i>
                  <p>Company Structure</p>
                </a>
                </li>
                
                 <li class="nav-item">
                <a href="#" title="Company  Chart" 
                class="nav-link">
                
                <i class="nav-icon fas fa-sitemap"></i>
                  <p>Company Org Chart</p>
                </a>
                </li>
                
                   <li class="nav-item">
                <a href="<?=Url::to(['erp-org-jobs/index'])?>" title="All Job Roles" 
                class="nav-link">
                
                <i class="nav-icon fas fa-suitcase"></i>
                  <p>Company Jobs</p>
                </a>
              </li>
               
                 <li class="nav-item">
                <a href="<?=Url::to(['erp-org-positions/index'])?>" title="Company Positions" 
                class="nav-link">
                
              <i class="nav-icon fas fa-suitcase"></i>
                  <p>Company Positions</p>
                </a>
                </li>
                
                
             
              
              
                <li class="nav-item">
                <a href="<?=Url::to(['employment-type/index'])?>" title="All Employment Types " 
                class="nav-link">
               
             <i class="nav-icon fas fa-briefcase"></i>
               
                  <p>Employement Types</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="<?=Url::to(['employee-statuses/index'])?>" title="All Employee Statuses " 
                class="nav-link">
               
             <i class="nav-icon far fa-lightbulb"></i>
               
                  <p>Employee Statuses</p>
                </a>
              </li>
              
                
               
                
                  <li class="nav-item">
                <a href="<?=Url::to(['emp-categories/index'])?>" title="All Employee Categories " 
                class="nav-link">
               
              <i class="nav-icon fas fa-users-cog"></i>
               
                  <p>Employee Categories</p>
                </a>
              </li>
              
              
                    <li class="nav-item">
                <a href="<?=Url::to(['emp-types/index'])?>" title="All Employee Types " 
                class="nav-link">
               
              <i class="nav-icon fas fa-users-cog"></i>
               
                  <p>Employee Types</p>
                </a>
              </li>
                  <li class="nav-item">
                <a href="<?=Url::to(['emp-groups/index'])?>" title="All Employee Groups" 
                class="nav-link">
                
               <i class="nav-icon fas fa-users"></i>
                  <p>Employee Groups</p>
                </a>
                </li>
                
                  
              
               <li class="nav-item">
                <a href="<?=Url::to(['term-reasons/index'])?>" title="All Termination Reasons" 
                class="nav-link">
                
               <i class="nav-icon far fa-flag"></i>
                  <p>Termination Reasons</p>
                </a>
                </li>
                  <li class="nav-item">
                <a href="<?=Url::to(['locations/index'])?>" title="All Work Locations" 
                class="nav-link">
               
              <i class="nav-icon fas fa-map-marker-alt"></i>
               
                  <p>Work Locations</p>
                </a>
              </li>
             
            
             <li class="nav-item">
                <a href="<?=Url::to(['employee-docs-category/index'])?>" title="Documents Categories" class="nav-link">
                 <i class="nav-icon far fa-folder-open"></i>
                  <p>Employee Docs Categories </p>
                </a>
              </li>
              
                  <li class="nav-item">
                <a href="<?=Url::to(['comp-statutory-details/index'])?>" title="All Company Statutory Details" 
                class="nav-link">
               
              <i class="nav-icon fas fa-balance-scale"></i>
               
                  <p>Statutory Details</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="<?=Url::to(['comp-banks/index'])?>" title="Company Banks" 
                class="nav-link">
                
             <i class="nav-icon fas fa-university"></i>
                  <p>Company Banks</p>
                </a>
                </li>
                
            </ul>
          </li>
         
          <!-------------Employee master----------------------------->
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
             
               <i class="nav-icon fas fa-users-cog"></i>
              <p>
              Manage Employees
                <i class="right fas fa-angle-left"></i>
               
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                 <i class="fas fa-plus-square  nav-icon"></i>
                  <p>
                    Add Employee
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    
                  <li class="nav-item">
                <a href="<?=Url::to(['employees/create'])?>" title="Add New Employee" class="nav-link">
                 <i class="nav-icon fas fa-user-plus"></i>
                  <p>Add Employee</p>
                </a>
              </li>
              
              
               <li class="nav-item">
                <a href="<?=Url::to(['employees/bulk-create'])?>" title="Add in Bulk" class="nav-link">
                 
                 <i class="nav-icon fas fa-cloud-upload-alt"></i> 
                  <p>Add Employee in Bulk</p>
                </a>
              </li>
             
        
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['employees/index'])?>" title="All Employees " 
                class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p> Active Employees</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['employees/index','status'=>EmployeeStatuses::STATUS_TYPE_NACT])?>" title="All Inactive Employees" 
                class="nav-link">
               
           
           <i class="nav-icon fas fa-users-slash"></i>
               
                  <p>Inactive Employees</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['emp-suspensions/index'])?>" title="All Suspended Employees" 
                class="nav-link">
               
           <i class="nav-icon fas fa-user-shield"></i>
               
                  <p>Employee Suspensions</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['emp-terminations/index'])?>" title="All Terminated Employees" 
                class="nav-link">
               
          <i class="nav-icon fas fa-user-times"></i>
               
                  <p>Employee Terminations</p>
                </a>
              </li>
            </ul>
          </li>
            
           <?php
           endif;
           
            if($userposition == "MD" || $userposition == "DHR" || $userposition == "MGRHRA"  || $userposition == "HROPOFC" || $userposition == "ADMARCH"
            || $userposition == "HRPAYOFC" || $userposition == "HRWLFOFC" || $userposition == "ADVMD" || $userposition == "DAF"  || $userposition == "MEXRE" 
            || $userposition == "FATM"  ||  $userposition =='MGRIAUDT' ||  $userposition =='AUDT' || $userposition=='TACC' || $user->user_level==User::ROLE_ADMIN):
            ?>
          <!----------------------Payrol set up----------------------------------------->
              <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
            
            
             <i class="nav-icon fas fa-coins"></i>
              <p>
              Manage Payrolls
                <i class="right fas fa-angle-left"></i>
               
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php
            if( $userposition != "ADVMD" && $userposition != "DAF" && $userposition != "MEXRE" && $userposition != "FATM" && $userposition !='MGRIAUDT' && $userposition !='AUDT' && $userposition!='TACC'):
            ?>   
             <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                 <i class="nav-icon fas fa-toolbox"></i>
                  <p>
                    Payroll Settings
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    
                   <li class="nav-item">
                <a href="<?=Url::to(['pay-levels/index'])?>" title="All pay levels" 
                class="nav-link">
                
               <i class="nav-icon fas fa-sitemap"></i>
                  <p>Pay Levels</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['pay-types/index'])?>" title="All pay Types" class="nav-link">
                 
                 <i class="nav-icon fas fa-business-time"></i>
                  <p>Pay Types</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="<?=Url::to(['pay-groups/index'])?>" title="All payroll groups" class="nav-link">
                 
                <i class="nav-icon fas fa-users"></i>
                  <p>Pay Groups</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['pay-item-categories/index'])?>" title="All Payroll Item categories" class="nav-link">
                 
                 <i class="nav-icon fas fa-hand-holding"></i>
                  <p>Pay item Categories</p>
                </a>
              </li>
             
              
                 <li class="nav-item">
                <a href="<?=Url::to(['statutory-deductions/index'])?>" title="All Statutoty Deductions" 
                class="nav-link">
               
              <i class="nav-icon fas fa-cut"></i>
               
                <p>Statutory Benefits</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pay-items/index'])?>" title="All Payroll Items" class="nav-link">
                 
                <i class="nav-icon fas fa-hand-holding"></i>
                  <p>Pay Items</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pay-templates/index'])?>" title="All payroll Templates" 
                class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
               
                  <p>Pay Templates</p>
                </a>
              </li>
              
                <li class="nav-item">
                <a href="<?=Url::to(['payroll-run-types/index'])?>" title="All Payroll Run Types" class="nav-link">
                 
                 <i class="nav-icon fas fa-coins"></i>
                  <p>Payroll Run Types</p>
                </a>
              </li>
              
               
              
              
             
                </ul>
              </li>
                
                 
              
               <li class="nav-item">
                <a href="<?=Url::to(['emp-pay-details/index'])?>" title="All Employee Pay Details" 
                class="nav-link">
               <i class="nav-icon fas fa-money-bill-wave"></i>
               
                  <p>Salary Details</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['emp-pay-revisions/index'])?>" title="All Employee Pay Revisions" 
                class="nav-link">
              <i class="nav-icon fas  fa-pen-square"></i>
               
                  <p>
                      
                      Pay Revisions
                      <span class="badge badge-warning right"><?=\frontend\modules\hr\models\EmpPayRevisions::countByStatus('pending')?></span>
                  
                  </p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?=Url::to(['emp-excluded-from-pay/index'])?>" title="All Employees Exluded From Payroll" 
                class="nav-link">
               <i class="nav-icon fas fa-user-lock"></i>
               
                  <p>Pay Hold/Release</p>
                </a>
              </li>
              
               <?php
             endif;
             ?>
               <li class="nav-item">
                <a href="<?=Url::to(['payrolls/index'])?>" title="All Payrolls " 
                class="nav-link">
             
             <i class="nav-icon fas fa-coins"></i>
               
                  <p>Payroll List</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['payroll-run-reports/index'])?>" title="All  Payroll Run Reports" 
                class="nav-link">
                  <i class="nav-icon fas fa-chart-bar"></i>
                  <p>Report List</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="<?=Url::to(['payroll-changes/index'])?>" title="All Payrolls " 
                class="nav-link">
             
           
            <i class="nav-icon fas fa-business-time"></i>
               
                  <p>Payroll Changes</p>
                </a>
              </li>
             
                
            
             
             
             
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
               
               <i class="nav-icon fas fa-signature"></i>
                  <p>
                   Payroll Approvals
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                      <?php
            if($userposition != "ADVMD" && $userposition != "DAF" && $userposition != "MEXRE" && $userposition != "FATM" && $userposition !='MGRIAUDT' && $userposition !='AUDT' ):
            ?> 
                   <li class="nav-item">
                <a href="<?=Url::to(['payroll-approval-requests/index'])?>" title="All Approval Payroll Requests" 
                class="nav-link">
              <i class="nav-icon fas fa-paper-plane"></i>
               
                  <p>Approval  Requests</p>
                </a>
              </li>
                 <?php endif; ?>
                 
                    <li class="nav-item">
                <a href="<?=Url::to(['payroll-approval-task-instances/pending'])?>" title="Pending Payroll Requests" 
                class="nav-link">
             <i class="nav-icon fas fa-clock"></i>
                  <p>Pending  Approvals</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['payroll-approval-task-instances/my-approvals'])?>" title="Completed Payroll Requests" 
                class="nav-link">
             <i class="nav-icon fas fa-clipboard-check"></i>
                  <p>Completed Approvals</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?=Url::to(['payroll-approval-requests/approved'])?>" title="Completed Payroll Requests" 
                class="nav-link">
             <i class="nav-icon fas fa-check"></i>
                  <p>Approved Requests</p>
                </a>
              </li>
                </ul>
              </li>
              
            
            </ul>
          </li>
          <?php 
             endif;
             ?>
                  <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
       <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
           <i class="nav-icon fas fa-cog"></i>
                  <p>
                  Reports Setup
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    
            
                  <li class="nav-item">
                <a href="<?=Url::to(['report-templates/index'])?>" title="All Report Templates " 
                class="nav-link">
               <i class="nav-icon fas fa-chart-line"></i>
              
                  <p>Report Templates</p>
                </a>
                </li>   
                    
                <li class="nav-item">
                <a href="<?=Url::to(['report-types/index'])?>" title="All Report Types" 
                class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
              
                  <p>Report Types</p>
                </a>
                </li>
           
                </ul>
              </li>
          
 <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
             <i class="nav-icon fas fa-handshake"></i>
              <p>
               Approval WorkFlows
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['comp-business-entities/index'])?>" title="All Company Business Entities" class="nav-link">
                  <i class="fas fa-database  nav-icon"></i>
                  <p>Company Business Entities</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?=Url::to(['approval-workflows/index'])?>" title="All Approval Workflows" class="nav-link">
                  <i class="fas fa-database  nav-icon"></i>
                  <p>Approval Workflows</p>
                </a>
              </li>
             
              
            </ul>
          </li>         
          <?php 
             endif;
             ?>
            
           <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-atlas nav-icon"></i>
              <p>
              Imihigo Form
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['performance-contract/create'])?>" title="Fill Imihigo Form" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Fill Imihigo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['performance-contract/draft'])?>" title="Draft" 
                class="nav-link">
                  <i class="fas fa-drafting-compass nav-icon"></i>
                  <p> Draft Imihigo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-approval-task-instances/pending'])?>" title="Pending " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p> Pending Imihigo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-approval-task-instances/completed'])?>" title="Completed " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>Completed Approvals</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['performance-contract/my-pc'])?>" title="InBox" 
                class="nav-link">
                  <i class="fas fa-inbox nav-ico"></i>
                  <p> My Imihigo Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['performance-contract/approved'])?>" title="Approved" 
                class="nav-link">
                  <i class="fas fa-thumbs-up nav-icon"></i>
                  <p> Approved Imihigo Form</p>
                </a>
              </li>
                 <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
              <li class="nav-item">
                <a href="<?=Url::to(['performance-contract/index'])?>" title="All" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Imihigo Forms</p>
                </a>
              </li>
            <?php endif; ?>
            </ul>
          </li>
          
                <?php
            if($user->user_level==User::ROLE_ADMIN):
            ?>
            <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-balance-scale nav-icon"></i>
              <p>
              Performance Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['pc-report/index'])?>" title="Fill Imihigo Form" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>My Performance reports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/draft'])?>" title="Draft" 
                class="nav-link">
                  <i class="fas fa-drafting-compass nav-icon"></i>
                  <p> Draft Imihigo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/pending'])?>" title="Pending " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p> Pending Imihigo</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/my-pc'])?>" title="InBox" 
                class="nav-link">
                  <i class="fas fa-inbox nav-ico"></i>
                  <p> My Imihigo Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/approved'])?>" title="Approved" 
                class="nav-link">
                  <i class="fas fa-thumbs-up nav-icon"></i>
                  <p> Approved Imihigo Form</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/index'])?>" title="All" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Imihigo Forms</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="fas fa-balance-scale nav-icon"></i>
              <p>
              Imihigo Evaluation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/create'])?>" title="Fill Imihigo Form" class="nav-link">
                  <i class="fas fa-plus-square  nav-icon"></i>
                  <p>Guhigura</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/draft'])?>" title="Draft" 
                class="nav-link">
                  <i class="fas fa-drafting-compass nav-icon"></i>
                  <p> Draft Imihigo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/pending'])?>" title="Pending " 
                class="nav-link">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p> Pending Imihigo</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/my-pc'])?>" title="InBox" 
                class="nav-link">
                  <i class="fas fa-inbox nav-ico"></i>
                  <p> My Imihigo Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/approved'])?>" title="Approved" 
                class="nav-link">
                  <i class="fas fa-thumbs-up nav-icon"></i>
                  <p> Approved Imihigo Form</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="<?=Url::to(['pc-evaluation/index'])?>" title="All" 
                class="nav-link">
                  <i class="fas fa-database nav-icon"></i>
                  <p> All Imihigo Forms</p>
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
  
  