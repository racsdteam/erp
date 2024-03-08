<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use frontend\modules\racdms\models\Tblorgs;
?>

<style>

</style>

<div class="card card-default">
           
  
  <div class="card-body ">
   


         <?php
$session = Yii::$app->has('session') ? Yii::$app->session : null;              
                  // helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use($hideCssClass) {
    $class = "alert alert-{$type} alert-dismissible";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
    }
return Html::tag('div', Html::button('&times;',['class'=>'close','data-dismiss'=>'alert','aria-hidden'=>true]). '<div>' . $body . '</div>', ['class' => $class]);  
 
};
                  ?>
                  
                  
                   <div class="kv-treeview-alerts">
        <?php
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        }
       
        ?>
    </div>

  
    <h4 class="card-header mb-3">Add a new User</h4>

    <div class="col-sm-10 mx-auto ">
   
    <?php $form = ActiveForm::begin(['id' => 'add-user-form']); ?>


  <?= $form->field($model, 'first_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'FirstName']) ?>


 <?= $form->field($model, 'last_name', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                       {input}
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'LastName']) ?>
 

     <?= $form->field($model, 'phone', ['template' => '
                       
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                         
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Phone']) ?>
                           


       <?= $form->field($model, 'email', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="far fa-envelope"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Email']) ?>
                           
                           <?php 
                           
                           $orgList=ArrayHelper::map(Tblorgs::find()->all(), 'id','name'); 
                           $roleList=ArrayHelper::map(\frontend\modules\racdms\models\Tblroles::find()->all(), 'id','role');
                            $groupList=ArrayHelper::map(\common\models\Tblgroups::find()->where(['type'=>3])->all(), 'id','name');
                           
                           ?>
                           
       
       
        <?= $form->field($model, 'org',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="far fa-building"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList($orgList, ['prompt'=>'Select  organisation','id'=>'org_id','class'=>['form-control m-select2 org-id ']]) ?>                  


<?=$form->field($model, 'position',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="far fa-building"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->widget(DepDrop::classname(), [
    'options'=>['id'=>'pos-id'],
    'pluginOptions'=>[
        'depends'=>['org_id'],
        'loading'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['tblorgs/org-pos'])
    ]
])?>

 <?= $form->field($model, 'role',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList($roleList, ['prompt'=>'Select  role','id'=>'role_id','class'=>['form-control m-select2']]) ?> 
               
 <?= $form->field($model, 'group',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                       {input}
                          
                           
                           
                       </div>{error}{hint}
               '])->dropDownList($groupList, ['prompt'=>'Select group','id'=>'group_id','class'=>['form-control m-select2']]) ?> 


        <?= $form->field($model, 'username', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                
                                </div>
                       {input}
                           
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Username']) ?>


  <?= $form->field($model, 'password', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user-lock"></i>
                                </span>
                                
                                </div>
                       {input}
                           
                           
                       </div>{error}{hint}
               '])->passwordInput(['autofocus' => true])
                           ->input('password', ['placeholder'=>'Password']) ?>
                           
                           

<?= $form->field($model, 'confirm', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-user-lock"></i>
                                </span>
                                
                                </div>
                       {input}
                            
                           
                       </div>{error}{hint}
               '])->passwordInput(['autofocus' => true])
                           ->input('password', ['placeholder'=>'Confirm']) ?>
                           
                           <div class="form-group float-right">
                               
            
                           


     <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
   
   </div>
    <?php ActiveForm::end(); ?>

 </div>
  
  </div>
  <!-- /.form-box -->
</div>
  
    


 <?php

$script = <<< JS
$(function() {
   $(".m-select2").m-select2({width:'100%'});
});
 
     
JS;
$this->registerJs($script);          

 ?>
            
          
            
            
          
            
           
            
            
            