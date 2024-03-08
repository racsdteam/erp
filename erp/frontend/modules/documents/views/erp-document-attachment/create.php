<?php

use yii\helpers\Html;
use common\models\ErpDocumentAttachment;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachment */

$this->title = 'Document Attachment(s)';
$this->params['breadcrumbs'][] = ['label' => 'Document nAttachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-document-attachment-create">

  <?= $this->render('_form', [
         'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment]:$modelsAttachement,'isAjax'=>$isAjax,'id'=>$_GET['id']
    ]) ?>

</div>
