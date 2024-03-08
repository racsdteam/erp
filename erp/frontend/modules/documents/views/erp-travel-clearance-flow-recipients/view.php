<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceFlowRecipients */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Travel Clearance Flow Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="erp-travel-clearance-flow-recipients-view">

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
            'flow_id',
            'recipient',
            'status',
            'remark:ntext',
            'sender',
            'is_new',
            'is_forwarded',
            'timestamp',
        ],
    ]) ?>

</div>
