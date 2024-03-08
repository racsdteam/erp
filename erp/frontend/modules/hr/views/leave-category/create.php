<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveCategory */

$this->title = 'Create Leave Category';
$this->params['breadcrumbs'][] = ['label' => 'Leave Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
