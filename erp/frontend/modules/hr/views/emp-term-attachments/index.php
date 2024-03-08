<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpTermAttachmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Term Attachments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-term-attachments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Term Attachments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'term',
            'description',
            'category',
            'fileName',
            //'dir',
            //'fileType',
            //'mimeType',
            //'user',
            //'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
