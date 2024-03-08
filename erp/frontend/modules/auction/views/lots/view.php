<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Items */

$this->title = 'Lot #No '.$model->lot;
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="items-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'lot',
            'description:ntext',
            'quantity',
            'reserve_price',
            'comment:ntext',
            'auction_date',
            
            'winner',
            'timestamp',
        ],
    ]) ?>

</div>
