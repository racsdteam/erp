<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpPersonInterim */

$this->title = 'Create Person Interim';
$this->params['breadcrumbs'][] = ['label' => 'Erp Person Interims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-person-interim-create">

    

    <?= $this->render('_form', [
        'model' => $model,'isAjax'=>$isAjax
        
    ]) ?>

</div>
