<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\EmpStatutoryDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emp Statutory Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-statutory-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emp Statutory Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'employee',
            'rama_pay',
            'rama_no',
            'mmi_pay',
            //'mmi_no',
            //'pension_pay',
            //'pension_no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
