

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;


use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Person Interim';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>


</style>



<div class="well row clearfix">

    <div class="<?php if($isAjax){echo 'col-xs-12 col-sm-12 col-md-12 col-lg-12 ';}else{echo 'col-xs-12 ol-sm-12 col-md-8 col-lg-8 offset-md-2';}  ?>">
        
          
    <div class="card card-default color-palette-card">
        
        <div class="card-header with-border">
          <h3 class="card-title"><i class="fa fa-tag"></i>Add Person In Interim</h3>
        </div>
               
           <div class="card-body">
  <?php
             if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
                }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
            }
  ?>
         
         
         
<?php
    $form = ActiveForm::begin([
        'id'=>'pinterim-form', 
      
    
       'method' => 'post'
       ]);

?>


            
                    <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select position ...','id'=>'recipients-select'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?>                
                    
                    <?= $form->field($model, 'person_in_interim')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?> 

          <div class="form-group">
             

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <?= $form->field($model, 'date_from')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'interim from...']]) ?>
                  
                </div>
                <!-- /.input group -->
              </div>

 <div class="form-group">
             

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <?= $form->field($model, 'date_to')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'interim to...']]) ?>
                  
                </div>
                <!-- /.input group -->
              </div>
<div class="form-group">
    
 <?= Html::submitButton($model->isNewRecord ?'<i class="fa   fa-plus-circle "></i> Add':'<i class="fa   fa-edit "></i> Update', ['class' =>$model->isNewRecord? 'btn btn-primary ':'btn btn-success']) ?>   
</div>
   

<?php ActiveForm::end(); ?>
  


                </div> <!--card body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>

 <!--modal -->           
 <div class="modal modal-info" id="modal-action">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
              <div  id="modalContent"> <div style="text-align:center"><img src="<?=Yii::$app->request->baseUrl?>/img/m-loader.gif"></div></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  

$script = <<< JS

$(document).ready(function()
		{
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

	});

$('#recipients-select').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#recipients-names').empty();
    $.each(array, function(i,e){
    $("#recipients-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#recipients-names').trigger('change.select2');
    });
});

$('#recipients-select').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#recipients-names').val([]);
    $.each(array, function(i,e){
    $("#recipients-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#recipients-names').trigger('change.select2');

});

}else{ $('#recipients-names').val([]);$('#recipients-names').trigger('change.select2');}

});

//------------------------------------update doc link-------------------------------------------



JS;
$this->registerJs($script);

?>

