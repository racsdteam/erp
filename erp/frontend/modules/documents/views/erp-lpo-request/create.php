<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequest */

$this->title = 'Create Lpo Request';
$this->params['breadcrumbs'][] = ['label' => 'Lpo Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-lpo-request-create">

   

    <?= $this->render('_form',  [
                'model' => $model,'req'=>$req, 'modelsDocument' =>$modelsDocument,'isAjax'=>$isAjax
            ]) ?>

</div>
