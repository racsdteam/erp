<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\StatutoryDeductions;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompStatutorySettings */
/* @var $form yii\widgets\ActiveForm */
?>


                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Statutory Deduction Type</h3>
                       </div>
               
           <div class="card-body">
                <?php 
                
                if (Yii::$app->session->hasFlash('error')){
                    
                Yii::$app->alert->showError(Yii::$app->session->getFlash('error')) ;  
                    
                    
                }
                
                
                ?>
 

 
 

    <?php $form = ActiveForm::begin(); ?>
    
     <?= $form->field($model, 'abbr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
   
          
               
               
    </div>

    

     



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

