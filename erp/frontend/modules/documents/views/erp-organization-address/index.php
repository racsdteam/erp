<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpOrganizationAddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Organization Addresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-address-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Organization Address', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'org',
            'country',
            'province',
            'city',
            //'postal code',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
