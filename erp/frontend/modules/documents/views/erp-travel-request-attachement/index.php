<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpLpoRequestSupportingDocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Lpo Request Supporting Docs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-lpo-request-supporting-doc-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Lpo Request Supporting Doc', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'doc_upload',
            'lpo_request',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
