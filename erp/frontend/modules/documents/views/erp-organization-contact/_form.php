<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationContact */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>


<?php endif; ?>

<div class="erp-organization-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

   <div  class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        
    
      <?= Html::a($model->isNewRecord ? '<i class="material-icons">save</i> <span>Save And Next</span>' : 
           '<i class="material-icons">mode_edit</i> <span>Update And Next</span>', '', ['class' => $model->isNewRecord ? 'btn bg-olive btn-sm margin' : 'btn bg-green btn-sm margin',
        'data' => [
            'method' => 'post',
            'params' => [
                'mode' =>$model->isNewRecord ?'create':'update'
            ]
        ]
    ])?> 
    
     
    <?= Html::button('<i class="fa fa-check-square-o"></i> <span>Skip To Next</span><i class="material-icons">navigate_next</i>
       
',['value'=>'', 'class'=>'btn bg-maroon btn-sm margin next-step', 
'id' => 'stepwizard_step1_next','title'=>'Proceed to Address']); ?> 
    
    </div>
   
    
       
         
     </div>

    <?php ActiveForm::end(); ?>

</div>
