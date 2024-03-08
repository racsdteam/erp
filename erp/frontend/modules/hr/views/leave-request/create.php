<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveRequest */

$this->title = 'Create Leave Request';
$this->params['breadcrumbs'][] = ['label' => 'Leave Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
          'model' => $model, 'LeaveSupporting'=>$LeaveSupporting,
    ]) ?>

</div>
