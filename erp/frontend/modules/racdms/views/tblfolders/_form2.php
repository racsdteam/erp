
<?php

use yii\bootstrap4\ActiveForm;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;


?>

<?php

$session = Yii::$app->has('session') ? Yii::$app->session : null;



$form = ActiveForm::begin(['options' => $formOptions,
'enableClientValidation'=>true,
                               
                               'enableAjaxValidation' => false,
'fieldConfig' => [
        'errorOptions' => ['class' => 'invalid-feedback']
    ],]);
?>



<div class="card m-card">
            <div class="card-header">
                
        <div class="kv-detail-crumbs"><?= $name ?></div>
       
        
              </div>  
              <!-- /.card-header -->
              <div class="card-body">
                 
                 
                  <?php
    /**
     * SECTION 5: Setup alert containers. Mandatory to set this up.
     */
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
    
   <?= $form->field($node,'name')->textInput()?>
   <?= $form->field($node, 'comment')->textarea(['rows' => 6,'placeholder'=>'comment...']) ?>
   <?= Html::submitButton('Update',
                    ['class' => 'btn btn-success', 'title' => $submitTitle]
                ) ?> 
    
    
                  </div>
                  
                   </div>
                   
                   <?php ActiveForm::end(); ?>
                   
                   <?php
                   
                   
                   
                   $script = <<< JS
      $(".needs-validation").on("afterValidate", function (event, messages) {
         //$(this).addClass('was-validated');
});
JS;
$this->registerJs($script);

?>
