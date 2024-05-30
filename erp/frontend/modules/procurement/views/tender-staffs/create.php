<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStaffs */

$this->title = 'Create Tender Staffs';
$this->params['breadcrumbs'][] = ['label' => 'Tender Staffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tender-staffs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'section_code'=>$section_code,
    ]) ?>

</div>
