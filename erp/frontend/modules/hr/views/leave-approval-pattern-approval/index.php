<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Approval Pattern Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-pattern-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leave Approval Pattern Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pattern_id',
            'appover',
            'sequence_number',
            'approval_level',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
