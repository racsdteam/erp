<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\EmployeeStatuses;
use frontend\modules\hr\models\EmpContact;
use frontend\modules\hr\models\EmpAddressCurrent;
use frontend\modules\hr\models\EmpEmployment;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\EmpPhoto;
use frontend\modules\hr\models\EmpBankDetails;
use frontend\modules\hr\models\PayStructureEarnings;
use frontend\modules\hr\models\PayStructureDeductions;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\EmpTypes;
use yii\helpers\Url;
use common\models\Countries;
use common\models\District;
use common\models\Sector;
use common\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Employees */

$this->title = $model->first_name." ".$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    
/*ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;} */  
    
</style>

<?php

$user=Yii::$app->user->identity;

if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
   
$photo=$model->photo;
$uploadUrl=$photo->dir.$photo->id.$photo->file_type;

$imgSrc=='';

 
  if($photo!=null && file_exists($uploadUrl)){
      
 $imgSrc=Yii::getAlias('@web').'/'.$uploadUrl;   
    
}else{
                                         
    $imgSrc=Yii::getAlias('@web').'/img/avatar-user.png';    
   
    }                                    
      

$address=$model->address;
$contact=$model->contact;
$empl=$model->employmentDetails;
$statutory=$model->statutoryDetails;
$supervisor=$empl->supervisor0; 
$pay=$model->payDetails;
$bankAccounts=$model->bankAccounts;

?>

