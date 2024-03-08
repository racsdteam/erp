<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpDocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-documents-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Documents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'document',
            'details:ntext',
            'file_name',
            //'fileType',
            //'mimeType',
            //'date_added',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
