<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\ReportTypes;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Locations */
/* @var $form yii\widgets\ActiveForm */
?>


                 <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Add Report Template</h3>
                       </div>
               
           <div class="card-body">
               
                <?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));    
}

$views=[];
$params=[]; 
 $procedureList=ArrayHelper::map(Yii::$app->db4->createCommand("SHOW PROCEDURE STATUS")->queryAll(), 'Name',function($sp){
  return $sp['Name'];
});
/*$viewFiles=\yii\helpers\FileHelper::findFiles(Yii::getAlias('@report_views_dir'));*/


 
/*foreach($viewFiles as $key=>$file){
    $pathInfo=pathinfo($file);
    $viewPath='/'.basename($pathInfo['dirname']).'/'.$pathInfo['filename'];
    $views[$viewPath]=$pathInfo['filename']; 
 
}*/
$paramsList = (new \yii\db\Query())
    ->select(['PARAMETER_NAME'])
    ->from('information_schema.parameters')
     ->where(['in', 'SPECIFIC_NAME', array_values($procedureList)])
     ->distinct()->all();
  
foreach($paramsList as $key=>$arr){
    
 $params[$arr['PARAMETER_NAME']]=$arr['PARAMETER_NAME'];  
}

   ?>
               
                <?php $form = ActiveForm::begin([
                                'id'=>'report-form', 
                                'enableClientValidation'=>true,
                                'enableAjaxValidation' => false,
                                'method' => 'post',
                              
                               ]); ?>
               
         
     <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>   
         <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>   
 
    <?= $form->field($model, 'description')->textArea(['rows' =>3]) ?>
     
    <?= $form->field($model,  'type')->dropDownList([ArrayHelper::map(ReportTypes::find()->all(), 'id', 'name')], ['prompt'=>'Select Report Type',
               'id'=>'report-type-id','class'=>['form-control select2 ']])->label("Report Type") ?>
   <div class="row">
       
         <div class="col-sm-6">
             
 <?= $form->field($model,  'dataset')->dropDownList($procedureList, ['prompt'=>'Select DataSet',
               'id'=>'dataset-type-id','class'=>['form-control select2 ']])->label("DateSet") ?>             
         </div>
         
    
       
       
       <div class="col-sm-6">
           
           <?= $form->field($model,  'mparams')->dropDownList($params, ['prompt'=>'Select Parameters',
               'id'=>'params-type-id','class'=>['form-control select2 '],'multiple'=>true])->label("Parameters") ?> 
       </div>
       
   </div>            
   
               
                
               
        
  <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>

</div>


<?php

$script = <<< JS


$(document).ready(function(){

	
     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".select2").select2({width:'100%',theme: 'bootstrap4'});
    
   
});

 


JS;
$this->registerJs($script);


?>