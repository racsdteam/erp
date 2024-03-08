<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpOrganizationOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Organization Offices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-office-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Organization Office', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'office',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
