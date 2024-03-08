<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\PayItemCategories;
use yii\helpers\ArrayHelper;
use softark\duallistbox\DualListbox;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Locations */
/* @var $form yii\widgets\ActiveForm */
?>
 
 
 <?php
  
    $itemsList=ArrayHelper::map(PayItems::find()->all(),'id', function($c){
                            return $c->edDesc; 
                             
                         });                    
  
               ?>
<style>

</style>

                 <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-layer-group"></i>Select Pay Items in Pay Structure</h3>
                       </div>
               
           <div class="card-body">
               
              

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>

  

<?php
    $options = [
        'multiple' => true,
        'size' => 20,
    ];
    // echo Html::activeListBox($model, $attribute, $items, $options);
    echo DualListbox::widget([
        'model' => $model,
        'attribute' =>'selection',
        'items' => $itemsList,
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord?'btn btn-primary':'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

</div>
<?php

$script = <<< JS

$(document).ready(function(){


            

   	    
			$('.date').bootstrapMaterialDatePicker
			({
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