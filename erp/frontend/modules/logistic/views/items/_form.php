<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Categories;
use common\models\SubCategories;

/* @var $this yii\web\View */
/* @var $model common\models\Itemlist */
/* @var $form yii\widgets\ActiveForm */

//--------------------all categories------------------------------------------------
$categories=ArrayHelper::map(Categories::find()->all(), 'id', 'name') ;


 $SubCategories=ArrayHelper::map(SubCategories::find()->all(), 'id', 'name') ;
 
 
if(!$model->isNewRecord)
{
    $code_part=explode("-",$model->it_code);
    
            $category=Categories::find()->where(["identifier"=>$code_part[0]])->one() ;  
           
       $sub_category=SubCategories::find()->where(['and',["identifier"=>$code_part[1]],["category"=>$category->id]])->one();
        $model->it_categ=$category->id;
        $model->it_sub_categ=$sub_category->id;
        
}
?>


<div class="itemlist-form">
<div class="row clearfix">

             <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
      <?= $form->field($model, 'it_categ')->dropDownList($categories, 
	         ['prompt'=>'-Choose a category-','class'=>['Select2 form-control select2'],'id'=>'2',
			  'onchange'=>'getSubCategories(this.value,this.id)',
			  ])->label('Select Employee Position'); ?>  
			  
      <?= $form->field($model, 'it_sub_categ')->dropDownList($SubCategories, 
	         ['prompt'=>'-Choose a Sub-category-','class'=>['Select2 form-control select2'],'id'=>'subcat-2' ,'multiple'=>false,])
	         ->label('Employee Name (automatically filled in)'); ?>  
	
    <?= $form->field($model, 'it_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'it_tech_specs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'it_min')->textInput() ?>

    <?= $form->field($model, 'it_unit')->textInput(['maxlength' => true]) ?>

   
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
<?php 
$url=Url::to(['sub-categories/get-sub-categories']); 
 $script1 = <<< JS
  function getSubCategories(value,id)
{
    
     $.get('{$url}',{ category : value },function(data){
        
         
          $('#subcat-'+id).html(data);
    });
   
}
JS;
$this->registerJs($script1,$this::POS_HEAD);

$script2 = <<< JS

$(document).ready(function(){


 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
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
			
			
			 $(function () {
   
    $(".Select2").select2({width:'100%'});
    
 });
			

       
        });

JS;
$this->registerJs($script2);
?>