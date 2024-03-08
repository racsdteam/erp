<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Itemlist */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Itemlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemlist-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
