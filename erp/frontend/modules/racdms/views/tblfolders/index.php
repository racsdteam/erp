<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblfolders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblfolders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tblfolders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'root',
            'lft',
            'rgt',
            'lvl',
            //'name',
            //'comment:ntext',
            //'icon',
            //'icon_type',
            //'active',
            //'selected',
            //'disabled',
            //'readonly',
            //'visible',
            //'collapsed',
            //'movable_u',
            //'movable_d',
            //'movable_l',
            //'movable_r',
            //'removable',
            //'removable_all',
            //'child_allowed',
            //'user',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
