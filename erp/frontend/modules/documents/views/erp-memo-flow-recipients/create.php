<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoFlowRecipients */

$this->title = 'Create Erp Memo Flow Recipients';
$this->params['breadcrumbs'][] = ['label' => 'Erp Memo Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-memo-flow-recipients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
