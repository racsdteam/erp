<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganization */

$this->title = 'Create Erp Organization';
$this->params['breadcrumbs'][] = ['label' => 'Erp Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
