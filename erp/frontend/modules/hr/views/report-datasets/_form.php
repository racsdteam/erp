<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\ReportTypes;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Locations */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
 /*--------------------------spacing radio options------------------------------------------------*/
 div.dataset-type  label{  display: inline-block; margin-right: 30px;}
</style>

                 <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Add Report DataSet</h3>
                       </div>
               
           <div class="card-body">
               
                <?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));    
}
$procedureList=ArrayHelper::map(Yii::$app->db4->createCommand("SHOW PROCEDURE STATUS")->queryAll(), 'Name', 'Name');
 
   ?>
               
                <?php $form = ActiveForm::begin([
                                'id'=>'report-form', 
                                'enableClientValidation'=>true,
                                'enableAjaxValidation' => false,
                                'method' => 'post',
                              
                               ]); ?>
                               
                                 
            
     <?=
                    $form->field($model, 'type')
                        ->radioList(
                            ['SPROC'=>'Stored Procedure','TBL'=>'Table','QY'=>'Query'],
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary dataset-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label('DataSet Type');
                    ?>
   
     <?= $form->field($model,  'dataset')->dropDownList($procedureList, ['prompt'=>'Select Stored Procedure',
               'id'=>'report-type-id','class'=>['form-control select2 ']])->label("Stored Procedure") ?>   
   
 
  

        
  <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>

</div>


<?php

$script = <<< JS


$(document).ready(function(){

	
     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".select2").select2({width:'100%',theme: 'bootstrap4'});
    
   
});

 


JS;
$this->registerJs($script);


?>