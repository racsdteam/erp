<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
   
  .image-box {

  /* Here's the trick */
  box-shadow: inset 0 0 0 100vw rgba(0,0,0,0.4);
  /* Add the blur effect */


 
  /* Basic background styles */
  background-image: url(../img/aerial-photo.jpg);
  background-size: cover;

  /* Here's the same styles we applied to our content-div earlier */
  color: white;
  min-height: 50vh;
  display: flex;
  align-items: center;
  justify-content: center;
   width: 100%;
  height:100%;
 
  
   
}

.login-box{
    
    width: 380px !important;
    background: rgba(0,0,0,0.30);
}

.login-card-body{
    
   background: rgba(0, 0, 0, 0.9) !important;
}

   
</style>

<div class='image-box'>

<div class="login-box">
  <div  class="login-logo">
    <a class="text-white" href="#"><b>RAC</b>ERP</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body" >
      <p class="login-box-msg">Sign in to start your session</p>

     <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
       
      
        
         <?= $form->field($model, 'username', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                               
                                    <span class="far fa-user"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'username or email']) ?>
                                
                                  <?= $form->field($model, 'password', ['template' => '
                        <div class="input-group mb-3 col-sm-12">
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                               
                                    <span class="fas fa-lock"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput()
                                ->input('password', ['placeholder'=>'Password']) ?>
           
        <div class="row">
          <div class="col-8">
            <div class="icheck-success">
             
    <input type="checkbox" id="remember" name='LoginForm[rememberMe]' value=<?=$model->rememberMe?> <?php if($model->rememberMe) echo 'checked' ?>>
              
             
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">LOGIN</button>
          </div>
          <!-- /.col -->
        </div>
      <?php ActiveForm::end(); ?>

     
    <div class="d-flex justify-content-between">
          <div>
             <?= Html::a('Register Now', ['site/signup'],['class' => 'text-center text-success']) ?><br>
          </div>
          <!-- /.col -->
          <div>
           <?= Html::a('Forgot Password ?', ['user/user/forgot-password'],['class' => 'text-center text-success']) ?><br>
          </div>
          <!-- /.col -->
        </div>
    
    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

  </div>
    

