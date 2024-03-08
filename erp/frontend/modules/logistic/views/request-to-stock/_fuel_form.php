<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use common\models\Items;

$this->title = 'Used fuel Registration form';

//--------------------all Items------------------------------------------------
$item=Items::find()->where(["it_name"=>"DIESEL"])->one();

?>
 <?php if (Yii::$app->session->hasFlash('error')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('error');

  echo '<script type="text/javascript">';
  echo 'Swal.fire(
  "Error!",
  "'.$msg.'",
  "error");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'Swal.fire(
  "Success!",
  "'.$msg.'",
  "success");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
        

<div class="leave-request-form">
<div class="row clearfix">

             <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
    <?php $form = ActiveForm::begin(); ?>
       <div class="card-body">
  

                 <?=  
                 $form->field($modelItem, "req_qty")->textInput(['autofocus' => true,'onchange'=>'checkStock($(this))'])
                 ?> 
              <?=  
                 $form->field($model, "driver")->textInput(['autofocus' => true,])
                 ?>
                  <?=  
                 $form->field($model, "car")->textInput(['autofocus' => true,])
                 ?>
 <div class="form-group">
             

                <div class="input-group ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                <!-- /.input group -->
              
                  <?= $form->field($model, 'date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'starting date...']]) ?>
             </div>      
    <div class="form-group">
        <?= $form->field($modelItem, 'it_id')->hiddenInput(['value'=> $item->it_id])->label(false); ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
<?php
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
    //Initialize Select2 Elements
   $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
   
 });

$(".dynamicform_wrapper2").on("beforeInsert", function(e, item) {
        $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
        
    
});			

$(".dynamicform_wrapper2").on("afterInsert", function(e, item) {
        $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
    
});	
       
        });

JS;
$this->registerJs($script2);
$url=Url::to(['check-stock/check']); 

$script_1 = <<< JS

 function checkStock(selectitem)
{



var item =document.getElementById('itemsrequest-it_id').value;
var quantity=document.getElementById('itemsrequest-req_qty').value;
if(quantity!=0)
{
     $.get('{$url}',{ item : item, quantity: quantity },function(data){
        
         data=JSON.parse(data);
          if(!data['flag'])
          {
              document.getElementById('itemsrequest-req_qty').value=0;
               Swal.fire('Error',data['message'],'error');
          }
    });
}
}
JS;
$this->registerJs($script_1,$this::POS_HEAD);

?>
