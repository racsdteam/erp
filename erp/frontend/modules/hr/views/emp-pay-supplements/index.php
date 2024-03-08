<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpAdditionalPaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Additional Pays';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-additional-pay-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Additional Pay', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'item',
            'item_categ',
            'amount',
            //'pay_frequency',
            //'pay_month',
            //'from_date',
            //'to_date',
            //'active',
            //'user',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
