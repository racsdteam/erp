<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Countries;
use common\models\Province;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
.select2{

    width:100%;
}


</style>

<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>


<?php endif; ?>

<div class="erp-organization-address-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if ($model->hasErrors()): ?> 
                               
                               <div style="margin-top:-50px;" class="alert alert-danger alert-dismissable">
                                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                       <h4><i class="icon fa fa-check"></i>Error!</h4>
                                      <?php echo  Html::errorSummary($model); ?>  
                                 </div>
                                       
                     
                      <?php endif?>
    
    
    <?= $form->field($model, 'country_code')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(Countries::find()->all(), 'country_code', 'country_name') ],
    'options' => ['placeholder' => 'Select country ...'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],//'addon'=>$addon,
    'size' => Select2::MEDIUM,
    'pluginEvents' => [
        "change" => 'function() { 
            var country_code = $(this).val();
            populateProvince(country_code);
        }',
    ],
  
   
])->label(false)?>

    

    
    <?= $form->field($model, 'province')->widget(Select2::classname(), [
   'data' => [ ArrayHelper::map(Province::find()->all(), 'idProvince', 'province') ],
    'options' => ['placeholder' => 'Select province ...'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],//'addon'=>$addon,
    'size' => Select2::MEDIUM,
   
  
   
])->label(false)?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>

    <div  class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        
    
      <?= Html::a($model->isNewRecord ? '<i class="material-icons">save</i> <span>Save And Next</span>' : 
           '<i class="material-icons">mode_edit</i> <span>Update And Next</span>', '', ['class' => $model->isNewRecord ? 'btn bg-olive btn-sm margin' : 'btn bg-green btn-sm margin',
        'data' => [
            'method' => 'post',
            'params' => [
                'mode' =>$model->isNewRecord ?'create':'update'
            ]
        ]
    ])?> 
    
    
     <?= Html::button('<i class="material-icons">phone</i> <span>Skip To Next</span><i class="material-icons">navigate_next</i>
       
',['value'=>'', 'class'=>'btn bg-maroon btn-sm margin next-step', 
'id' => 'stepwizard_step1_next','title'=>'Proceed to Address']); ?> 
    
    </div>
   
    
       
         
     </div>

    <?php ActiveForm::end(); ?>

</div>

 <?php
$provinceURL=Url::to(['province/populate-province']);
$script = <<< JS
 $(function () {
    //Initialize Select2 Elements
    //$(".select2").select2();

 });

    function populateProvince(country_code) {
               //alert(country_code);
               var select = $('#erporganizationaddress-province');
                select.find('option').remove().end();
               
                $.ajax({
     
       url:'{$provinceURL}'+'?code='+country_code,
        type: 'GET',
        //data: formData,

        // Form data
      //  data:jQuery.param({ id: $('#searchcaseinvolvedparty-globalsearch').val()}),
      //  data:{ id :$('#searchcaseinvolvedparty-globalsearch').val()},

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(data) {
        console.log(data);  
       
        select.html(data);
        /*if(data != '')
        {
            // Loop through each of the results and append the option to the dropdown
            $.each(data, function(k, v) {
                select.html('<option value="' + v.id + '">' + v.name + '</option>');
            });
        }*/
      
        
        },

        error: function(){
           
            alert('ERROR at PHP side!!');
           
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });


            }


JS;
$this->registerJs($script);
?>