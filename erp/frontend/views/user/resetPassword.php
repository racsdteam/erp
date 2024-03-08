<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\Html;
//use yii\bootstrap\ActiveForm;

use yii\helpers\Url;

$this->context->layout = 'signup';

$this->title = 'Sign Up';


?>

<div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">Reset Password</a>
           <small>Kiaop Password Reset Page,reset Password</small>
        </div>

       
        <div class="card">
        <div class="header">
        
                        </div>
            <div class="body">
                <form id="sign_up" method="POST">
                    <div class="msg">Reset Your Password</div>

                   
 <?php if (Yii::$app->session->hasFlash('reset')): ?>

                    <div class="alert alert-success">
                                <strong>Password Reset!</strong> <a href="<?=Url::to(['site/login'])?>" class="alert-link">Click Here To Login</a>
                            </div>

                            <?php endif; ?>  

                   
                    

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control"  name="SignupForm[password]" value="<?=$model->password ?>" minlength="6" placeholder="New Password" required>
                            <input name="SignupForm[tokenhid]" id="ContactForm_email" type="hidden" value="<?php echo $token?>">
                        </div>
                    </div>
 
                  
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SUBMIT</button>

                   
                </form>
            </div>
        </div>



