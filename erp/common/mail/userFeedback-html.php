<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl('/site/login');
?>
<div class="login-details">
    <p>Hello <?= Html::encode($name) ?> ,Your Registration has been received,wait for approval process !</p>
     <p>  Username  : <?= Html::encode($username) ?>,</p>
     <p>  Password  : <?= Html::encode($password) ?>,</p>
    
   
</div>
