<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblusers */

$this->title = 'Update Tblusers: ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Tblusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tblusers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
