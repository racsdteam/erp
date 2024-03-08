<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentComment */

$this->title = 'Create Erp Document Comment';
$this->params['breadcrumbs'][] = ['label' => 'Erp Document Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
