<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpSubdivisionPositions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-subdivision-positions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subdiv_id')->textInput() ?>

    <?= $form->field($model, 'position_id')->textInput() ?>

    <?= $form->field($model, 'position_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgLevels;
use common\models\ErpOrgSubdivisions;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgLevels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="well row clearfix">

<div class="col-xs-12 ol-sm-12 col-md-8 col-lg-8  col-md-offset-2">

 <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-tag"></i> Add New Organization Subdivision</h3>
                </div>
           <div class="box-body">
  
           <?php if (Yii::$app->session->hasFlash('success')): ?>
  
           <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('failure')  ?>
               </div>
 
 
         <?php endif; ?>  


  
 
  <?php $form = ActiveForm::begin(); ?>



 <?= $form->field($model, 'subdiv_id')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgSubdivisions::find()->all(), 'id', 'subdiv_name') ],
    'options' => ['placeholder' => 'Select subdivision ...'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],//'addon'=>$addon,
    'size' => Select2::MEDIUM,
  
   
])->label(false)?>


<?= $form->field($model, 'subdiv_name')->textInput(['maxlength' => true]) ?>



<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>

             </div><!-- end row wraper  -->
          
          </div>


