<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStages */

$this->title = 'Create Tender Stages';
$this->params['breadcrumbs'][] = ['label' => 'Tender Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-stages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
