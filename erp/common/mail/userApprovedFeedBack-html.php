<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl('/site/login');
?>
<div class="login-details">
    <p>Hello <?= Html::encode($name) ?> ,Your registration has been  approved !</p>
     <p>  Username  : <?= Html::encode($username) ?>,</p>
     <p>  Password  : <?= Html::encode($password) ?>,</p>
    
    <p>Follow the link below to login:</p>

    <p><?= Html::a(Html::encode($loginLink), $loginLink) ?></p>
   
</div>
