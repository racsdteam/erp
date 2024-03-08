<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card card-default">
           <div class="card-body ">
   
<?php if (Yii::$app->session->hasFlash('success')): ?>

<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

  <?php endif; ?>  

<?php if (Yii::$app->session->hasFlash('error')): ?>
 
<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
                <?php  echo Yii::$app->session->getFlash('error')  ?>
              </div>


        <?php endif; ?>  

  
    <h4 class="card-header mb-3">Add a new Organisation</h4>

   <div class="tblorgs-form col-sm-10 mx-auto">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

</div>
