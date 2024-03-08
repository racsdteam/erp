<?php

use yii\helpers\Html;


$this->title = 'Payroll Item';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-people-carry"></i> Create Payroll Item</h3>
                       </div>
               
           <div class="card-body">
               
               <?php
               
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   } 
      
    
         
               ?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
</div>
