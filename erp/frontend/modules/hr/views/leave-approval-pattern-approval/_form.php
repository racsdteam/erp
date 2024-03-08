<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPatternApproval */
/* @var $form yii\widgets\ActiveForm */

$approval_list=["MD"=>"MD","DMD"=>"DMD","DHR"=>"DHR","unit-director"=>"Unit-Director","unit-manager"=>"Unit-Manager",
"unit-coordinator"=>"Unit-Coordinator","unit-supervisor"=>"Unit-Supervisor","unit-principal"=>"Unit-Principal",];
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i>New Unit</h3>
                       </div>
               
           <div class="card-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'appover')->dropDownList($approval_list,
	         ['prompt'=>'-Choose Level','class'=>['form-control select2'] ,
			  'onchange'=>'
			'])->label('Select Approve'); ?> 
   <?= $form->field($model, 'approval_action')->dropDownList([ 'approval' => 'Approval', 'review' => 'Review',],
	         ['prompt'=>'-Choose Action','class'=>['form-control select2'] ,
			  'onchange'=>'
			'])->label('Select Approval Level'); ?> 
    <?= $form->field($model, 'approval_level')->dropDownList([ 'initial' => 'Initial', 'middle' => 'Middle', 'final' => 'Final', ],
	         ['prompt'=>'-Choose Level','class'=>['form-control select2'] ,
			  'onchange'=>'
			'])->label('Select Approval Level'); ?> 

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