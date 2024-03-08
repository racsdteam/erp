<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tblacls */

$this->title = 'Create Tblacls';
$this->params['breadcrumbs'][] = ['label' => 'Tblacls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblacls-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
