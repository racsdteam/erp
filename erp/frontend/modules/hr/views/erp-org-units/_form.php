

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgLevels;
use common\models\ErpOrgUnits;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgLevels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Add New Organizational Unit</h3>
                       </div>
               
           <div class="card-body">
  
           <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('error')  ?>
               </div>
 
 
         <?php endif; ?>  


  
 
  <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'unit_level')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgLevels::find()->all(), 'id', 'level_name') ],
    'options' => ['placeholder' => 'Select level name ...','class'=>['select2']
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],//'addon'=>$addon,
    'size' => Select2::MEDIUM,
  
   
])?>
 <?php
                           
                           $lvs=ErpOrgLevels::find()->all();
                           $options=array();
                           
                           
                           foreach($lvs as $l){
                               $data=array();
                               $q1="SELECT * from erp_org_units as s  
                               where unit_level={$l->id} ";
                               $com1 = Yii::$app->db->createCommand($q1);
                                $rows = $com1->queryAll();
                           
                                foreach($rows as $row){
                                    
                                  
                                   $data[$row['id']]=$row['unit_name'];
                                    
                                   
                                }
                                
                               $options[strtoupper($l->level_name."s")]=$data;
                               
                              
                              
                              // $sbs=ErpOrgSubdivisions::find()->where(['subdiv_level'=>$l->id])->all();
                              
                           
                           }

                           ?>


 <?= $form->field($model, 'parent_unit')->widget(Select2::classname(), [
    'data' => $options,
    'options' => ['placeholder' => 'Select parent Unit ...','class'=>['select2']
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],//'addon'=>$addon,
    'size' => Select2::MEDIUM,
  
   
])?>


<?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'unit_code')->textInput(['maxlength' => true]) ?>



<div class="form-group">
    <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => $model->isNewRecord?'btn btn-primary':'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>

             </div><!-- end row wraper  -->
          
          </div>
<?php

$script = <<< JS

 


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

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".select2").select2({width:'100%',theme: 'bootstrap4'});
   

});

JS;
$this->registerJs($script);

?>
