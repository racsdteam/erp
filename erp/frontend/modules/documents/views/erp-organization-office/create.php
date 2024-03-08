<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationOffice */

$this->title = 'Create Erp Organization Office';
$this->params['breadcrumbs'][] = ['label' => 'Erp Organization Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-office-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
