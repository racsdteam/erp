<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tblfolders */

$this->title = 'Update Folder: ' . $node->name;
$this->params['breadcrumbs'][] = ['label' => 'Tblfolders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tblfolders-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form2', [
        'node' => $node,
    ]) ?>

</div>
