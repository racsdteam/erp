<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\Tenders */

$this->title = 'Create Tenders';
$this->params['breadcrumbs'][] = ['label' => 'Tenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
