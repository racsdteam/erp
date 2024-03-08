<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompStatutoryDetails */

$this->title = 'Create Comp Statutory Details';
$this->params['breadcrumbs'][] = ['label' => 'Comp Statutory Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comp-statutory-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
