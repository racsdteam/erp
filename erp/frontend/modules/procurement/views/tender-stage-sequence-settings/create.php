<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStageSequenceSettings */

$this->title = 'Create Tender Stage Sequence Settings';
$this->params['breadcrumbs'][] = ['label' => 'Tender Stage Sequence Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-stage-sequence-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
