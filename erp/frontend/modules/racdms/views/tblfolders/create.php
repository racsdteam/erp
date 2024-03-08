<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tblfolders */

$this->title = 'Create Tblfolders';
$this->params['breadcrumbs'][] = ['label' => 'Tblfolders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblfolders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
