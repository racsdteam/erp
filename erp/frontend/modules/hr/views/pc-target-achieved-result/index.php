<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pc Target Achieved Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-target-achieved-result-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pc Target Achieved Result', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pc_report_id',
            'target_id',
            'deliverable:ntext',
            'indicator:ntext',
            //'emp_id',
            //'emp_pos',
            //'status',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
