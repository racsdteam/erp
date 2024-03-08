<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoSupportingDocAnnotations */

$this->title = 'Create Erp Memo Supporting Doc Annotations';
$this->params['breadcrumbs'][] = ['label' => 'Erp Memo Supporting Doc Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-memo-supporting-doc-annotations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
