<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgUnits;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPatternUnit */
/* @var $form yii\widgets\ActiveForm */


$units=ArrayHelper::map(ErpOrgUnits::find()->all(), 'unit_code', 'unit_name') ;
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i>New Unit</h3>
                       </div>
               
           <div class="card-body">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'unit_code')->dropDownList($units, 
	         ['prompt'=>'-Choose Unit','class'=>['form-control select2'] ,
			  'onchange'=>'
			'])->label('Select Unit for the template'); ?> 
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
    
    $(".select2").select2({width:'100%'});
 });
 
JS;
$this->registerJs($script);
?>
