<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestFlow */

$this->title = 'Create Erp Lpo Request Flow';
$this->params['breadcrumbs'][] = ['label' => 'Erp Lpo Request Flows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-lpo-request-flow-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
