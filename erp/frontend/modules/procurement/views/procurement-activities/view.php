<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementActivities */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="procurement-activities-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'planId',
            'end_user_org_unit',
            'code',
            'description:ntext',
            'procurement_category',
            'procurement_method',
            'funding_sources',
            'user',
            'created',
            'updated',
        ],
    ]) ?>

</div>
