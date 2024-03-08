<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use frontend\modules\auction\models\Lots;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\LotsItems */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 

if($model->item_image!==null){
     $imageUrl=Yii::$app->request->baseUrl . '/' .$model->item_image;
     $previewUrl[]=Html::img($imageUrl,['class'=>' kv-preview-data file-preview-image', 
                                          'width'=>'auto','height'=>'auto','max-width'=>'100%','max-height'=>'100%','alt'=>' Missing', 'title'=>'missing']);
                                          
                                          
 

                        } else{
                          $previewUrl=[];   
                            
                        }
                       
                        ?>
                        
                        <div class="row clearfix">

             <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 offset-md-1 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title">Add New Lot</h3>
                       </div>
               
           <div class="card-body">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>
       <?php $lots=ArrayHelper::map(Lots::find()->all(), 'id', 'description'); 
                  
             ?>
 <?= $form->field($model, 'lot')
        ->dropDownList(
            $lots,         
            ['prompt'=>'Select lot name ...','class'=>['form-control m-select2']]    // options
        )->label("Lot Name")?>
   

     <?= $form->field($model, 'item_images[]')->widget(FileInput::classname(), [
                                           
                                          'options' => ['accept' => 'image/*','multiple' => true],
                                           'pluginOptions'=>['allowedFileExtensions'=>['jpg','png'],
                                         
                                           'theme'=>'fas',
                                           'showCaption' => false,
                                            'showCancel' => false,
                                           'showRemove' => true,
                                           'showUpload' => false,
                                           'browseClass' => 'btn btn-success btn-block',
                                           'browseIcon' => '<i class="fas fa-camera"></i> ',
                                           'browseLabel' =>  'Select Image(s)',
                                           
                                           'initialPreview'=>$previewUrl,
                                          'overwriteInitial'=>true
                                          
                                         
                                        
                                        
                                        
                                        ]
                                              ])?>

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

 $(function () {
  
  
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
   
          $('.datetime').bootstrapMaterialDatePicker(
              { format : 'YYYY-MM-DD  HH:mm' 
                  
              });
              
                //--------------------------------------------------init select2-------------------------------------------------       
          
           $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
        
 });
     
   	    

   

JS;
$this->registerJs($script);

?>
