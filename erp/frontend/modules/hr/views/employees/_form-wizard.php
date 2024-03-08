<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\db\Query;
use common\models\User;
use common\models\UserHelper;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use common\models\Countries;
use kartik\depdrop\DepDrop;
use frontend\modules\hr\models\ EmpTypes;
use frontend\modules\hr\models\ EmploymentType;
use frontend\modules\hr\models\ EmployeeStatuses;
use frontend\modules\hr\models\ PayItems;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\ PayLevels;
use frontend\modules\hr\models\Payfrequency;
use frontend\modules\hr\models\Locations;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\StatutoryDeductions;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\modules\hr\models\PayTypes;
use frontend\modules\hr\models\Banks;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 



$this->title = 'Add New Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<style>

/*-------------------required fields indicator----------------------------------------*/
 .required .input-group:after, span.required {
    color: #e32;
    content: ' *';
    display:inline;
    font-size:18px;
    font-weight:bold;
}

/*------------------------select 2 prepend+append styling------------------------------------------*/

.input-group > .select2-container--bootstrap4 {
    width: auto;
    flex: 1 1 auto;
}

.input-group > .select2-container--bootstrap4 .select2-selection--single {
    height: 100%;
    line-height: inherit;
    /*padding: 0.5rem 1rem;*/
}

/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}

/*-----------------------------force show invalid feedback---------------------------------------------------------------*/
.invalid-feedback {
  display: block;
}

.fix-label-item {
    height: calc(2.25rem + 2px);
    padding:0;
    margin:0;
   }
   
   
</style>



<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-user-edit"></i> Employee Details</h3>
                       </div>
               
           <div class="card-body">

<div class="progress">
                  <div class="progress-bar bg-info progress-bar-striped" role="progressbar"  aria-valuemin="0" aria-valuemax="100" >
                    <span class="sr-only">40% Complete (success)</span>
                  </div>
                </div>
    
      <?php 
 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
     $user=Yii::$app->user->identity;
  
  ?>

  

