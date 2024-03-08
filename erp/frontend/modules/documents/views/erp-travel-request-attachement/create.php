<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestSupportingDoc */

$this->title = 'Create Travel Request Attachement';
$this->params['breadcrumbs'][] = ['label' => 'Travel Request Attachement(s)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-request-attachement-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