<div class="card card-info card-outline">
         
          <div class="card-body">
          
            <div class="row">
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">
                      <i class="far fa-user"></i> Personal Details</a>
                  <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">
                      <i class="fas fa-briefcase"></i> Employment Details</a>
                  <a class="nav-link" id="vert-tabs-statutory-tab" data-toggle="pill" href="#vert-tabs-statutory" role="tab" aria-controls="vert-tabs-statutory" aria-selected="false">
                     <i class="fas fa-balance-scale"></i> Statutory Details</a>    
                  <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">
                     <i class="fas fa-coins"></i> Pay Details</a>
                  <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">
                      <i class="fas fa-university"></i> Bank Details</a>
                </div>
              </div>
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <div   class="tab-pane text-left fade active show" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                     <div class=" card card-default card-outline">
                         
                         <div class="card-header">
                <h5 class="card-title"><i class="far fa-sticky-note"></i> Summary </h5>

                <div class="card-tools">
                    
                     <?= Html::a('<i class="fas fa-coins"></i> Change Salary ', ['emp-pay-details/update','id'=>$pay->id], 
                                                                           ['class' => 'btn btn-outline-primary btn-sm action-create','title'=>'Change Status']) ?>
                    
                     <?= Html::a('<i class="fas fa-briefcase"></i> Change Job ', ['emp-employment/update','id'=>$empl->id], 
                                                                           ['class' => 'btn btn-outline-success btn-sm action-create','title'=>'Change Status']) ?>
                
                  <?= Html::a('<i class="fas fa-lightbulb"></i> Change Status ', ['emp-status-details/create','emp'=>$model->id], 
                                                                           ['class' => 'btn btn-outline-info btn-sm action-create','title'=>'Change Status']) ?>
                  <?= Html::a('<i class="fas fa-user-shield"></i> Suspend  Employee ', 
                     $model->status=='SUSP'? '#':['emp-suspensions/create','emp'=>$model->id], 
                                                                           ['class' => 'btn btn-outline-warning btn-sm action-create','title'=>'Suspend Employee']) ?>                                                          
                  <?= Html::a('<i class="fas fa-sign-out-alt"></i> Terminate Employee ',
                      $model->status=='TERM'? '#': ['emp-terminations/create','emp'=>$model->id], 
                                                                           ['class' => 'btn btn-outline-danger btn-sm action-create','title'=>'Terminate Employee']) ?>                                                          
                                                                           
               
                 
                </div>
              </div>
                         <div class="card-body mb-1 box-profile">
               
            
                <div class="d-flex" >
                     
                     <div class="image text-center">
        
           <img class="profile-user-img img-fluid img-circle" src="<?php echo  $imgSrc ?>" alt="User Image" width="120" height="120">        
           
            <div class="text-center mt-2">
                    
                    <a href="#" class="btn btn-sm btn-primary">
                     <i class="fas fa-upload"></i>Upload Photo
                    </a>
                  </div>
           </div>  
                 
                   <div class="ml-3">
                      <h2 class="lead "><b><?php echo $model->first_name." ".$model->last_name ?></b></h2>
                      <p class="text-muted text-sm "><?php echo $empl->positionDetails->position ?></p>
                      
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                       <li class="small"><span class="fa-li"><b><i class="far fa-id-badge"></i></span> Emp No: <?php echo $model->employee_no?></b></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Unit: <?php echo $empl->orgUnitDetails->unit_name?></li>
                         <li class="small"><span class="fa-li"><i class="fas fa-envelope-open-text"></i></span> Email: <?php echo $contact->work_email?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $contact->work_phone ?></li>
                    <li class="small"><span class="fa-li"><i class="fas fa-bell"></i></span> Status: 
                     <span class="badge-pill p-1 <?php echo EmployeeStatuses::badgeStyle($model->status0->code) ?>"><?php echo $model->status0->name ?></span> </li>
                      </ul>
                      
                      
                    </div>
                    
                    
                </div>   
                 
               
               

               
              </div>
                     </div>
                
                
                <!-------------------------------basic info------------------------------------------------->
              <div class="row">
              <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-user-tie"></i> Basic Info</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
               <ul class="nav nav-pills flex-column mb-2">
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
                      Name <span class="float-right text-dark "><?= $model->first_name.' '.$model->last_name ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Date of birth <span class="float-right text-dark "><?= $model->birthday?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Gender <span class="float-right text-dark "><?= $model->gender?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Marital Status <span class="float-right text-dark "><?= $model->marital_status?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                      Nationality<span class="float-right text-dark "><?= $model->nationality?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      National Identity Number<span class="float-right text-dark  "><?= $model->nic_num?></span>
                    </a>
                  </li>
                
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Status<span class="float-right text-dark  "><?= $model->status?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
                
                  
                  
              </div>
              
              </div>
              
              <div class="row">
                  
                  <!-- --------------------------address info---------------------------------------->
              
                <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-phone-alt"></i> Contact Info</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0">
               <ul class="nav nav-pills flex-column mb-2">
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                     Work Phone <span class="float-right text-dark "><?= $contact->work_phone?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Work Email <span class="float-right text-dark "><?= $contact->work_email?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     Mobile Phone <span class="float-right text-dark "><?= $contact->mobile_phone?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     Personal Email<span class="float-right text-dark "><?= $contact->personal_email?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
                
              </div>     
                  
              </div>
              
              <div class="row">
                  
                  
                <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-map-marker-alt"></i>  Address Info</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0">
               <ul class="nav nav-pills flex-column mb-2">
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                    Country <span class="float-right text-dark "><?php 
                    $c=Countries::find()->where(['country_code'=>$address->country])->One();
                    $myCountry=$c!=null?$c->country_name:'';
                    echo $myCountry?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   District/Sector/Cell/Village<span class="float-right text-dark "><?php 
                     $addrStr='';
                    $d=District::findOne( $address->district);
                    $s=Sector::findOne( $address->sector);
                    
                     $addrStr.=$d!=null?$d->district:'--';
                     $addrStr.=$d!=null?'/'.$s->sector:'--';
                     $addrStr.=$address->cell!=null?'/'.$address->cell:'';
                    $addrStr.=$address->village!=null?'/'.$address->village:'';
                     echo $addrStr;?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     City <span class="float-right text-dark "><?= $address->city?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Street Number<span class="float-right text-dark "><?= $address->address_line1?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                    House Number<span class="float-right text-dark "><?= $address->address_line2?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                   House Name<span class="float-right text-dark "><?= $address->address_line_3?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
                
              </div>    
                  
              </div>
           
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                  <div class="row">
              <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-briefcase"></i> Employment Info</h3>
                <div class="card-tools">
                    <?php if(($user->role==User::ROLE_PRL_OFFICER) ||  ($user->role==User::ROLE_ADMIN)):?>
                  <a href="<?=Url::to(['emp-employment/update','id'=>$empl->id])?>" class="btn btn-tool btn-sm action-modal" title="<?php echo $model->first_name." ".$model->last_name ?>">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 <?php endif;?>
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
                  
               
               <ul class="nav nav-pills flex-column mb-2">
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
                    Unit/Department  <span class="float-right text-dark "><?= $empl->orgUnitDetails->unit_name?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Position<span class="float-right text-dark "><?= $empl->positionDetails->position?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Joing  Date <span class="float-right text-dark "><?= date('d/m/Y', strtotime($empl->start_date));?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Employment Type <span class="float-right text-dark "><?= $empl->employmentType->name?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                   
                     Supervisor<span class="float-right text-dark "><?= $supervisor->position?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     Location<span class="float-right text-dark "><?= $empl->workLocation->name?></span>
                    </a>
                  </li>
                  
                  
                </ul>
              </div>
            </div>
                
                  
                  
              </div>
              
              </div>
                  </div>
                   <div class="tab-pane fade" id="vert-tabs-statutory" role="tabpanel" aria-labelledby="vert-tabs-statutory-tab">
                  <div class="row">
              <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-balance-scale"></i> Statutory Details</h3>
                <div class="card-tools">
                     <?php if(($user->role==User::ROLE_PRL_OFFICER) ||  ($user->role==User::ROLE_ADMIN)):?>
                  <a href="#" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 <?php endif;?>
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
                  
               
               <ul class="nav nav-pills flex-column mb-2">
                 
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    RSSB Pension Number<span class="float-right text-dark  "><?= $statutory->emp_pension_no?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                  <?php echo $statutory->med_scheme=='RAMA' ? 'RSSB RAMA No.' : 'MMI No.' ?><span class="float-right text-dark "> <?=$statutory->emp_med_no ?></span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
                
                  
                  
              </div>
              
              </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                      <div class="row">
              <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-wallet"></i> Pay Details</h3>
                <div class="card-tools">
                    <?php if(($user->role==User::ROLE_PRL_OFFICER) ||  ($user->role==User::ROLE_ADMIN)):?>
                  <a href="<?=Url::to(['emp-pay-details/update','id'=>$pay->id])?>" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                <?php endif;?> 
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
               <?php
              
              
                $payLevel=$pay->payLevel;
                $payGrp=$pay->payGroup;
              
               $payFr= $payGrp->frequency0;
               $payTmpl=$payGrp->payTemplate;
              
               
               
               
                //--------------------regular earnings--------------------------------
                $modelsEarnings =!empty($payTmpl)?$payTmpl->regularEarningsLines():[];
                
                //--------------------regular deductions--------------------------------
                 $modelsDeduction =!empty($payTmpl)?$payTmpl->regularDeductionsLines():[];
               
          
               
              
              
               
               ?> 
       
               
               <ul class="nav nav-pills flex-column mb-2">
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
                     Pay Level <span class="float-right text-dark text-dark "><?= 'Level-'.$payLevel->number.' : '.$payLevel->name?></span>
                    </a>
                  </li>
               
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Pay Frequency <span class="float-right text-dark "><?=  $payFr->name?></span>
                    </a>
                  </li>
                     <li class="nav-item">
                    <a href="#" class="nav-link">
                    Pay Basis<span class="float-right text-dark "><?= $pay->payType->name?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <?php 
                        switch($pay->pay_basis){
                          case 'SAL':
                              $payBase='Basic Salary';
                              
                              break;
                           case 'MALW':
                               $payBase='Monthly Allowance';
                             
                              break; 
                             case 'HR':
                               $payBase='Hourly Rate ';
                              
                              break;
                              
                              
                        }
                        
                        
                        ?>
                   <?= $payBase ?> <span class="float-right text-dark "><?= $pay->base_pay?></span>
                    </a>
                  </li>
                 
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Pay Group<span class="float-right text-dark "><?= $payGrp->name?></span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                   Pay Template<span class="float-right text-dark "><?=$payTmpl->name?></span>
                    </a>
                  </li>
                </ul>
                
  
               
                 
             
                
              </div>
            </div>
                
                  
                  
              </div>
              
              </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                     <div class="row">
              <div class="col-12 col-sm-12 col-md-12 ">
                  <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-university"></i> Bank  Info</h3>
                <div class="card-tools">
                    <?php if(($user->role==User::ROLE_PRL_OFFICER) ||  ($user->role==User::ROLE_ADMIN)):?>
                  <a href="#" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 <?php endif;?>
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
               
               <?php $i=0; foreach ($bankAccounts as $bankAcc)  : $i++?>
               
               <strong> <i class="fas fa-wallet  ml-3"></i> Account <?php echo $i?></strong>
               <ul class="nav nav-pills flex-column mb-2">
                  
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
                    Bank Name <span class="float-right text-dark "><?= $bankAcc->bank->name?></span>
                    </a>
                  </li>
                  
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                   Bank Branch <span class="float-right text-dark "><?= $bankAcc->bank_branch?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Bank Account <span class="float-right text-dark "><?= $bankAcc->bank_account?></span>
                    </a>
                  </li>
                  
                    <li class="nav-item ">
                    <a href="#" class="nav-link ">
                    Bank Account Holder Type <span class="float-right text-dark "><?php if($bankAcc->acct_holder_type=='SGL'){ echo 'Single';}else if($bankAcc->acct_holder_type=='JT'){echo 'Joint';} ?></span>
                    </a>
                  </li>
                 
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
               Bank Account Reference <span class="float-right text-dark "><?php if($bankAcc->acct_reference=='SAL'){ echo 'Salary';}else if($bankAcc->acct_reference=='LPSM'){echo 'LumpSum';} ?></span>
                    </a>
                  </li>
                  
                </ul>
                
                 <?php endforeach?>
              </div>
            </div>
                
                  
                  
              </div>
              
              </div>
                </div>
              </div>
            </div>
          
          </div>
          <!-- /.card -->
        </div>
        
        </div>
<?php

$script = <<< JS

$(document).ready(function()
                            {
 var table = $(".tbl-pay-details").DataTable({
    "destroy": true,
   "paging": false,
   "ordering": false,
   "searching": false,
   "info":false
});


  $('.action-create').on('click',function (e) {


return false;
 
}); 

                  
                                
                            });
                          



JS;
$this->registerJs($script);

?>

