<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructureItems */

$this->title = 'Update Pay Structure Items: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pay Structure Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pay-structure-items-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
