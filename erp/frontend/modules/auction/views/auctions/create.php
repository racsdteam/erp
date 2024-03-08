<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Auctions */

$this->title = 'Create Auctions';
$this->params['breadcrumbs'][] = ['label' => 'Auctions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auctions-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
