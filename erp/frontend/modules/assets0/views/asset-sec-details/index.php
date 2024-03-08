<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\assets0\models\AssetSecDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asset Sec Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-sec-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Asset Sec Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'asset',
            'category',
            'product',
            'product_code',
            //'vendor',
            //'enabled',
            //'install_date',
            //'up_to_date',
            //'user',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
