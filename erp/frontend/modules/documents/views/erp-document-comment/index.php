<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpDocumentCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Document Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Document Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'comment:ntext',
            'document',
            'timestamp',
            'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>