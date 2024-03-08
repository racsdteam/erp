<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl('/site/login');
?>
<div class="leave-notification">
     <p>Hello <?= Html::encode($recipient) ?>,</p>
     <p>this is to notify you that your leave request is  <?php echo $status?> in ERP System </p>
    
     <p>From  : <?= Html::encode($sender) ?>,</p>
     <p>Date : <?= Html::encode($date) ?>,</p>
     
     
     <?php
     if(!empty($reason))
     {
     ?>
     <h3>Reason :</h3>
     <p><?= Html::encode($reason) ?>,</p>
     <?php
     }
     ?>
    <p>Follow the link below to login:</p>
    <p><?= Html::a(Html::encode($loginLink), $loginLink) ?></p>
   
</div>
