<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Approval Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leave Approval Tasks', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'wf',
            'wfStep',
            'request',
            'assigned_to',
            //'original_assigned_to',
            //'status',
            //'assigned',
            //'completed',
            //'outcome',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
