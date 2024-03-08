<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Travel Clearance Flow Recipients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-travel-clearance-flow-recipients-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Erp Travel Clearance Flow Recipients', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'flow_id',
            'recipient',
            'status',
            'remark:ntext',
            //'sender',
            //'is_new',
            //'is_forwarded',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>