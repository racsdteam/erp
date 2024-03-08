<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblorgpositions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblorgpositions-index">

    

    <p>
        <?= Html::a('Create Position', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'org',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
