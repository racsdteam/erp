<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ReportDatasets */

$this->title = 'Create Report Datasets';
$this->params['breadcrumbs'][] = ['label' => 'Report Datasets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-datasets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
