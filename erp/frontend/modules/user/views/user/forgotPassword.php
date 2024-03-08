<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\Html;
use yii\bootstrap4\ActiveForm;


$this->context->layout='signup';

$this->title = 'Reset Password';


?>


  

<div class="login-box">
  <div  class="login-logo">
    <a class="text-black" href="#"><b>RAC</b>ERP</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Reset Your Password</p>
     
       <?php if (Yii::$app->session->hasFlash('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> <?= Yii::$app->session->getFlash('success') ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif;?>

      <?php if (Yii::$app->session->hasFlash('failure')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> <?= Yii::$app->session->getFlash('failure') ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif;?>


    


     <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
       
       <?= $form->field($model, 'email', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                               
                                    <span class="far fa-envelope"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Enter Your Email']) ?>
              
                                
                                 
           
        <div class="form-group col-sm-12">
         
          <!-- /.col -->
          
            <button type="submit" class="btn btn-success btn-block">SUBMIT</button>
         
          <!-- /.col -->
        </div>
      <?php ActiveForm::end(); ?>

     
    
    
    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


