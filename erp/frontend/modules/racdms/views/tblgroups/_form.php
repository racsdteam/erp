<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use common\models\User;
use common\models\UserHelper;
use common\models\Tblgroups;
$this->context->layout='admin'
?>

<style>
    
  div.unit-input{display:none;}  
    
</style>


<div class="card card-default">
           
              
              <div class="card-body"> 
              
        <?php
              
                  // helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use($hideCssClass) {
    $class = "alert alert-{$type} alert-dismissible";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
    }
return Html::tag('div', Html::button('&times;',['class'=>'close','data-dismiss'=>'alert','aria-hidden'=>true]). '<div>' . $body . '</div>', ['class' => $class]);  
 
};
                  ?>
                  
                  
                   <div class="kv-treeview-alerts">
        <?php
        
        $session = Yii::$app->has('session') ? Yii::$app->session : null;
       
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        }
       
        ?>
    </div>
           
       
       
            
              
      <?php $items=[Tblgroups::UNIT_GROUP=>'Organizational Unit',Tblgroups::CUSTOM_GROUP=>'Custom',Tblgroups::PUBLIC_GROUP=>'Public']?>
      
      <div class="form-group field-tblgroups-name required validating">
     
      <label for="groupType">Group Type</label>
     
      <?= Html::dropDownList('group_type',null,$items, ['prompt'=>'Select Group Type ...','class'=>['form-control m-select2 type'],'id'=>'groupType'] ) ?>         
      
      </div>
    
  
    
   
                    
       
     <div class="unit-input" id="form1">
         
    <?php $form = ActiveForm::begin(); ?>
         
      <?php $items=ArrayHelper::map(ErpOrgUnits::find()->all(), 'unit_code',function($unit){
      
       $level=ErpOrgLevels::find()->where(['id'=>$unit->unit_level])->one();
       
       if(!$level)
       
       return $unit->unit_name;
       
       return $unit->unit_name." ".$level->level_name; 
      
      }); ?>
      
     <?=Html::hiddenInput('type', 1); ?>
     
    <div class="form-group field-tblgroups-name required validating">
     
      <label for="groupLevel">Organizational Unit(s)</label>
      
    <?php  echo Select2::widget([
    'name' => 'units[]',
    'value' => '',
    'data' => $items,
    'options' => ['multiple' => true, 'placeholder' => 'Select unit(s) group ...']
]);

?>  
     </div>
     
     
      <?= $form->field($model, 'comment')->textarea(['rows' => 6,'placeholder'=>'comment...']) ?>
                   
        
        <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
        
    
     <?php ActiveForm::end(); ?>
         
     </div>  
        
        <div class="unit-input" id="form2">
        
            <?php $form = ActiveForm::begin(); ?>
           
            <?= Html::hiddenInput('type', 2); ?>
           
            
           <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Group Name...']])->label("Group Name") ?> 
         
         
        <?php $items=ArrayHelper::map(User::find()->all(), 'user_id',function($user){
      
         $pos=UserHelper::getPositionInfo($user->user_id);
         
         if(!$pos)
          return $user->first_name." ".$user->last_name; 
         
          return $user->first_name." ".$user->last_name." / ".$pos['position']; 
      
      }); ?>
                   <?= $form->field($model, 'group_members[]')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select User(s) ...','id'=>'user-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Group members')?> 

 <?= $form->field($model, 'comment')->textarea(['rows' => 6,'placeholder'=>'comment...']) ?>

<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

  <?php ActiveForm::end(); ?>
         
     </div> 
        
       <div class="unit-input" id="form3">
        
            <?php $form = ActiveForm::begin(); ?>
           
            <?= Html::hiddenInput('type', 3); ?>
           
            
           <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Group Name...']])->label("Group Name") ?> 
         
         
       

 <?= $form->field($model, 'comment')->textarea(['rows' => 6,'placeholder'=>'comment...']) ?>

<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

  <?php ActiveForm::end(); ?>
         
     </div> 
    
</div>
</div>





<?php


$script = <<< JS



 $(function () {
   
    $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
   
 });
 
$('.type').on('change', function() {
        var value = $(this).val(); 
        $("div.unit-input").hide();
        $("#form"+value).show();
        
});

JS;
$this->registerJs($script);

?>