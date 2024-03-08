<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\ReportDatasetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Datasets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-datasets-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Report Datasets', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'report',
            'dataset',
            'type',
            'datasource',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
