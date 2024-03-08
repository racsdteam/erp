<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TbldocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbldocuments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbldocuments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbldocuments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'comment:ntext',
            'date',
            'expires',
            //'owner',
            //'folder',
            //'folderList:ntext',
            //'inheritAccess',
            //'defaultAccess',
            //'locked',
            //'keywords:ntext',
            //'sequence',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
