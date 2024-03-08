<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestSupportingDoc */

$this->title = 'Create Erp Lpo Request Supporting Doc';
$this->params['breadcrumbs'][] = ['label' => 'Erp Lpo Request Supporting Docs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-lpo-request-supporting-doc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
