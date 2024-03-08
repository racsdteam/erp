<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\procurement\models\ProcurementActivitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-activities-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Procurement Activities', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'planId',
            'end_user_org_unit',
            'code',
            'description:ntext',
            //'procurement_category',
            //'procurement_method',
            //'funding_sources',
            //'user',
            //'created',
            //'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
