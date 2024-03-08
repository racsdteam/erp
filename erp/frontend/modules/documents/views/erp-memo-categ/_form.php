<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use common\models\ErpMemoCateg;
use common\models\ErpDocumentType;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model common\models\ErpMemo */
/* @var $form yii\widgets\ActiveForm */
?>


<div class=" row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-10 col-md-10 col-sm-12 col-xs-12 offset-md-1';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?>">

 <div class="card card-default ">
                <div class="card-header ">
                  <h3 class="card-title"><i class="fa fa-plus-circle"></i> Add New Category</h3>
                </div>
           <div class="card-body">
  
           <?php if (Yii::$app->session->hasFlash('success')): ?>
  
           <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

<?php endif; ?>

<?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>


  
  <?php $form = ActiveForm::begin(['id'=>'memo-form']); ?>

      
    <?= $form->field($model, 'categ')->textInput()->label("Category Name") ?>
    <?= $form->field($model, 'categ_code')->textInput()->label("Category Code") ?>

  
     
   
      
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '<i class="material-icons">save</i> <span>save</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   
</div>

<?php ActiveForm::end(); ?>
  


                </div> <!--card body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>

             </div><!-- end row wraper  -->
          
          </div>
          
          <?php
          $script = <<< JS
          
  

JS;
$this->registerJs($script);
?>



