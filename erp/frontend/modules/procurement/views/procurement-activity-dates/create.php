<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementActivityDates */

$this->title = 'Create Procurement Activity Dates';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activity Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-activity-dates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
