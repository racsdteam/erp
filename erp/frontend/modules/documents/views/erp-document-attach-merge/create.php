<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachMerge */

$this->title = 'Create Erp Document Attach Merge';
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Attach Merges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-attach-merge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
