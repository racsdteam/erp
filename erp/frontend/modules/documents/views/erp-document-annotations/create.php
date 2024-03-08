<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAnnotations */

$this->title = 'Create Erp Document Annotations';
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-annotations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