<?php $form = ActiveForm::begin([
                                 'options' => ['enctype' => 'multipart/form-data'],
                                 'id'=>'add-emp-form', 
                                 'enableClientValidation'=>true,
                                 'enableAjaxValidation' => false,
                                 'method' => 'post',
                                 
                              
                               ]); ?>
                               
       
       
       

       <div id="smartwizard">
            
            
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1">Page 1<br /><small><i class="fas fa-user-edit"></i> Personal Details</small></a></li>
                <li><a class="nav-link" href="#step-2">Page 2<br /><small><i class="fas fa-phone"></i> Contact Details</small></a></li>
                <li><a class="nav-link"  href="#step-3">Page 3<br /><small><i class="fas fa-map-marker-alt"></i> Address Details</small></a></li>
                <li><a class="nav-link" href="#step-4">Page 4<br /><small><i class="fas fa-balance-scale"></i> Statutory  Details</small></a></li>
                <li><a class="nav-link" href="#step-5">Page 5<br /><small><i class="fas fa-suitcase"></i> Employment Details</small></a></li>
                <li><a class="nav-link" href="#step-6">Page 6<br /><small><i class="fas fa-suitcase"></i> Pay Details</small></a></li>
             
                
              
                 
               
                 
             
                
                
               
            </ul>

            <div class="tab-content">
                
            <div class="tab-custom-content">
             <p class="lead small mb-2 ml-3 text-right" ><span class=" text-red required"> *</span> [Required]</p>
           
            <div class="card-header">
                 <h3 class="field-heading"><i class="fas fa-user-clock"></i> Personnel Type </h3>
         
           <?=
                    $form->field($model, 'employee_type')
                        ->radioList(
                            ArrayHelper::map(EmpTypes::find()->orderBy(['display_order'=>SORT_ASC])->all(), 'code', 'name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label(false);
                    ?>
                    
                
            </div>
          
          
            </div>  
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                      
                    
                <h3 class="field-heading"><i class="fas fa-user-edit"></i> Add Basic Information</h3>
                
              
                
                <div class="row">
                  
                  <div class="col-sm-12 col-md-4 col-lg-4">
                      
                      <?= $form->field($model, 'first_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{hint}{error}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'firstname']) ?>
                      
                    

   
                  </div> 
                   <div class="col-sm-12 col-md-4 col-lg-4">
                      
       <?= $form->field($model, 'middle_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'middlename']) ?>           

   

    
                  </div> 
                  
                   <div class="col-sm-12 col-md-4 col-lg-4">
      
      <?= $form->field($model, 'last_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'lastname']) ?>       

   
                  </div>
                    
                </div>
                    
    <div class="row">
        
          <div class="col-sm-12 col-md-4 col-lg-4">
              
              <?= $form->field($model, 'birthday', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control date'],'placeholder'=>'date of birth...'])->label(false)?> 
            
              
                

   
          </div>
          
           <div class="col-sm-12 col-md-4 col-lg-4">
              
                
         <?= $form->field($model, 'gender',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   <i class="fas fa-venus-mars"></i>
                                </span>
                               
                                </div>
                        {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ 'Male' => 'Male', 'Female' => 'Female' ], ['prompt'=>'Select  gender',
               'id'=>'g_id','class'=>['form-control m-select gender ']]) ?>     

   

    
          </div>
           <div class="col-sm-12 col-md-4 col-lg-4">
           
            <?= $form->field($model, 'marital_status',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   <i class="fas fa-venus-mars"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ 'Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed', 'Other' => 'Other', ], 
               ['prompt'=>'Select  marital status',
               'id'=>'ms_id','class'=>['form-control m-select ms ']]) ?>     
                
 
          </div>
    </div>

   
   <div class="row">
       
        <div class="col-sm-12 col-md-4 col-lg-4">
        
         <?= $form->field($model, 'nationality',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-globe-africa"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ArrayHelper::map(Countries::find()->all(), 'country_code', 'country_name')], ['prompt'=>'Select  nationality',
               'id'=>'nat-id','class'=>['form-control m-select nat-class ']]) ?>   
               
          
        </div>
        
         <div class="col-sm-12 col-md-4 col-lg-4">
           
             <?= $form->field($model, 'nic_num', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                <i class="far fa-id-card"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'National Identity Card (NID)']) ?> 
           
        </div>
        
         <div class="col-sm-12 col-md-6 col-lg-4">
             <?= $form->field($model, 'other_id', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   <i class="far fa-id-card"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Other ID (Passport,...)']) ?> 
            
           </div>
        
        
       
   </div>
    
 

  <div class="row">
      
                <?php if(empty($model->status)) $model->status='ACT';  ?>
                 <div class="col-sm-12 col-md-6 col-lg-4">
                        <?= $form->field($model, 'status',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   <i class="fas fa-lightbulb"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ArrayHelper::map(EmployeeStatuses::find()->all(), 'code', 'name')], 
               ['prompt'=>'Select employee status ','id'=>'status-id','class'=>['form-control m-select  ']]) ?>   
              
           </div>
      
  </div>
  
  <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4">
        
          <?php if(!empty($model->photo)){
           
    $previewURL=Yii::$app->request->baseUrl.'/'.$model->photo->dir.$model->photo->id.$model->photo->file_type;

                        } else{

                            $previewURL=Yii::$app->request->baseUrl . '/' ."img/avatar-user.png";
                           

                        } 
                     
                       
                        ?>
          
                                       <?= $form->field($modelPhoto, 'upload_file')->widget(FileInput::classname(), [
                                           
                                           
                                           'pluginOptions'=>['allowedFileExtensions'=>['jpg','png'],
                                           'theme'=>'fas',
                                           'showCaption' => false,
                                           'showRemove' =>false,
                                            'showCancel' =>false,
                                           'showUpload' => false,
                                           'browseClass' => 'btn btn-primary btn-upload btn-block',
                                           'browseIcon' => '<i class="fas fa-camera"></i> ',
                                           'browseLabel' =>  'Select Photo',
                                           
                                           'initialPreview'=>[ Html::img($previewURL,['class'=>' kv-preview-data file-preview-image', 
                                          'width'=>'auto','height'=>'auto','max-width'=>'100%','max-height'=>'100%','alt'=>' Missing', 'title'=>'missing'])],
                                          'overwriteInitial'=>true
                                          
                                         
                                        
                                        
                                        
                                        ],'options' => ['accept' => 'image/*']
                                              ])?>

      </div>
      
  </div>

   

              

                </div>
   
   
   <!-- ---------------------------------------step 2--------------------------------------------------------------------->             
                <div id="step-2" class="tab-pane" role="tabpanel">
                    
        <h3 class="field-heading"><i class="fas fa-user-tag"></i> Add Contact  Information</h3> 
        
    <div class="row">
       
       <div class="col-sm-12 col-md-3 col-lg-3">
           
            <?= $form->field($modelContact, 'work_phone', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                <i class="fas fa-phone-alt"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'work phone']) ?> 
        
          
       </div> 
       
         <div class="col-sm-12 col-md-3 col-lg-3">
             
              <?= $form->field($modelContact, 'mobile_phone', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                <i class="fas fa-phone-alt"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'mobile phone']) ?> 
        
        
           
       </div>
       
        <div class="col-sm-12 col-md-3 col-lg-3">
            
             <?= $form->field($modelContact, 'work_email', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                               <i class="fas fa-envelope-open"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'work email']) ?> 
        
        
           
       </div>
       
        <div class="col-sm-12 col-md-3 col-lg-3">
            
             <?= $form->field($modelContact, 'personal_email', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                               <i class="fas fa-envelope-open"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'personal email']) ?> 
        
         
           
       </div>
       
        
    </div>

   

   

   

   
    
                 </div>
              
                <div id="step-3" class="tab-pane" role="tabpanel">
                             
                             <h3 class="field-heading"><i class="fas fa-map-marker-alt"></i> Current Address Information</h3>
                
                
                <?= $form->field($modelAddressCurrent, 'country',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-globe-europe"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ArrayHelper::map(Countries::find()->all(), 'country_code', 'country_name')], 
               ['prompt'=>'Select  country ','id'=>'country-id','class'=>['form-control m-select country-class ']]) ?>               
                   
                   
                 
   
    <div class="RW">
        
     <div class="row">
        
          <div class="col-sm-12 col-md-3 col-lg-3">
       
       
    <?=$form->field($modelAddressCurrent, 'province')->widget(DepDrop::classname(), [
    'options'=>['id'=>'province-id'],
    'pluginOptions'=>[
        'depends'=>['country-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select province...',
        'url'=>Url::to(['country/provinces'])
    ]
])?>    
      
         
     </div> 
     
     
     <div class="col-sm-12 col-md-4 col-lg-4">
        
         <?=$form->field($modelAddressCurrent, 'district')->widget(DepDrop::classname(), [
    'options'=>['id'=>'district-id'],
    'pluginOptions'=>[
        'depends'=>['province-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['province/districts'])
    ]
])?>     
         
     </div> 
     
     <div class="col-sm-12 col-md-4 col-lg-4">
       
         <?=$form->field($modelAddressCurrent, 'sector')->widget(DepDrop::classname(), [
            
    'options'=>['id'=>'sector-id'],
    'pluginOptions'=>[
        'depends'=>['district-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['district/sectors'])
    ]
])?>    
         
     </div> 
    
  
    </div>   
        
    </div>
    
    
    <div class="RW">
        
      <div class="row">
        
         <div class="col-sm-12 col-md-6 col-lg-6">
         
          <?= $form->field($modelAddressCurrent, 'cell')->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Cell']) ?> 
         
          

     </div> 
     
     <div class="col-sm-12 col-md-6 col-lg-6">
         
          <?= $form->field($modelAddressCurrent, 'village')->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'village']) ?> 
         
          

     </div> 
     
     
    </div>   
    </div>
   
    
  

    <?= $form->field($modelAddressCurrent, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelAddressCurrent, 'address_line1')->textInput(['maxlength' => true,'placeholder'=>'Street No.']) ?>
    <?= $form->field($modelAddressCurrent, 'address_line2')->textInput(['maxlength' => true,'placeholder'=>'House No.']) ?>
    <?= $form->field($modelAddressCurrent, 'address_line_3')->textInput(['maxlength' => true,'placeholder'=>'House Name']) ?>
                             
    </div>
    
            <div id="step-4" class="tab-pane" role="tabpanel">
   
   <h3 class="field-heading mt-2"><i class="fas fa-balance-scale"></i> Add Statutory Information</h3>              

  
    
   
<?php
   $modelStatutoryDetails->med_scheme='RAMA';
   $content=Html::activeDropDownList($modelStatutoryDetails, 'med_scheme', ['RAMA'=>'RAMA','MMI'=>'MMI'],['class'=>'custom-select med-scheme']);
   $tmpl='{label}';
   $tmpl.=Html::tag('div',Html::tag('div',Html::tag('span', $content,['class'=>'input-group-text fix-label-item']),['class'=>'input-group-prepend']).'{input}',['class'=>'input-group col-sm-12']);
   $tmpl.='{error}{hint}';
?>
  
             
<?= $form->field($modelStatutoryDetails, 'emp_med_no', ['template' =>$tmpl])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'RAMA/MMI No...','id'=>'med-no'])->label('RAMA/MMI')?>
                                
  <?=$form->field($modelStatutoryDetails, 'emp_pension_no')
             ->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'PENSION No...'])->label('PENSION') ?>  

                    
                    
    

                 
                </div>
              
            <div id="step-5" class="tab-pane" role="tabpanel">
   
   <h3 class="field-heading mt-2"><i class="fas fa-briefcase"></i> Add Employment Information</h3>              
           
   

                                <?php
                           
