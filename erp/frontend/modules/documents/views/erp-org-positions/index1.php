<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpOrgPositionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Org Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-org-positions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Org Positions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'position',
            'report_to',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
