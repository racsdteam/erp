<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items Receptions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-reception-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Items Reception', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'item',
            'item_qty',
            'item_unit_price',
            'item_currency',
            //'total_price',
            //'vat_included',
            //'total_currency',
            //'staff_id',
            //'dfile',
            //'itm_desc:ntext',
            //'recv_date',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
