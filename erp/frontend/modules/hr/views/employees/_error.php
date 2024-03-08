<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'ERROR';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

</style>

 <div class="card card-default ">
               
               <div class="card-header ">
                <h3 class="card-title">
                   <i class="fas fa-cloud-upload-alt"></i>
                   
                  
                </h3>
              
               
              </div>
           <div class="card-body">
  
       

<?php if (Yii::$app->session->hasFlash('error')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('error')  ?>
               </div>
 
 
         <?php endif; ?>
         
          
                     
   </div><!--card body -->  
   </div>                   
           
<?php




$script = <<< JS


           
   

JS;
$this->registerJs($script);

?>
