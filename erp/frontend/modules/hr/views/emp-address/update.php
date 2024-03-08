<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpAddress */

$this->title = 'Update yoyr address info. ';
$this->params['breadcrumbs'][] = ['label' => 'Emp Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-address-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
