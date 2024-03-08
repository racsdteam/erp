<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentSeverity */

$this->title = 'Create Erp Document Severity';
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Severities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-severity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
