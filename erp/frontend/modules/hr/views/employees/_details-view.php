<?php
 use frontend\modules\hr\models\Employees;
 use frontend\modules\hr\models\EmpPhoto;
 use yii\helpers\Url;
 
 ?>
 
 <style>
    
ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;}   
    
</style>

 
 <?php

 
  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
     }
    
    
$empl=$model->employmentDetails; 
$address=$model->address;
$contact=$model->contact;
$photo=$model->photo;
$uploadUrl=$photo->dir.$photo->id.$photo->file_type;

$imgSrc=='';

 
  if($photo!=null && file_exists($uploadUrl)){
      
 $imgSrc=Yii::getAlias('@web').'/'.$uploadUrl;   
    
}else{
                                         
    $imgSrc=Yii::getAlias('@web').'/img/avatar-user.png';    
   
    }  

 
 ?>

    
    <div class="card-body box-profile" style="background:#E9F0FB">
               
            
                <div class="d-flex" >
                     <div class="image text-center">
        
           <img class="img-circle  " src="<?php echo  $imgSrc ?>" alt="User Image" width="120" height="120">        
           
            <div class="text-center mt-2">
                    
                    <a href="#" class="btn btn-sm btn-primary">
                     <i class="fas fa-upload"></i>Upload Photo
                    </a>
                  </div>
           </div>  
                 
                   <div class="ml-3">
                      <h2 class="lead "><b><?php echo $model->first_name." ".$model->last_name ?></b></h2>
                      <p class="text-muted text-sm "><?php echo $empl->positionDetails->position ?> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                       <li class="small"><span class="fa-li"><b><i class="far fa-id-badge"></i></span> Emp No: <?php echo $model->employee_no?></b></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Unit: <?php echo $empl->orgUnitDetails->unit_name?></li>
                         <li class="small"><span class="fa-li"><i class="fas fa-envelope-open-text"></i></span> Email: <?php echo $contact->work_email?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $contact->work_phone ?></li>
                      </ul>
                      
                      
                    </div>
                    
                    
                </div>   
                 
               
               

               
              </div>
      
    <div class="card">
              <div class="card-header border-0 ">
                <h3 class="card-title"><i class="fas fa-user-tie"></i> Basic Info</h3>
                <div class="card-tools">
                  <a href="<?=Url::to(['employees/edit-details','id'=>$model->id])?>" class="btn btn-tool btn-sm action-create" title="Edit Basic Info">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
               <ul class="nav flex-column basic-info">
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
                      Name <span class="float-right "><?php echo $model->first_name.' '.$model->last_name ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Date of birth <span class="float-right "><?php echo date('d/m/Y',strtotime($model->birthday)) ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Gender <span class="float-right "><?php echo $model->gender?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Marital Status <span class="float-right "><?php echo $model->marital_status?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                      Nationality<span class="float-right "><?php echo $model->nationality?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      National Identity Number<span class="float-right "><?php echo $model->nic_num?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Social Security Number<span class="float-right "><?php echo $model->statutoryDetails->emp_pension_no?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Medical Number<span class="float-right "><?php echo $model->statutoryDetails->med_scheme?>/<?php echo $model->statutoryDetails->emp_med_no?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Status<span class="float-right  "><?php echo $model->status?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
 
