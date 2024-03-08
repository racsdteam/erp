<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\TermReasons */

$this->title = 'Create Term Reasons';
$this->params['breadcrumbs'][] = ['label' => 'Term Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-reasons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
