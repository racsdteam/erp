<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Lots */

$this->title = 'Create Lots';
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Lots-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
