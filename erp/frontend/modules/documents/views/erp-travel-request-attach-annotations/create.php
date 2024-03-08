<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelRequestAttachAnnotations */

$this->title = 'Create Erp Travel Request Attach Annotations';
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Request Attach Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-request-attach-annotations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
