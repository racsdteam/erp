<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\PayStructureItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Structure Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-structure-items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pay Structure Items', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pay_structure',
            'item',
            'item_categ',
            'calc_type',
            //'formula',
            //'amount',
            //'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
