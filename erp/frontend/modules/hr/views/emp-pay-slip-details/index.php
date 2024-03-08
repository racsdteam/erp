<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpPaySlipDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Pay Slip Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-pay-slip-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Pay Slip Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pay_slip',
            'item_categ',
            'item',
            'amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
