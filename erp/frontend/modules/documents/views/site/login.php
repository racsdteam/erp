<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
   
  
  .box-wrapp::before {background-image: url(../img/aerial-photo.jpg);
  background-size: cover;content: "";display: block;
  position: absolute;top: 0;
	right: 0;
	bottom: 0;
	left: 0;
  width: 100%;
  height:100%;

  z-index: -2;
  opacity: 0.4;} 
  
 .login-box-body {
color: #fff;
/*text-shadow: #343a40 2px 2px;*/
z-index: -1;
opacity: 0.8;
background-color: #343a40;
}

.login-box-body input { color: #fff;
/*text-shadow: #343a40 2px 2px;*/ }


@media(min-width:1024px) {
            .login-box-body {
                min-width: 50%;
                min-height: 12em;
            }
            .login-box-body::before {
                margin-left: 25%;
                min-width: 50%;
                min-height: 12em;
            }
        }
        @media (min-width: 320px) {
            .box-wrapp::before {
               background-image: url(../img/aerial-photo.jpg);
            }
        }
        @media (min-width: 460px) {
            .box-wrapp::before {
               background-image: url(../img/aerial-photo.jpg);
            }
        }
        @media (min-width: 720px) {
            .box-wrapp::before {
                background-image: url(../img/aerial-photo.jpg);
            }
        }
        @media (min-width: 980px) {
            .box-wrapp::before {
                background-image: url(../img/aerial-photo.jpg);
            }
        }
        @media (min-width: 1240px) {
            .box-wrapp::before {
                background-image: url(../img/aerial-photo.jpg);
            }
        }
        @media (min-width: 1500px) {
            .box-wrapp::before {
                background-image: url(../img/aerial-photo.jpg);
            }
        }
        @media (min-width: 1760px) {
            .box-wrapp::before {
                background-image: url(../img/aerial-photo.jpg);
            }
        }
</style>
<div class="box-wrapp">
    
  <div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html">RAC<b>ERP</b>portal</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            
            <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
           
           
            <?= $form->field($model, 'username', ['template' => '
                        <div class="col-sm-12" style="margin-top:15px;">
                            <div class="input-group col-sm-12">
                            {input}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'Username']) ?>

                <?= $form->field($model, 'password', ['template' => '
                        <div class="col-sm-12" style="margin-top:15px;">
                            <div class="input-group col-sm-12">
                            {input}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </span>
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput()
                                ->input('password', ['placeholder'=>'Password'])?>

                
                <div class="row">
        <div class="col-xs-7">
          <div class="checkbox">
          <?= $form->field($model, 'rememberMe')->checkbox() ?>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
        <div class="form-group">
     
      
       
     <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-raised btn-block btn-flat']) ?>
       
    
     <!-- /.col -->
   </div>
        </div>
        <!-- /.col -->
      </div>

     
      <?php ActiveForm::end(); ?>

    <!-- /.social-auth-links -->

      <div class="row">
        <div class="col-xs-7">

     <?= Html::a('Register Now', ['site/signup']) ?><br>
   

</div>

<div class="clo-xs-3">
<?= Html::a('Forgot Password ?', ['user/forgot-password']) ?><br>

</div>
</div>
  </div>
  <!-- /.login-box-body -->
</div>
  
    
</div>
