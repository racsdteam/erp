<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl('site/login');
?>
<div class="login-details">
    <p>Hello <?= Html::encode($name) ?> ,A new user has been registered !</p>
     <p>  Username  : <?= Html::encode($username) ?>,</p>
     <p>  Password  : <?= Html::encode($password) ?>,</p>
    
   
</div>
