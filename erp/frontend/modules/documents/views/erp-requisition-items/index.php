<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpRequisitionItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Requisition Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-requisition-items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Requisition Items', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'designation',
            'specs:ntext',
            'quantity',
            'badget_code',
            //'requisition_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
