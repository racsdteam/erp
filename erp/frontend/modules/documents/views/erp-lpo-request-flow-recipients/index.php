<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpLpoRequestFlowRecipientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Lpo Request Flow Recipients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-lpo-request-flow-recipients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Lpo Request Flow Recipients', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'flow_id',
            'recipient',
            'sender',
            'is_new',
            //'status',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
