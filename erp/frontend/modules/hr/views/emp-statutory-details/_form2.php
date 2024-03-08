<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpTerminations */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
  div.med-scheme label{  display: inline-block; margin-right: 30px;} 


 
</style>

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-balance-scale"></i> Employee Statutory Details</h3>
                       </div>
               
           <div class="card-body">
               
      <?php
      
       if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
      ?>



    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
      'class' => 'form-horizontal', 'id'=>'emp-statu-form', 
                                 'enableClientValidation'=>true,
                                 'enableAjaxValidation' => false,
                                 'method' => 'post',  ]); ?>
    
    
     <?=$form->field($model, 'med_scheme')
                        ->radioList(
                           ['RAMA'=>'RAMA','MMI'=>'MMI'],
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary med-scheme d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '" class="med-scheme"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label('Contributing') ?>
    
     <?= $form->field($model, 'rama_no')
             ->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'RAMA No...'])->label('RAMA No.') ?>

   

   

    <?= $form->field($model, 'mmi_no')
             ->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'MMI No...'])->label('MMI No.') ?>

                    
                    
    <?php /*$form->field($model, 'pension_no')
             ->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'PENSION No...'])->label('PENSION No.') */?>

<?php

$content=Html::activeDropDownList($model, 'med_scheme', ['RAMA'=>'RAMA','MMI'=>'MMI']);
?>
             
<?= $form->field($model, 'pension_no', ['template' => '
                       
                            <div class="input-group  col-sm-12">
                             <div class="input-group-prepend">
                               
                                <div class="input-group-text fix-label-item">'.
                                $content.'
                                   </div>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{hint}{error}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'pension...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>


<?php
$script = <<< JS
$(document).ready(function(){
    
    $(".select2").select2({width:'100%',theme: 'bootstrap4'});
   
    
});

JS;
$this->registerJs($script);


$script2 = <<< JS

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
