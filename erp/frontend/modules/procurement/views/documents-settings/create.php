<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\SectionSettings */

$this->title = 'Create Document Settings';
$this->params['breadcrumbs'][] = ['label' => 'Section Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
