<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\View;


?>

<style>
    
    
 .btn-access{display: inline-block; margin-right: 20px;}
</style>

<div class="callout callout-success">
              
            <h5><i class="fa fa-sitemap"></i> Access is being inherited</h5>
            
            <div class="row">
                
             
                
        <?php $form = ActiveForm::begin(['options' => ['class'=>'inherit-access-form'],
                               'id'=>'copy-access-form', 
                               'enableClientValidation'=>true,
                               'action' => ['tblfolders/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               
                                 
                               ]) ?>
            
             <?= Html::hiddenInput('folderid', $folder->id); ?>
             <?= Html::hiddenInput('action', 'notinherit'); ?> 
             <?= Html::hiddenInput('mode', 'copy'); ?> 
            
            <div class="form-group">
                
             <?= Html::SubmitButton('<i class="far fa fa-copy"></i> Copy Parent Permissions Settings', ['class' => 'btn  btn-outline-success btn-access',
             'title'=>'Copy Parent Permissions']) ?>
         
            </div>
             
           
              <?php ActiveForm::end(); ?>
              
              
             
                      <?php $form = ActiveForm::begin(['options' => ['class'=>'inherit-access-form'],
                               'id'=>'new-access-list-form', 
                               'enableClientValidation'=>true,
                               'action' => ['tblfolders/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               
                                 
                               ]) ?>
            
             <?= Html::hiddenInput('folderid', $folder->id); ?>
             <?= Html::hiddenInput('action', 'notinherit'); ?> 
             <?= Html::hiddenInput('mode', 'empty'); ?> 
            
            <div class="form-group">
                
            <?= Html::SubmitButton('<i class="fas fa-user-tag"></i> Add New Access List', ['class' => 'btn  btn-outline-success btn-access',
            'title'=>'Start with new Access list']) ?>
         
            </div>
             
           
              <?php ActiveForm::end(); ?>
              
                
                
              
            </div>



