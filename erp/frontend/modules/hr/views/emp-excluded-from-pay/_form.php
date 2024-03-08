<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\Employees;


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpTerminations */
/* @var $form yii\widgets\ActiveForm */
?>



                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-user-lock"></i> Hold Employee Salary</h3>
                       </div>
               
           <div class="card-body">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model,  'employee')->dropDownList([ArrayHelper::map(Employees::find()->active()->all(), 'id', function($model){
       
       return $model->first_name.' '.$model->last_name;
   })], ['prompt'=>'Select employee',
               'id'=>'emp-id','class'=>['form-control m-select2 ']])->label("Employee") ?>  

   <?= $form->field($model, 'reason')->textArea(['rows' => '6']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php

$script = <<< JS

 $(document).ready(function(){


			$('.date').bootstrapMaterialDatePicker
			({
			    format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
 
     
});

JS;
$this->registerJs($script);

?>


