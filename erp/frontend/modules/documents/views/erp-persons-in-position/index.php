<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpPersonsInPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Persons In Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-persons-in-position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Persons In Position', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'person_id',
            'position_id',
            'unit_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
