<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ApprovalProcessSteps */

$this->title = 'Create Approval Process Steps';
$this->params['breadcrumbs'][] = ['label' => 'Approval Process Steps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-process-steps-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
