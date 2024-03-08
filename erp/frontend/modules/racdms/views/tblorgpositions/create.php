<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgpositions */

$this->title = 'Create Position';
$this->params['breadcrumbs'][] = ['label' => 'All Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblorgpositions-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
