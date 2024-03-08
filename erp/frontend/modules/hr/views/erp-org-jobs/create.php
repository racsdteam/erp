<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\JobRoles */

$this->title = 'Create Job Roles';
$this->params['breadcrumbs'][] = ['label' => 'Job Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-Roles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
