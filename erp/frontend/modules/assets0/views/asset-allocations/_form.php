<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\assets0\models\Assets;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use frontend\modules\hr\models\Employees;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetDispositions */
/* @var $form yii\widgets\ActiveForm */
?>

<style>

/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}    
</style>

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-people-carry"></i> Asset Allocation</h3>
                       </div>
               
           <div class="card-body">
               
               <?php
               
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   } 
      
      $lvs=ErpOrgLevels::find()->all();
$orgUnitList=array();
foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} and active=1 ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $orgUnitList[strtoupper($l->level_name."s")]=$data;
    

}

$employeeList=ArrayHelper::map(Employees::find()->all(), 'id', function($model){
       
       return $model->first_name.' '.$model->last_name;
   });      
         
               ?>

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
   <?php 
  
   if(!empty($asset))
        $model->asset=$asset;
    
 if(!empty($model->asset))
   echo  $form->field($model, 'asset')->hiddenInput(['value'=>$model->asset])->label(false);  
   ?>
   

   <?= $form->field($model,  'asset')->dropDownList([ArrayHelper::map(Assets::find()->all(), 'id',function($model){
       return $model->name."-".$model->serialNo ;
   })], ['prompt'=>'Select Asset',
               'id'=>'emp-id','class'=>['form-control m-select2 '],'disabled'=>!empty($model->asset)])->label("Asset") ?>  
 
   <?=$form->field($model, 'allocation_type')
                        ->radioList(
                            ["E"=>"Employee","OU"=>"Department/Unit"],
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
                    ->label("Allocate Type");
                    ?>              
        <div class="row">
        
     
        
          <div class="col-sm-12 col-md-4 col-lg-4">
                          
     <?= $form->field($model,  'employee')->dropDownList($employeeList, ['prompt'=>'Select  Assigned Employee',
               'id'=>'employee-id','class'=>['form-control m-select2 ']])->label("Allocate Employee") ?> 
          </div>
           <div class="col-sm-12 col-md-4 col-lg-4">
           <?= $form->field($model,  'org_unit')->dropDownList($orgUnitList, ['prompt'=>'Select  Assigned Org Unit',
               'id'=>'org-unit-id','class'=>['form-control m-select2 ']])->label("Allocate Department/Unit") ?> 
          </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($model, 'allocation_date')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Assignment  Date','id'=>'ass-date'])
                                          ->label("Allocate Date") ?> 
          </div>
          </div>
                

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php

$script = <<< JS

 $(document).ready(function(){


			$('.date').bootstrapMaterialDatePicker
			({
			    //format: 'DD/MM/YYYY',
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
     
 
});

JS;
$this->registerJs($script);


$script2 = <<< JS


//------check value validation
function isEmpOptionChecked (attribute, value) {

return $('input[name="AssetAllocations[allocation_type]"]:checked').val()=='E'

	};

//------check value validation
function isOUOptionChecked (attribute, value) {

return $('input[name="AssetAllocations[allocation_type]"]:checked').val()=='OU'
	};
  
JS;
$this->registerJs($script2,$this::POS_HEAD);
?>






