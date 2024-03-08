<?php

use yii\helpers\Html;
use common\models\ErpDocumentAttachment;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocument */

$this->title = 'Share Document';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-create">

   

    <?= $this->render('_form', [
        'model' => $model, 'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,'isAjax'=>$isAjax
    ]) ?>

</div>
