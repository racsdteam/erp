<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentType */

$this->title = 'Create Document Type';
$this->params['breadcrumbs'][] = ['label' => 'Document Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-type-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
