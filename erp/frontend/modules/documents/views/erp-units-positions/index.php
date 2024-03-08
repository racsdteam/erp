<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpUnitsPositionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Units Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-units-positions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Units Positions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'unit_id',
            'position_id',
            'position_count',
            'position_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
