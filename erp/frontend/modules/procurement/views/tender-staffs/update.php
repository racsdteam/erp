<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStaffs */

$this->title = 'Update Tender Staffs: ' . $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Tender Staffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->_id, 'url' => ['view', 'id' => (string)$model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tender-staffs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'section_code'=>$section_code,
    ]) ?>

</div>
