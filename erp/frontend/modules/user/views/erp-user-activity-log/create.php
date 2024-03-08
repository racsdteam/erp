<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpUserActivityLog */

$this->title = 'Create Erp User Activity Log';
$this->params['breadcrumbs'][] = ['label' => 'Erp User Activity Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-user-activity-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
