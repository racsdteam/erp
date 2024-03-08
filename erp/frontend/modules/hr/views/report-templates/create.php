<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ReportTemplates */

$this->title = 'Create Report Templates';
$this->params['breadcrumbs'][] = ['label' => 'Report Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
