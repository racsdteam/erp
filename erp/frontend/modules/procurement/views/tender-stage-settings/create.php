<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStageSettings */

$this->title = 'Create Tender Stage Settings';
$this->params['breadcrumbs'][] = ['label' => 'Tender Stage Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-stage-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
