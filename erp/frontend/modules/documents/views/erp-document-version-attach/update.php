<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentVersionAttach */

$this->title = 'Update Erp Document Version Attach: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Version Attaches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-document-version-attach-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
