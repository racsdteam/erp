<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ContributionsReports */

$this->title = 'Create Contributions Reports';
$this->params['breadcrumbs'][] = ['label' => 'Contributions Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributions-reports-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
