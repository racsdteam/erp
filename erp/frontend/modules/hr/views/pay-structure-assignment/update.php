<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructureAssignment */

$this->title = 'Update Pay Structure Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pay Structure Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pay-structure-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
