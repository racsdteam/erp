<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcReportOther */

$this->title = 'Create Pc Report Other';
$this->params['breadcrumbs'][] = ['label' => 'Pc Report Others', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-report-other-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
