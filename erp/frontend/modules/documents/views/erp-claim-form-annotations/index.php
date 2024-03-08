<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Claim Form Annotations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-claim-form-annotations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Erp Claim Form Annotations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'doc',
            'annotation:ntext',
            'author',
            'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
