<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tbldocumentfiles */

$this->title = 'Create Tbldocumentfiles';
$this->params['breadcrumbs'][] = ['label' => 'Tbldocumentfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbldocumentfiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
