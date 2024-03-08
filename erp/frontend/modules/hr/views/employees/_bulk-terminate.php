<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Bulk Terminate / Inactivate Employees';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

</style>

 <div class="card card-default ">
               
               <div class="card-header ">
                <h3 class="card-title">
                   <i class="fas fa-user-times"></i>
                   Terminate / Inactivate Employees
                  
                </h3>
              
               
              </div>
           <div class="card-body">
  
           <?php if (Yii::$app->session->hasFlash('success')): ?>
  
           <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('error')  ?>
               </div>
 
 
         <?php endif; ?>
         
   <div style="background-color:#d7edf9;" class="callout  callout-info text-dark">
              <h5><i class="fas fa-info"></i> Note:</h5>
             ERP recommends  the below Excel file Template for Terminating / Inactivating employees. Download the sample Excel file for Reference.</br>
            
            </div> 
            
            <p>
                
              <a href="<?=Url::to(["employees/get-import-terminate-temp"]);?>" class="btn btn-sm btn-primary download-temp">
                      <i class="fas fa-download"></i> DownLoad Sample Excel File
                    </a>   
                
            </p>
            
       
     <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'upload-bulk-form', 
                                 'enableClientValidation'=>true,
                                
                               'enableAjaxValidation' => false,
                               'action'=>'bulk-terminate',
                               'method' => 'post',
                               ]); ?>      
      
        
    <?= Html::hiddenInput('empType', $empType) ?> 
    <?= $form->field($model, 'bulk_upload_file')->widget(FileInput::classname(), [
                                                 'options' => [
                                                     'accept' => 'xlsx, xls,csv',
                                                      'multiple' =>false
                                                    ],
                                                 'pluginOptions'=>[
                                                 'allowedFileExtensions'=>['xlsx','xls','csv'],
                                                 'theme'=>'fas',
                                                 'showUpload' => false,
                                                 'browseClass' => 'btn btn-warning',
                                                 'cancelClass' => 'btn btn-danger',
                                                 'uploadUrl' => '/erp-lpo-request-supporting-doc/create',
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                               
                                                  
  ],     
                                                
                                                                                    
  ])?>
      

<?= Html::submitButton( '<i class="fas fa-user-times"></i> Terminate', ['class' => 'btn btn-primary']) ?>



               


<?php ActiveForm::end(); ?>            
                     
   </div><!--card body -->  
   </div>                   
           
<?php


$indexUrl=Url::to(["employees/index"]);

$script = <<< JS

const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
 $('.download-temp').on('click', function(event) {
  event.preventDefault();

    $.ajax({
      
        url: $(this).attr('href'),
        type: 'GET',

        // Form data
        data: [],

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(resp) {
         var res=JSON.parse(resp);
         if(res.code==0){
             
                $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: '',
        body: res.data.error
      })
         }
         else{
           if(res.data.path!=='undefined'){
             window.location.assign(res.data.path);    
           }
           
            }
     
          
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
       
    });

  
return false;//prevent the modal from exiting

    
});          
   

//----------------------upload---------------------------------------------
 $('#upload-bulk-form').on('beforeSubmit', function(event) {
    

     
     var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
  
   
   Swal.fire({
  title: 'Are you sure?',
  text: 'You want to Terminate Employees?',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText:'Yes,Import',
 
 
}).then((result) => {
  if (result.value) {
  

 $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       beforeSend: function(){
           
        var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Importing Employees...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });   
           
           
       }, // its a function which you have to define

        success: function(response) {
        swal.close();
        console.log(response);
        var res=JSON.parse(response)[0] ;
        
        if(res.code==1){
         toastr.success(res.data.msg)  
         window.location.assign('$indexUrl'); 
           
        }else{
            
             $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Employees Import failed',
        body: res.data.error
      })
            
          }
        
           
   
       
        },

        error: function(){
            swal.close();
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
       
    });



   
  }
})
  
return false;//prevent the modal from exiting
 
    
});

JS;
$this->registerJs($script);

?>
