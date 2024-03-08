<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use frontend\modules\auction\models\LotsCategories;
use frontend\modules\auction\models\LotsLocations;
use frontend\modules\auction\models\Auctions;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Lots */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 

if($model->image!==null){
     $imageUrl=Yii::$app->request->baseUrl . '/' .$model->image;
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
               
                <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
               
               <?php $form = ActiveForm::begin( ['options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator']]); ?>
              
               <?php 
                   $auctions=ArrayHelper::map(Auctions::find()->all(), 'id', 'name'); 
             ?>
               <?= $form->field($model, 'auction_id')
        ->dropDownList(
            $auctions,         
            ['prompt'=>'Select Auction Name ...','class'=>['form-control m-select2']]    // options
        )->label("Auction Name")?>
        
               <?= $form->field($model, 'lot')->textInput() ?>
             <?php $categories=ArrayHelper::map(LotsCategories::find()->all(), 'id', 'categ_name'); 
                   $locations=ArrayHelper::map(LotsLocations::find()->all(), 'id', 'location'); 
             ?>
                   
         <?= $form->field($model, 'location')
        ->dropDownList(
            $locations,         
            ['prompt'=>'Select lot Location ...','class'=>['form-control m-select2']]    // options
        )->label("Lot Location")?>
               <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
               <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
               <?= $form->field($model, 'reserve_price')->textInput(['maxlength' => true]) ?>
             
                   <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label("Comment / Status") ?>
                    <?= $form->field($model, 'auction_date', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control datetime'],'placeholder'=>'Auction date and time...'])->label("Auction Date")?> 
                    
                         

  

   

   

   

  

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


