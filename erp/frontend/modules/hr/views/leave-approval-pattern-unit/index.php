<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Approval Pattern Units';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-approval-pattern-unit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leave Approval Pattern Unit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pattern_id',
            'unit_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>