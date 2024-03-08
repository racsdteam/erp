<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormAnnotations */

$this->title = 'Create Erp Claim Form Annotations';
$this->params['breadcrumbs'][] = ['label' => 'Erp Claim Form Annotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-claim-form-annotations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
