<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpSubdivisionPositionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Subdivision Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-subdivision-positions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Subdivision Positions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subdiv_id',
            'position_id',
            'position_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
