<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationAddress */

$this->title = 'Add Organization Address';
$this->params['breadcrumbs'][] = ['label' => 'Organization Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-organization-address-create">

    

    <?= $this->render('info-wizard-form', [
        'model' => $model,'address'=> $address,'contact'=>$contact,'isAjax'=>false,'step'=>$step
    ]) ?>

</div>
