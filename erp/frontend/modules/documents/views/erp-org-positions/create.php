<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgPositions */

$this->title = 'Create  Positions';
$this->params['breadcrumbs'][] = ['label' => 'Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-org-positions-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
