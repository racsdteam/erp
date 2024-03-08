<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpDocuments */

$this->title = 'Create Emp Documents';
$this->params['breadcrumbs'][] = ['label' => 'Emp Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
