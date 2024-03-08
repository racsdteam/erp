<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tbldocumentcontent */

$this->title = 'Create Tbldocumentcontent';
$this->params['breadcrumbs'][] = ['label' => 'Tbldocumentcontents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbldocumentcontent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
