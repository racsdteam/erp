<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationContact */

$this->title = 'Create Erp Organization Contact';
$this->params['breadcrumbs'][] = ['label' => 'Erp Organization Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
