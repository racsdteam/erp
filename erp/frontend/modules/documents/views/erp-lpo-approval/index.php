<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Requisition Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Erp Requisition Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'approved',
            'approved_by',
            'approval_status',
            'is_new',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
