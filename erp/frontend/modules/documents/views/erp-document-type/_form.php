<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgLevels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="well row clearfix">

<div class="col-xs-12 ol-sm-12 col-md-8 col-lg-8  offset-md-2">

 <div class="card card-default ">
                <div class="card-header ">
                  <h3 class="card-title"><i class="fa fa-tag"></i> Add New Document Type</h3>
                </div>
           <div class="card-body">
  
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

 <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
  


                </div> <!--card body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>

             </div><!-- end row wraper  -->
          
          </div>
