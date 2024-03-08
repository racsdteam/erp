
<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\assets0\models\Assets;
use frontend\modules\assets0\models\AssetSecCategories;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetDispositions */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}    
</style>


    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
   <?php 
  
   if(!empty($asset)){
     $model->asset=$asset;   
     echo  $form->field($model, 'asset')->hiddenInput(['value'=>$model->asset])->label(false);  
   }
   ?>
   

   <?= $form->field($model,  'asset')->dropDownList([ArrayHelper::map(Assets::find()->all(), 'id',function($model){
       return $model->name."-".$model->serialNo ;
   })], ['prompt'=>'Select Asset',
               'id'=>'emp-id','class'=>['form-control m-select2 '],'disabled'=>!empty($model->asset)])->label("Asset") ?>  
 
   <?=$form->field($model, 'category')
                        ->radioList(
                          ArrayHelper::map(AssetSecCategories::find()->all(), 'id','name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label("Category");
                    ?>              
        <div class="row">
       
        <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($model, 'product')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Product Name','id'=>'prod-id'])
                                          ->label("Product Name") ?> 
          </div> 
     <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($model, 'product_code')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Product Code','id'=>'code-id'])
                                          ->label("Product Code") ?> 
          </div> 
    
     <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($model, 'vendor')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Product Vendor','id'=>'vendor-id'])
                                          ->label("Product Vendor") ?> 
          </div> 
          
  
          </div>
       <?= $form->field($model, 'enabled')->checkbox(array('label'=>''))
			->label('Enabled'); ?> 
			
	  <?= $form->field($model, 'up_to_date')->checkbox(array('label'=>''))
			->label('Up To Date'); ?> 		

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<?php

$script = <<< JS

 $(document).ready(function(){


			$('.date').bootstrapMaterialDatePicker
			({
			    //format: 'DD/MM/YYYY',
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
     
 
});

JS;
$this->registerJs($script);



?>







