<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\Html;
//use yii\bootstrap\ActiveForm;
use kartik\form\ActiveForm;

$this->context->layout = 'login';

$this->title = 'Reset Password';


?>


<div class="login-box">
  <div class="login-logo">
    <a href="#">RAC<b>ERP</b>portal</a>
  </div>

  <div class="login-box-body">
      
       <?php                  
/* if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }*/
  ?>  
  
    <p class="login-box-msg">Reset Your Password</p>

                
                    
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            
          
           
             <?= $form->field($model, 'email', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-envelope"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Enter Your Email']) ?>

                
                <div class="row">
        
        <!-- /.col -->
      
        <div class="form-group">
     
      
       
     <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-raised btn-block btn-flat']) ?>
       
    
     <!-- /.col -->
   </div>
       
        <!-- /.col -->
      </div>

     
      <?php ActiveForm::end(); ?>

    <!-- /.social-auth-links -->

      <div class="row">
        <div class="col-xs-12">

     <?= Html::a('Back to Login Page', ['site/login']) ?><br>
   

</div>

</div>
  </div>
  <!-- /.login-box-body -->
</div>


