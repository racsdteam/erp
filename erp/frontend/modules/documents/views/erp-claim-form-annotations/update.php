<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormAnnotations */

$this->title = 'Update Erp Claim Form Annotations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Claim Form Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-claim-form-annotations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
