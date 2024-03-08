
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use common\models\Countries;
use kartik\file\FileInput;
use frontend\modules\hr\models\EmpPhoto;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
 
    .input-group > .select2-container--bootstrap4 {
    width: auto important!;
    flex: 1 1 auto important!;
}

.input-group > .select2-container--bootstrap4 .select2-selection--single {
    height: 100% important!;
    line-height: inherit important!;
    padding: 0.5rem 1rem important!;
}

.field-heading {
    border-bottom: 1px solid rgb(161, 161, 161);
    margin-bottom: 31px;
    font-size: 1.3em;
}


 .required .input-group:after {
    color: #e32;
    content: ' *';
    display:inline;
}


    
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
               
           <div class="card-body">
      
      <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>          
               
  
    
    <?php $form = ActiveForm::begin([
                                 'options' => ['enctype' => 'multipart/form-data'],
                                 'id'=>'dynamic-form', 
                                 'enableClientValidation'=>true,
                                 'enableAjaxValidation' => false,
                                 'method' => 'post',
                              
                               ]); ?>
    
      <h3 class="field-heading"><i class="fas fa-user-edit"></i> Basic Information</h3>
      
      <div class="row">
                  
                  <div class="col-sm-12 col-md-4 col-lg-4">
                      
                      <?= $form->field($model, 'first_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'firstname']) ?>
                      
                    

   
                  </div> 
                   <div class="col-sm-12 col-md-4 col-lg-4">
                      
       <?= $form->field($model, 'middle_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'middlename']) ?>           

   

    
                  </div> 
                  
                   <div class="col-sm-12 col-md-4 col-lg-4">
      
      <?= $form->field($model, 'last_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'lastname']) ?>       

   
                  </div>
                    
                </div>
                
                 <div class="row">
        
          <div class="col-sm-12 col-md-4 col-lg-4">
              
              <?= $form->field($model, 'birthday', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control date'],'placeholder'=>'date of birth...'])->label(false)?> 
            
              
                

   
          </div>
          
           <div class="col-sm-12 col-md-4 col-lg-4">
              
                
         <?= $form->field($model, 'gender',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   <i class="fas fa-venus-mars"></i>
                                </span>
                               
                                </div>
                        {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', 'Divers' => 'Divers', ], ['prompt'=>'Select  gender',
               'id'=>'g_id','class'=>['form-control  m-select2  gender ']]) ?>     

   

    
          </div>
           <div class="col-sm-12 col-md-4 col-lg-4">
           
            <?= $form->field($model, 'marital_status',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                <i class="fas fa-ring"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ 'Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed', 'Other' => 'Other', ], 
               ['prompt'=>'Select  marital status',
               'id'=>'ms_id','class'=>['form-control  m-select2 ms ']]) ?>     
                
 
          </div>
    </div>

  

   <div class="row">
       
        <div class="col-sm-12 col-md-4 col-lg-4">
            
           
        
         <?= $form->field($model, 'nationality',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-globe-africa"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList([ArrayHelper::map(Countries::find()->all(), 'country_code', 'country_name')], ['prompt'=>'Select  nationality',
               'id'=>'nat-id','class'=>['form-control m-select2 nat-class ']]) ?>   
               
          
        </div>
        
         <div class="col-sm-12 col-md-4 col-lg-4">
           
             <?= $form->field($model, 'nic_num', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                <i class="far fa-id-card"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'National Identity Card (NID)']) ?> 
           
        </div>
        
         <div class="col-sm-12 col-md-6 col-lg-4">
             <?= $form->field($model, 'other_id', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   <i class="far fa-id-card"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Other ID (Passport,...)']) ?> 
            
           </div>
        
        
       
   </div>
  
  <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6">
          
     <?php
     $photo=$model->photo;
     $uploadUrl='uploads/photo'.$photo->dir.'/'.$photo->id.$photo->file_type;
     
      $imgSrc=='';

 
  if($photo!=null && file_exists($uploadUrl)){
      
 $imgSrc=Yii::getAlias('@web').'/'.$uploadUrl;   
    
}else{
                                         
    $imgSrc=Yii::getAlias('@web').'/img/avatar-user.png';    
   
    } 
     ?>
        
        
          
                                       <?= $form->field($modelPhoto, 'upload_file')->widget(FileInput::classname(), [
                                           
                                           
                                           'pluginOptions'=>['allowedFileExtensions'=>['jpg','png'],
                                           'theme'=>'fas',
                                           'showCaption' => false,
                                           'showRemove' =>false,
                                            'showCancel' =>false,
                                           'showUpload' => false,
                                           'browseClass' => 'btn btn-primary btn-upload btn-block',
                                           'browseIcon' => '<i class="fas fa-camera"></i> ',
                                           'browseLabel' =>  'Select Photo',
                                           
                                           'initialPreview'=>[ Html::img($imgSrc,['class'=>' kv-preview-data file-preview-image', 
                                          'width'=>'auto','height'=>'auto','max-width'=>'100%','max-height'=>'100%','alt'=>' Missing', 'title'=>'missing'])],
                                          'overwriteInitial'=>true
                                          
                                         
                                        
                                        
                                        
                                        ],'options' => ['accept' => 'image/*']
                                              ])?>

      </div>
      
  </div>
   

   <?php if(!$model->isNewRecord) : ?>             
  <div class="form-group text-right">
        <?= Html::submitButton('Update', ['class' => 'btn  btn-outline-success']) ?>
    </div>
    
    <?php endif;?>
    

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
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
     $(".m-select2").select2({theme: 'bootstrap4'});
     
    
     
});

JS;
$this->registerJs($script);

?>



