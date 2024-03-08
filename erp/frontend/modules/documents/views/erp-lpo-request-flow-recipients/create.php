<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestFlowRecipients */

$this->title = 'Create Erp Lpo Request Flow Recipients';
$this->params['breadcrumbs'][] = ['label' => 'Erp Lpo Request Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-lpo-request-flow-recipients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
