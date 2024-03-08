<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\racdms\models\Tblorgs;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgpositions */
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

   <?php $items=ArrayHelper::map(Tblorgs::find()->all(), 'id','name'); ?>
  
    <h4 class="card-header mb-3">Add a new Position</h4>


<div class="tblorgpositions-form tblorgs-form col-sm-10 mx-auto">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'org')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Organisation ...','id'=>'org-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label('Organisation')?> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

</div>

