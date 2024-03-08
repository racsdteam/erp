<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbldocumentcontents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbldocumentcontent-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbldocumentcontent', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'document',
            'version',
            'comment:ntext',
            'date',
            //'createdBy',
            //'dir',
            //'orgFileName',
            //'fileType',
            //'mimeType',
            //'fileSize',
            //'checksum',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
