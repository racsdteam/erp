<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcReportComments */

$this->title = 'Create Pc Report Comments';
$this->params['breadcrumbs'][] = ['label' => 'Pc Report Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-report-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
