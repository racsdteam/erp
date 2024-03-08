<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgs */

$this->title = 'Create New Organisation';
$this->params['breadcrumbs'][] = ['label' => 'All Organisations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblorgs-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
