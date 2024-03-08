<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\KeyCompetencies */

$this->title = 'Create Key Competencies';
$this->params['breadcrumbs'][] = ['label' => 'Key Competencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="key-competencies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
