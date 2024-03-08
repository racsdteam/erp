<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\hr\models\JobClassifications;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayGradeLevels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-users-cog"></i> New Pay Level</h3>
                       </div>
               
           <div class="card-body">
               

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'number')->textInput() ?>
       
      <?= $form->field($model, 'description'
)->textarea(['rows' => 6]) ?> 

   

    <?= $form->field($model, 'basic_salary')->textInput(['maxlength' => true,'class'=>'form-control bs']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
<?php

$script = <<< JS


$(document).ready(function(){


     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
      $('.bs').number( true);
     
});

JS;
$this->registerJs($script);

?>
