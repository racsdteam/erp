<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceFlow */

$this->title = 'Create Erp Travel Clearance Flow';
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Clearance Flows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-clearance-flow-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
