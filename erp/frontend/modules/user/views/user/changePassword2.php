


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;





?>





<?php

if (Yii::$app->session->hasFlash('success')): ?>
  
                                  <?php 
                                $msg=  Yii::$app->session->getFlash('success');
                               
                                  echo '<script type="text/javascript">';
                                  echo 'showSuccessMessage("'.$msg.'");';
                                  echo '</script>';
                                  
                                  
                                  ?>
                        
  
                        <?php endif; ?>



<div class="row clearfix">



                <div class="<?php if(!$isAjax){echo 'col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">
                    <div class="card">
                        

                    <div style="text-align:center;" class="header bg-cyan">
                            <h4>
                                
                                
                       Change Password
                               
                            </h4>

                            
                        </div>
                        
                        
                        <div class="body">

                           
                          <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                        <?= $form->field($model, 'password',['template' => '
                        <div class="input-group">
                         <span class="input-group-addon">
                                   <i class="material-icons">lock</i>
                                </span>
                            <div class="form-line">
                            {input}
                               
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput(['placeholder'=>'new password']) ?>
                        <?= $form->field($model, 'confirm_password',['template' => '
                        <div class="input-group">
                         <span class="input-group-addon">
                                   <i class="material-icons">lock</i>
                                </span>
                            <div class="form-line">
                            {input}
                               
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput(['placeholder'=>'confirm new password']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>               
                                 
                           
                        </div>
                    </div>
                </div>
            </div>
           
          
