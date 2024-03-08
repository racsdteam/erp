<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl('/site/login');
?>
<div class="user-notification">
     <p>Hello <?= Html::encode($recipient) ?>,</p>
     <p>this is to notify you that there is an incoming <?php echo $doc?> in ERP System </p>
    
     <p>From  : <?= Html::encode($sender) ?>,</p>
     <p>Date : <?= Html::encode($date) ?>,</p>
     <?php
     if(!empty($remark))
     {
     ?>
     <p>Remark : <?= Html::encode($remark) ?>,</p>
     <?php
     }
     ?>
    <p>Follow the link below to login:</p>
    <p><?= Html::a(Html::encode($loginLink), $loginLink) ?></p>
   
</div>
