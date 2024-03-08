<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpPersonInterim */

$this->title = 'Update Person In Interim: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Person Interims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-person-interim-update">

    

    <?= $this->render('_form', [
        'model' => $model,'isAjax'=>$isAjax
    ]) ?>

</div>
