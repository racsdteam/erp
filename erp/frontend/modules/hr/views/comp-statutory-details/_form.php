<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\TermReasons;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpTerminations */
/* @var $form yii\widgets\ActiveForm */
?>



                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-balance-scale"></i> Company Statutory Details</h3>
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



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rama_pay')->textInput() ?>

    <?= $form->field($model, 'rama_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pension_pay')->textInput() ?>

    <?= $form->field($model, 'pension_no')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
