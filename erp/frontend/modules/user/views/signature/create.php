<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Signature */

$this->title = 'User Signature Registration';
$this->params['breadcrumbs'][] = ['label' => 'Signatures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signature-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
