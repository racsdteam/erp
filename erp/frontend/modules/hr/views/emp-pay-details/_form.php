<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\ EmpTypes;
use frontend\modules\hr\models\ EmploymentType;
use frontend\modules\hr\models\ EmploymentStatus;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\ PayLevels;
use frontend\modules\hr\models\Payfrequency;
use frontend\modules\hr\models\Locations;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\PayTypes;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    
 div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}    
    
</style>
   <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Emplyee Pay Details</h3>
                       </div>
               
           <div class="card-body">
               
            <?php
             
             $payLevels=ArrayHelper::map(PayLevels::find()->all(), 'id',function($model){
                        
                        return 'Level-'.$model->number." : ".$model->description;
                        
                    }) ;
                    
            $payTypes=ArrayHelper::map(PayTypes::find()->all(), 'code','name') ;
            
                                   
                           
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
    
   
   
   $default_pos_data=array();
   if (!$model->isNewRecord) {
       
         $default_pos_data[$model->position]=$model->position;
             }
   

}

            ?>

    <?php $form = ActiveForm::begin(); ?>
 <div  id="employee" class="row">
      
   <div class="col-sm-12 col-md-6 col-lg-6">
       
       <?= $form->field($model, 'org_unit')->dropDownList( $options, ['prompt'=>'Select  org Unit',
               'id'=>'unit-id','class'=>['form-control m-select unit ']])->label('Department /Unit/Office') ?> 
       
   </div> 
   
   <div class="col-sm-12 col-md-6 col-lg-6">
      
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
                          
                          <div class="col-sm-12">
                           
                                  <?=
                    $form->field($model, 'pay_basis')
                        ->radioList(
                            $payTypes,
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
                        )->label("Pay Basis")
                    ;
                    ?>
                          </div>  
                            
                        </div>

                        
                      <div class="row ">
                        
                         <div class="col-sm-12 col-md-4 col-lg-4">
                             
                          <?= $form->field($model, 'pay_level' ,['options' => ['class' => 'form-group flex-grow-1']])
     ->dropDownList($payLevels, ['prompt'=>'Select  pay grade',
               'id'=>'pay-grade','class'=>['form-control m-select2 pay-grade  '],'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-levels/basic-sal?id=').'"+$(this).val(), function( data ) {
				  $( "#base-pay" ).val(data.bs);
				});
			'])->label("Pay Level") ?>  
                  
                             
                         </div>
                        
                         <div class="col-sm-12 col-md-4 col-lg-4">
                             
                            <?= $form->field($model, 'base_pay')->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Amount...','id'=>'base-pay','class'=>['form-control  input-format']])->label("Basic Pay / Monthly Allowance") ?>     
                             
                         </div>
                         
                          <div class="col-sm-12 col-md-4 col-lg-4">
        
        <?= $form->field($model, 'pay_group' )
     ->dropDownList([ArrayHelper::map(PayGroups::find()->all(), 'code', 'name')], ['prompt'=>'Select  pay group',
               'id'=>'pay-group','class'=>['form-control m-select2 pay-group '],'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-groups/pay-template?code=').'"+$(this).val(), function( data ) {
				  $( "#pay-tmpl" ).val(data.code).change();
				});
			']) ?>  
        
</div>
             
                       
                    </div>
              
    <?= $form->field($modelOptions, 'create')->checkbox(['id'=>'checkCreate'])
			->label('Create New Record'); ?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => $model->isNewRecord?'btn btn-sucess':'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>


<?php
$sal_level_wise_url=Url::to(['pay-levels/basic-sal']);
$script = <<< JS
$(document).ready(function(){
    
   //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
     $('.input-format').number( true);
      
    $("#pay-grade").on('change.yii',function(){
    var pay_grade=$(this).val();
    if(pay_grade!==''){
        
        $.ajax({
           url: "$sal_level_wise_url",
           data: {grade: pay_grade},
           success: function(data) {
             var res= JSON.parse(data);
            
              if(res.flag==='success'){
                
                  $('#base-pay').val(res.bs);
                  //$('#base-pay').prop('readonly', true);
              }
           }
        });  
    }
    
   
   
 
});
    
});

JS;
$this->registerJs($script);

?>
