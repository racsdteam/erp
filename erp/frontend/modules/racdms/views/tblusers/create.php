<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblusers */

$this->title = 'Add New User';
$this->params['breadcrumbs'][] = ['label' => 'All Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblusers-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
