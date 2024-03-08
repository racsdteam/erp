<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgusers */

$this->title = 'Create Tblorgusers';
$this->params['breadcrumbs'][] = ['label' => 'Tblorgusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblorgusers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
