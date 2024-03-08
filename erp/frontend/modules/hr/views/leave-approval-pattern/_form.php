<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPattern */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i>New Approval Template</h3>
                       </div>
               
           <div class="card-body">
      
      <?php
          if($model->hasErrors()){
              
               $msgbox=Html::tag('div',Html::button('x',
    ['class'=>'close',' data-dismiss'=>'alert','aria-hidden'=>true]).
    Html::tag('h5','<i class="icon fas fa-ban"></i> Alert!',[]).
    Html::errorSummary($model),
    ['class'=>'alert alert-danger alert-dismissible']);
  
    echo $msgbox;
          }
          
        
          
      
      ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>