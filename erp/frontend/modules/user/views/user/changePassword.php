


<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

use yii\helpers\Url;



$this->context->layout = 'login';

?>


           
         <div class="login-box">
  <div class="login-logo">
    <a href="#">RAC<b>ERP</b>portal</a>
  </div>

            <div class="card">
    <div class="card-body login-card-body">
        
        
   <?php
      if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
   ?>
  
          <p class="login-box-msg">New Password</p>
              
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                  
                        <?= $form->field($model, 'tokenhid')->hiddenInput(['value'=>$token])->label(false); ?>
                        <?= $form->field($model, 'password',['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                               
                                    <span class="fas fa-lock"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput(['autofocus' => true])->input('password', ['placeholder'=>'Enter Your New Password'])?>
                      
      
      
        <div class="form-group col-sm-12">
     
      
       
     <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-raised btn-block btn-flat']) ?>
       
    
     <!-- /.col -->
   </div>
     
     
      <?php ActiveForm::end(); ?>

    <!-- /.social-auth-links -->

      <div class="row">
        <div class="col-xs-7">

     <?= Html::a('Back to Login Page', ['/site/login']) ?><br>
   

</div>

</div>
        </div>
        </div>
                    
    

  <!-- /.login-box-body -->
</div>
 
