<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpContact */

$this->title = 'Update your employee contact';
$this->params['breadcrumbs'][] = ['label' => 'Emp Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-contact-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
