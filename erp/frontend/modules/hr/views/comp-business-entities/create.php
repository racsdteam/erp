<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompBusinessEntities */

$this->title = 'Create Comp Business Entities';
$this->params['breadcrumbs'][] = ['label' => 'Comp Business Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comp-business-entities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
