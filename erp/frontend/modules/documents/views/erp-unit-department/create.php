<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpUnitDepartment */

$this->title = 'Create Unit Department';
$this->params['breadcrumbs'][] = ['label' => 'Unit Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-unit-department-create">

  

    <?= $this->render('_form', [
        'model' => $model,'isAjax'=>$isAjax
    ]) ?>

</div>
