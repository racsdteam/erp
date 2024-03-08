


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;



$this->context->layout = 'login';

?>


           
         <div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html">RAC<b>ERP</b>portal</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">New Password</p>

                   
 <?php if (Yii::$app->session->hasFlash('success')): ?>

                    <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   
                   <?php  echo Yii::$app->session->getFlash('success')  ?>
                </div>

                            <?php endif; ?>  
<?php if (Yii::$app->session->hasFlash('failure')): ?>

                    <div class="alert bg-red alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   
                   <?php  echo Yii::$app->session->getFlash('failure')  ?>
                </div>

                            <?php endif; ?>                   
                    
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            
            <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
           
           
              <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                        <?= $form->field($model, 'tokenhid')->hiddenInput(['value'=>$token])->label(false); ?>
                        <?= $form->field($model, 'password',['template' => '
                        <div class="input-group">
                         <span class="input-group-addon">
                                   <i class="material-icons">lock</i>
                                </span>
                            <div class="form-line">
                            {input}
                               
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput(['placeholder'=>'password']) ?>
                      

                
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
        <div class="col-xs-7">

     <?= Html::a('Back to Login Page', ['site/login']) ?><br>
   

</div>

</div>
  </div>
  <!-- /.login-box-body -->
</div>
 
