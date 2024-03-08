<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompBusinessEntities */
/* @var $form yii\widgets\ActiveForm */
?>



                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Company Business Entities</h3>
                       </div>
               
           <div class="card-body">
               
                <?php 
           $files=[];
           foreach(\yii\helpers\FileHelper::findDirectories(Yii::getAlias('@app').'/modules/', ['recursive' => false]) as $path){
            if ( is_dir($path.'/models/')) {
                 
                 $files=array_merge($files,\yii\helpers\FileHelper::findFiles($path.'/models/',['only'=>['*.php']]));   
             }
            
           
           }
           
           $newFiles=array_merge($files,\yii\helpers\FileHelper::findFiles(Yii::getAlias('@common').'/models/',['only'=>['*.php']]));
         
          
           $names=[];
           $classes=[];
           
         /*  $mFiles1 = glob('../../common/models/'."*.php", GLOB_BRACE);
           $mFiles2=glob('../../frontend/modules/hr/models/'."*.php", GLOB_BRACE);
           $modelFiles=array_merge( $mFiles1,  $mFiles2);*/
        
           foreach ($newFiles as $f){
        //  var_dump($f);
            //--------------remove trailing slash---------------------------------
           // $f=str_replace("../../","",$f);
            $f=ltrim(substr(strstr($f, 'erp'), strlen('erp')), '/');
            //-----------------extract path info-----------------------------------
            $pathInfo=pathinfo($f);
           
            $className=$pathInfo['filename'];
            //---------------------------replace forward slash to backward-----------------------
            $classPath=str_replace('/', '\\',  $pathInfo['dirname'].'/'.$pathInfo['filename']);
            
            $names[$className]=$className;
            $classes[$className]=$classPath;
            
          
           }
     
     
   
 
    ?>

    <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model,  'name')->dropDownList($names, ['prompt'=>'Select  Entity Name',
               'id'=>'entity','class'=>['form-control m-select2 ']]) ?>  
               
    <?= $form->field($model, 'class_name')->textInput(['maxlength' => true]) ?>            

    <?= $form->field($model, 'reporting_name')->textInput(['maxlength' => true]) ?>



   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php
$encodedClasses=json_encode($classes);

$script = <<< JS

 $(document).ready(function(){
 
 var json=$encodedClasses;
 //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     
       $('#entity').on('change.yii',function(){
       
       $('#compbusinessentities-class_name').val(json[$(this).val()]);
             

});
     
});

JS;
$this->registerJs($script);

?>


