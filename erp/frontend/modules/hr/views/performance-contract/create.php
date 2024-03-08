<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PerformanceAppraisal */

$this->title = 'Imihigo Form';
$this->params['breadcrumbs'][] = ['label' => 'Imihigo Form', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="performance-appraisal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form',[
            'model' => $model,'companyTargetModels' => $companyTargetModels,'unitTargetModels' => $unitTargetModels,
            'employeeTargetModels' => $employeeTargetModels, 'scoretModel' => $scoretModel,
        ])
        
        ?>

</div>
