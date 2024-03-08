<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoSupportingDoc */

$this->title = 'Create Erp Memo Supporting Doc';
$this->params['breadcrumbs'][] = ['label' => 'Erp Memo Supporting Docs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-memo-supporting-doc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
