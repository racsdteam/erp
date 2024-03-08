<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpPaySlipsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Pay Slips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-pay-slips-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Pay Slips', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'unit',
            'position',
            'pay_period',
            //'basic',
            //'gross_pay',
            //'total_deduction',
            //'net_pay',
            //'user',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
