
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use common\models\UserHelper;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use kartik\depdrop\DepDrop;
use frontend\modules\hr\models\ EmpTypes;
use frontend\modules\hr\models\ EmploymentType;
use frontend\modules\hr\models\ EmploymentStatus;
use frontend\modules\hr\models\ Employees;
use frontend\modules\hr\models\ Locations;
?>
<style>
 

.field-heading {
    border-bottom: 1px solid rgb(161, 161, 161);
    margin-bottom: 31px;
    font-size: 1.3em;
}


/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}

    
</style>


                 <div class="card card-default text-dark">
        
               
           <div class="card-body">
               
         <?php
      
       if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
  
      
     $lvs=ErpOrgLevels::find()->all();
     
     
$orgUnits=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} and active=1 ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $orgUnits[strtoupper($l->level_name."s")]=$data;
    
    $posList=ArrayHelper::map(ErpOrgPositions::find()->all(),'id','position');

   
  
     
             $default_pos_data=array();
             
              if (!empty($model->position)) {
       
         $default_pos_data[$model->position]=$model->position;
             }
            
   

}
               
               ?>
      
          
  
    
    <?php $form = ActiveForm::begin([
                                 'options' => ['enctype' => 'multipart/form-data'],
                                 'id'=>'dynamic-form', 
                                 'enableClientValidation'=>true,
                                 'enableAjaxValidation' => false,
                                 'method' => 'post',
                              
                               ]); ?>
    <?= $form->field($model, 'employee')->hiddenInput(['value'=>$model->employee])->label(false); ?>
   
    
      <h3 class="field-heading"><i class="fas fa-user-edit"></i> Employment Information</h3>
      
         <?=$form->field($model, 'employee_type')
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
                    ->label("Employee Type");
                    ?>
        <div  id="employee" class="row">
            
          <div class="col-sm-12 col-md-4 col-lg-4">
   
     <?= $form->field($model, 'employment_type' ,['template' => '
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
               'id'=>'empl-type-id','class'=>['form-control m-select  ']])->label(" Appointment Type") ?>  
               
               
   
       
   </div>     
      
   <div class="col-sm-12 col-md-4 col-lg-4">
       
       <?= $form->field($model, 'org_unit',['template' => '
                       {label}
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                  <i class="fas fa-industry"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList( $orgUnits, ['prompt'=>'Select  org Unit',
               'id'=>'unit-id','class'=>['form-control m-select unit ']])->label('Department /Unit/Office') ?> 
       
   </div> 
   
   <div class="col-sm-12 col-md-4 col-lg-4">
      
       <?=$form->field($model, 'position')->widget(DepDrop::classname(), [
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
   

   
 
      
  </div>  
    

  
 
    
 
 <div class="row">
     <div class="col-sm-12 col-md-6 col-lg-6">
          
           <?= $form->field($model, 'start_date',['template' => '
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
      
  
   
 <div class="col-sm-12 col-md-6 col-lg-6">
          
            <?= $form->field($model, 'end_date',['template' => '
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
   
<div class="row">
    
    
       <div class="col-sm-12 col-md-6 col-lg-6">
           <?= $form->field($model, 'work_location' )
     ->dropDownList([ArrayHelper::map(Locations::find()->all(), 'id', 'name')], ['prompt'=>'Select  location',
               'id'=>'work-location','class'=>['form-control m-select ']]) ?>    
            
        </div>
        
        
   <div class="col-sm-12 col-md-6 col-lg-6">
       <?= $form->field($model, 'supervisor',['template' => '
                       {label}
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                 <i class="fas fa-user-tie"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList( $posList, ['prompt'=>'Select  Reporting To',
               'id'=>'super-id','class'=>['form-control m-select super ']])->label('Reporting To') ?> 
       
   </div>
</div>

 <?php  $modelOptions->create=1;
 
 echo $form->field($modelOptions, 'create')->checkbox(['id'=>'checkCreate'])
			->label('New job assignement'); ?> 
    
  <div class="form-group text-left">
        <?= Html::submitButton($model->isNewRecord? 'Save':'Update' , ['class' =>$model->isNewRecord? 'btn  btn-outline-primary': 'btn  btn-outline-success']) ?>
    </div>
    
  
    

    <?php ActiveForm::end(); ?>

</div>
</div>




<?php

$script = <<< JS

 $(document).ready(function(){
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
     $(".m-select").select2({theme: 'bootstrap4'});
     
    
     
});

JS;
$this->registerJs($script);

?>

