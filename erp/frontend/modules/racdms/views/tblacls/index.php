<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblacls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblacls-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tblacls', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'target',
            'targetType',
            'userID',
            'groupID',
            //'roleID',
            //'mode',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