$lvs=ErpOrgLevels::find()->all();
$options=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} and active=1 ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $options[strtoupper($l->level_name."s")]=$data;
    
   
   
  
   

}

    
    ?>
    
  <div class="row">
      
    <div class="col-sm-12 col-md-4 col-lg-4">
   
     <?= $form->field($modelEmployment, 'employment_type' ,['template' => '
                           {label}
                       <div class="input-group col-sm-12">
                      
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                <i class="fas fa-business-time"></i>
                                </span>
                                
                                </div>
                     {input}
                          
                           
                           
                       </div>{error}{hint}
               '])
     ->dropDownList([ArrayHelper::map(EmploymentType::find()->all(), 'code', 'name')], ['prompt'=>'Select  employment type',
               'id'=>'empl-type-id','class'=>['form-control m-select  ']])->label("Employement Type") ?>  
               
               
   
       
   </div> 
   
   <div class="col-sm-12 col-md-4 col-lg-4">
          
           <?= $form->field($modelEmployment, 'start_date',['template' => '
                          {label}
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])
           ->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'start date...'])?>
      </div> 
      
  
   
 <div class="col-sm-12 col-md-4 col-lg-4">
          
            <?= $form->field($modelEmployment, 'end_date',['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])
             ->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'termination date...']) ?>
      </div>
      
  </div> 
  
   <div id="ext-body" class="row job-det SEB">
      
      
      
  </div>
  
  
  <div  id="employee" class="row">
      
   <div class="col-sm-12 col-md-4 col-lg-4">
       
       <?= $form->field($modelEmployment, 'org_unit',['template' => '
                       {label}
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                  <i class="fas fa-industry"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList( $options, ['prompt'=>'Select  org Unit',
               'id'=>'unit-id','class'=>['form-control m-select unit ']])->label('Department /Unit/Office') ?> 
       
   </div> 
   
   <?php
       
      
             
             $default_pos_data=array();
             
              if (!$modelEmployment->isNewRecord) {
       
         $default_pos_data[$modelEmployment->position]=$modelEmployment->position;
             }
         
      
        
       ?>
   <div class="col-sm-12 col-md-4 col-lg-4">
      
       <?=$form->field($modelEmployment, 'position')->widget(DepDrop::classname(), [
    'data'=> $default_pos_data,
    'options'=>['id'=>'position-id'],
    'pluginOptions'=>[
        'depends'=>['unit-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['erp-org-units/positions'])
    ]
])?>     
       
   </div> 
   
   <?php $empList=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id','position')  ?>
   
   <div class="col-sm-12 col-md-4 col-lg-4">
       <?= $form->field($modelEmployment, 'supervisor',['template' => '
                       {label}
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                 <i class="fas fa-user-tie"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList( $empList, ['prompt'=>'Select  Reporting To',
               'id'=>'super-id','class'=>['form-control m-select super ']])->label('Reporting To') ?> 
       
   </div> 
      
  </div>  
  
 
    
 
 <div class="row">
    
      
       <div class="col-sm-12 col-md-4 col-lg-4">
           <?= $form->field($modelEmployment, 'work_location' )
     ->dropDownList([ArrayHelper::map(Locations::find()->all(), 'id', 'name')], ['prompt'=>'Select  location',
               'id'=>'work-location','class'=>['form-control m-select2 ']]) ?>    
            
        </div>
     
 </div>   
  <h3 class="field-heading mt-3"><i class="far fa-user"></i> ERP Account Information</h3>
  <p>This is how Employee will be able to access ERP and how to identify him.</p>
   <div class="row">
       
       
       <?php $usersList=ArrayHelper::map(User::find()->all(), 'user_id',function($model){
       return $model->first_name." ".$model->last_name;
   })  ?>
   
   <div class="col-sm-12 col-md-12 col-lg-12">
       <?= $form->field($modelUserDetails, 'user_id')->dropDownList( $usersList, ['prompt'=>'Select  User',
               'id'=>'user-id','class'=>['form-control m-select2 user ']])->label('Select User') ?> 
       
   </div> 
       
    
               
               
          
       
   </div>



       
                 
                </div>
                
           <div id="step-6" class="tab-pane" role="tabpanel">
                
                <div class="card-header pl-0 mb-2">
                            <h3 class="card-title"><i class="fas fa-coins"></i> Pay Details</h3>
                       </div>
                
                     
                      <?php 
                             
                              
                               $gradeList=ArrayHelper::map(PayLevels::find()->all(), 'id',function($model){
                        
                        return 'Level-'.$model->number." : ".$model->description;
                        
                    }) 
                             
                              ?> 
                     
                     
                        
                 <div class="row">
                          
                          <div class="col-sm-12">
                            <?=
                    $form->field($modelPayDetails, 'pay_basis')
                        ->radioList(
                           ArrayHelper::map(PayTypes::find()->all(), 'code','name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary pay-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="pay-type-radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="pay-type-radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )->label("Employee is Paid")
                    ;
                    ?>
                    
                    
                          </div>  
                            
                        </div>
                        
                      <div class="row ">
                        
                         <div class="col-sm-12 col-md-4 col-lg-4">
                             
                          <?= $form->field($modelPayDetails, 'pay_level' ,['options' => ['class' => 'form-group flex-grow-1']])
     ->dropDownList($gradeList, ['prompt'=>'Select  pay level',
               'id'=>'pay-grade','class'=>['form-control m-select2 pay-grade'],'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-levels/basic-sal?id=').'"+$(this).val(), function( data ) {
				  $( "#base-pay" ).val(data.bs).prop("readonly", true);
				 
				});
			'])->label("Pay Level") ?>  
                  
                             
                         </div>
                        
                         <div class="col-sm-12 col-md-4 col-lg-4">
                             
                            <?= $form->field($modelPayDetails, 'base_pay')->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Amount...','id'=>'base-pay','class'=>['form-control  input-format']])->label("Basic Pay / Monthly Allowance") ?>     
                             
                         </div>
             
             
              <div class="col-sm-12 col-md-4 col-lg-4">
        
        <?= $form->field($modelPayDetails, 'pay_group' )
     ->dropDownList([ArrayHelper::map(PayGroups::find()->regular()->all(), 'code', 'name')], ['prompt'=>'Select  pay group',
               'id'=>'pay-group','class'=>['form-control m-select2 pay-group '],'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-groups/pay-template?code=').'"+$(this).val(), function( data ) {
				  $( "#pay-tmpl" ).val(data.code).change();
				});
			'])->label("Pay Group") ?>  
        
        
   
    
       
   </div>
                       
                    </div>
              
   <div class="card-header pl-0 mb-2">
                            <h3 class="card-title"><i class="fas fa-coins"></i>  Supplemental  Pay Details</h3>
                       </div>          
        
            
 <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' =>0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelPaySupplements[0],
        'formId' => 'add-emp-form',
        'formFields' => [
            'item',
            'amount',
            'pay_group',
          
           
        ],
    ]); ?>
    
<div class="table-responsive">
      <table id="tbl-suppl" class="table table-condensed tbl-dyn-form"  width="100%">
        <thead>
            <tr>
              
                <th  class="text-left vcenter" >Suppl Type</th>
                <th  class="text-left vcenter" >Suppl Amount</th>
                <th  class="text-left vcenter" >Suppl Pay Group</th>
                <th class="text-right vcenter" width="5%"><i class="fas fa-cog"></i></th>
            </tr>
        </thead>
        <tbody class="container-items">
           <?php foreach ($modelPaySupplements  as $i => $modelSupplement): ?>
                
                <tr class="item">
                   <td>
                 
                  <?php
                            // necessary for update action.
                            if (! $modelSupplement->isNewRecord) {
                                echo Html::activeHiddenInput($modelSupplement, "[{$i}]id");
                       
                            }
                        ?>         
                <?= $form->field($modelSupplement, "[{$i}]item")->dropDownList(ArrayHelper::map(PayItems::find()->suppl()->all(), 'id', 'name'), 
               ['prompt'=>'Select  Supplement Type','id'=>'suppl-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>         
                        
                    </td>
                    
                    <td>
                         
             
                   <?= $form->field($modelSupplement, "[{$i}]amount")->textInput(['maxlength' => true,'class'=>['form-control form-control-sm','placeholder'=>'Amount...']])->label(false) ?>     
                   
                     </td>
                    
                     <td>
                  
                       <?= $form->field($modelSupplement, "[{$i}]pay_group")->dropDownList(ArrayHelper::map(PayGroups::find()->suppl()->all(), 'code', 'name'), 
                  ['prompt'=>'Select  Supplemental Pay Group','id'=>'group-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>     
                        
                    </td>
                    
                    <td class="text-right vcenter" width="5%">
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="text-right vcenter"><button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>
  
    
            </div>
   
  <?php DynamicFormWidget::end(); ?>         
            
            
   
    
     <div class="card-header pl-0 mb-1">
                            <h3 class="card-title"><i class="fas fa-university"></i>  Bank  Details</h3>
                       </div>          
     
              
 <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-2', // required: css class selector
        'widgetItem' => '.item-2', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' =>0, // 0 or 1 (default 1)
        'insertButton' => '.add-item-2', // css class
        'deleteButton' => '.remove-item-2', // css class
        'model' =>$modelBankAccounts[0],
        'formId' => 'add-emp-form',
        'formFields' => [
            'bank_name',
            'bank_branch',
            'bank_account',
            'acct_holder_type',
            'acct_reference',
          
           
        ],
    ]); ?>
    
<div class="table-responsive">
      <table id="tbl-bank-accounts" class="table table-condensed tbl-dyn-form"  width="100%">
        <thead>
            <tr>
              
                <th  class="text-left vcenter">Bank Name</th>
                <th  class="text-left vcenter" >Bank Branch</th>
                <th  class="text-left vcenter" >Account Number</th>
                <th  class="text-left vcenter" >Account Holder Type</th>
                <th  class="text-left vcenter" >Account Reference</th>
                <th class="text-right vcenter"><i class="fas fa-cog"></i></th>
            </tr>
        </thead>
        <tbody class="container-items-2">
           <?php foreach ($modelBankAccounts  as $i => $modelBankAcc): if(empty($modelBankAcc->acct_holder_type)) $modelBankAcc->acct_holder_type='SGL'?>
                
                <tr class="item-2">
                   <td width="25%">
                 
                  <?php
                            // necessary for update action.
                            if (! $modelBankAcc->isNewRecord) {
                                echo Html::activeHiddenInput($modelBankAcc, "[{$i}]id");
                       
                            }
                        ?>         
                <?= $form->field($modelBankAcc, "[{$i}]bank_code")->dropDownList( ArrayHelper::map(Banks::find()->orderBy(['sort_code'=>SORT_ASC])->all(), 'sort_code', 'name'), 
                  ['prompt'=>'Select  Bank Name','id'=>'bank-type-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>         
                        
                    </td>
                    
                    <td>
                         
             
            <?= $form->field($modelBankAcc, "[{$i}]bank_branch")->textInput(['maxlength' => true,'class'=>['form-control form-control-sm','placeholder'=>'Bank Branch...']])->label(false) ?>     
                   
                     </td>
                     
                    <td>
                        
            <?= $form->field($modelBankAcc, "[{$i}]bank_account")->textInput(['maxlength' => true,'class'=>['form-control form-control-sm','placeholder'=>'Account Number...']])->label(false) ?>              
                        
                    </td>
                    
                     <td  width="10%">
                  
                       <?= $form->field($modelBankAcc, "[{$i}]acct_holder_type")->dropDownList( ['SGL'=>'Single','JT'=>'Joint'], 
                  ['prompt'=>'Select  Account Holder Type','id'=>'holder-type-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>     
                        
                    </td>
                 <td width="10%">
                  
                       <?= $form->field($modelBankAcc, "[{$i}]acct_reference")->dropDownList( ['SAL'=>'Salary','ALW'=>'Allowance','LPSM'=>'Lump Sum','BON'=>'Bonus'], 
                  ['prompt'=>'Select  Account Reference','id'=>'ref-type-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>     
                        
                    </td>    
                    <td class="text-right vcenter" width="5%">
                        <button type="button" class="remove-item-2 btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td class="text-right vcenter"><button type="button" class="add-item-2 btn btn-success btn-xs"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>
  
    
            </div>
   
  <?php DynamicFormWidget::end(); ?>
  
     
     <!------------------------------------------NET PAY SPLIT------------------------------------------------------------------------------->
    <div class="card-header pl-0 mb-1">
                            <h3 class="card-title"><i class="fas fa-divide"></i>  Net Pay Splits</h3>
                       </div>          
     
              
 <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_3', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-3', // required: css class selector
        'widgetItem' => '.item-3', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' =>0, // 0 or 1 (default 1)
        'insertButton' => '.add-item-3', // css class
        'deleteButton' => '.remove-item-3', // css class
        'model' =>$modelPaySplits[0],
        'formId' => 'add-emp-form',
        'formFields' => [
            'bank_name',
            'acc_number',
           
          
           
        ],
    ]); ?>
    
<div class="table-responsive">
      <table id="tbl-pay-splits" class="table table-condensed tbl-dyn-form"  width="100%">
        <thead>
            <tr>
              
                <th  class="text-left vcenter">Bank Name</th>
                <th  class="text-left vcenter" >Account Number</th>
                 <th  class="text-left vcenter" >Account Holder Type</th>
                <th  class="text-left vcenter" >Account Holder Name</th>
                <th  class="text-left vcenter" >Split Method</th>
                <th  class="text-left vcenter" >Split Value</th>
                <th class="text-right vcenter"><i class="fas fa-cog"></i></th>
            </tr>
        </thead>
        <tbody class="container-items-3">
           <?php foreach ($modelPaySplits  as $i => $modelPaySplit): if(empty($modelPaySplit->split_type)) $modelPaySplit->split_type='AMT'?>
                
                <tr class="item-3">
                 
                   <td width="25%">
                 
                  <?php
                            // necessary for update action.
                            if (! $modelPaySplit->isNewRecord) {
                                echo Html::activeHiddenInput($modelPaySplit, "[{$i}]id");
                       
                            }
                        ?>         
                <?= $form->field($modelPaySplit, "[{$i}]bank_name")->dropDownList( ArrayHelper::map(Banks::find()->orderBy(['sort_code'=>SORT_ASC])->all(), 'sort_code', 'name'), 
                  ['prompt'=>'Select  Bank Name','id'=>'bank-name-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>         
                        
                    </td>
                     
                     <td>
                        
            <?= $form->field($modelPaySplit, "[{$i}]acc_number")->textInput(['maxlength' => true,'class'=>['form-control form-control-sm','placeholder'=>'Account Number...']])->label(false) ?>              
                        
                    </td>
                    
               <td  width="10%">
                  
                       <?= $form->field($modelPaySplit, "[{$i}]acc_holder_type")->dropDownList( ['owner'=>'Owner','spouse'=>'Spouse','other'=>'Other'], 
                  ['prompt'=>'Select  Account Holder Type','id'=>'holder-type-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>     
                        
                    </td>         
                    <td>
                         
             
            <?= $form->field($modelPaySplit, "[{$i}]acc_holder_name")->textInput(['maxlength' => true,'class'=>['form-control form-control-sm','placeholder'=>'Account Holder Name...']])->label(false) ?>     
                   
                     </td>
                     
         <td width="10%">
                  
                       <?= $form->field($modelPaySplit, "[{$i}]split_type")->dropDownList( ['AMT'=>'Amount','PCT'=>'Percentage'], 
                  ['prompt'=>'Select  Split Method','id'=>'split-type-id','class'=>['form-control form-control-sm m-select2 ']])->label(false) ?>     
                        
                    </td>
           <td>
                         
             
            <?= $form->field($modelPaySplit, "[{$i}]split_value")->textInput(['maxlength' => true,'class'=>['form-control form-control-sm','placeholder'=>'Value...']])->label(false) ?>     
                   
                     </td>  
                    
                    <td class="text-right vcenter" width="5%">
                        <button type="button" class="remove-item-3 btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></button>
                    </td>
                    
                    
                </tr>
                
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6"></td>
                <td class="text-right vcenter"><button type="button" class="add-item-3 btn btn-success btn-xs"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>
  
    
            </div>
   
  <?php DynamicFormWidget::end(); ?>  
    
                 
                </div>
                
                
  
</div><!--end div contnt ---->

</div><!--end div wizard ---->

<?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>



<?php
 $user=Yii::$app->user->identity;
 $userinfo=UserHelper::getPositionInfo($user->user_id); 
 $userposition=$userinfo['position_code'];
 
  
if(!$model->isNewRecord){
    
 $bntLabel='Update'; 
 $enableAllAnchors=true;
}
else{
  $bntLabel='Save';
  $enableAllAnchors=false;
}

$sal_level_wise_url=Url::to(['pay-levels/basic-sal']);



$script = <<< JS

 
$(document).ready(function(){
    
  
   $('.tbl-dyn-form').DataTable( {
      destroy: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: true,
       responsive: true,
      language: {
      emptyTable: " "
    }
       
     /*language : {
        "zeroRecords": " "             
    },*/
     
		
	
	} );
    
     //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({theme: 'bootstrap4'});
     $('#input-format').number( true);
   
     
     //------------------------on country select--------------------------

$("#country-id").on('change.yii',function(){
  
   if($(this).val() !=='RW'){
       
       $("div.RW").hide(); 
   } else{
       
       $("div.RW").show();  
   }
      

});


var form_count = 1;

            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                
         //--------------------------prevent backward validation       
                if(stepDirection=='backward')return true;
    
    data = $("#add-emp-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#add-emp-form").yiiActiveForm("validate");

    var currentstep=stepNumber+1;
    

  
   
   if($("#step-"+currentstep).find(".invalid-feedback").contents().length >0){
            e.preventDefault();
            return false;
        }
        
       
   
    return true;
   
             
            });
            
            
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
            
                if(stepDirection==='forward'){
                    
                     setProgressBarValue(++form_count);
                }else if(stepDirection==='backward'){
                    
                   setProgressBarValue(--form_count); 
                }
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
               $('.submit').css("display","none") ;
              //------------------------show Save button-------------------------------
              if(stepPosition === 'last')
              {
                 $('.submit').show(); 
            
                  
              }
              else{
                  
                $('.submit').css("display","none") ; 
              }
              
             
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('{$bntLabel}')
                                             .addClass('btn btn-info submit')
                                             .on('click', function(){ $('#add-emp-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger btn-cancel')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
            
                                             
                                        smartWizardConfig.init(0,[btnFinish],theme='arrows',animation='none',Boolean($enableAllAnchors));
                
       

function setProgressBarValue(value){
    var percent = parseFloat(100 / 5) * value;
    percent = percent.toFixed();
    $(".progress-bar")
      .css("width",percent+"%")
      .html(percent+"%");   
  } 
 
 $('.job-det').hide();
 $('.wage').hide();

toggleInputs(jQuery("#emp-type-id").val()); 
toggleInputs2(jQuery('input:radio[name="EmpPayDetails[pay_type]"]:checked').val()); 
 
 $('#emp-type-id').on('change.yii',function(){
 $('.emp-type-hidden').val($(this).val());
 toggleInputs($(this).val());

});

 $('input:radio[name="EmpPayDetails[pay_type]"]').on('change.yii',function(){
 
 toggleInputs2($('input:radio[name="EmpPayDetails[pay_type]"]:checked').val());

});

function toggleInputs(optValue){
  if(optValue!=='') {
    
 $('.job-det').not('.'+ optValue).hide();
$('.'+ optValue).show();    
}
  
}

function toggleInputs2(ckValue){
  if(ckValue!=='') {
    
 $('.wage').not('.'+ ckValue).hide();
$('.'+ ckValue).show();    
}
  
}

     
});

JS;
$this->registerJs($script);

?>

<?php

$script2 = <<< JS


//------basic salary validation
function employeeTypeChecked (attribute, value) {
        return $('input:radio[name="Employees[employee_type]"]:checked').val()=='EMP';
	};
	
	
//------basic salary validation
function salaryTypeSelect (attribute, value) {
        return $('input:radio[name="EmpPayDetails[pay_type]"]:checked').val()=='SAL';
	};
     
//------basic salary validation
function allowanceTypeSelect (attribute, value) {
        return $('input:radio[name="EmpPayDetails[pay_type]"]:checked').val()=='MALW';
	};


//------basic salary validation
function onRAMAChecked (attribute, value) {
        return $('input:radio[name="EmpStatutoryDetails[med_scheme]"]:checked').val()=='RAMA';
	};
     
//------basic salary validation
function onMMIChecked (attribute, value) {
        return $('input:radio[name="EmpStatutoryDetails[med_scheme]"]:checked').val()=='MMI';
	};
    


     

JS;
$this->registerJs($script2,$this::POS_HEAD);

?>