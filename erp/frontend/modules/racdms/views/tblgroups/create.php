<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tblgroups */

$this->title = 'New Security Group';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblgroups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
