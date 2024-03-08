<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrgLevels */

$this->title = 'Add new Organization Level';
$this->params['breadcrumbs'][] = ['label' => 'Organization Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-org-levels-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
