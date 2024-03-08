<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemo */

$this->title = 'Update Erp Memo: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Erp Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-memo-update">

  

    <?= $this->render('_form', [
        'model' => $model,'isAjax'=>$isAjax
    ]) ?>

</div>
