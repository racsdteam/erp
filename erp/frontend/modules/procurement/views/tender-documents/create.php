<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderDocuments */

$this->title = 'Create Tender Documents';
$this->params['breadcrumbs'][] = ['label' => 'Tender Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'section_code'=>$section_code,
    ]) ?>

</div>
