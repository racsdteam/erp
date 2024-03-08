<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ApprovalWorkflows */

$this->title = 'Create Approval Workflows';
$this->params['breadcrumbs'][] = ['label' => 'Approval Workflows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approval-Workflows-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
