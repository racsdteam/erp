<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\View;


?>

<div class="callout callout-warning">
              
            <h5><i class="fas fa-info"></i> Access not inherited</h5>
            
           
            
            <?php $form = ActiveForm::begin() ?>
            
             <?= Html::hiddenInput('folderid', $folder->id); ?>
            
            <div class="form-group">
                
           
           
            <?= Html::submitButton('<i class="fa fa fa-clone"></i> Inherit Access', ['class' => 'btn  btn-outline-warning']) ?>
         
            </div>
             
           
              <?php ActiveForm::end(); ?>
            </div>



