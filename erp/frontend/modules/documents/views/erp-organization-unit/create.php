<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationUnit */

$this->title = 'Create  Organization Unit';
$this->params['breadcrumbs'][] = ['label' => 'Organization Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-unit-create">

  

    <?= $this->render('_form', [
        'model' => $model,'isAjax'=>$isAjax
    ]) ?>

</div>
