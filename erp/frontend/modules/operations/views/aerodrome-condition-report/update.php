<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeConditionReport */

$this->title = 'Update Aerodrome Condition Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aerodrome Condition Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aerodrome-condition-report-update">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
                       </div>
                       <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model, 'aerodromes'=>$aerodromes
    ]) ?>

</div>
</div>
</div>
</div>