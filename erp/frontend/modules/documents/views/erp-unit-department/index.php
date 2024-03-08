<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpUnitDepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Unit Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-unit-department-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Unit Department', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'depart_name',
            'unit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
