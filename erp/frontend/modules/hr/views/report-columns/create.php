<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ReportColumns */

$this->title = 'Create Report Columns';
$this->params['breadcrumbs'][] = ['label' => 'Report Columns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-columns-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
