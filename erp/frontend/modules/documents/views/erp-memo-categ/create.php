<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoCateg */

$this->title = 'Create Erp Memo Categ';
$this->params['breadcrumbs'][] = ['label' => 'Erp Memo Categs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-memo-categ-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
