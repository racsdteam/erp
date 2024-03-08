<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgSubdivisions */

$this->title = 'Create Organization Subdivisions';
$this->params['breadcrumbs'][] = ['label' => 'Organization Subdivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-org-subdivisions-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
