<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Payrolls */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payrolls-view-pdf">
  
<?=  $this->render('pdf', [
            'model' =>$model
        ]);?>

</div>
