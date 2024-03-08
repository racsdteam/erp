<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpMemoSupportingDocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Memo Supporting Docs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-memo-supporting-doc-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Memo Supporting Doc', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'doc_upload',
            'doc_name',
            'memo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
