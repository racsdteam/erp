<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */


$date=date_create($auction_date);
$date=date_format($date,"d/m/Y H:i:s");
?>
<div class="user-notification">
     <p>Hello <?= Html::encode($recipient) ?>,</p>
     <p>this is to notify you that you have been selected to participate on physical auction for the Lot <?php echo Html::encode($lot)?>, on <?=Html::encode($date) ?> ,
     which will take place at <?=Html::encode($auction_location) ?>.
      
     </p>
     
     <p>Mwiriwe <?= Html::encode($recipient) ?>,</p>
     <p>Tunejejwe no kukumenyesha ko watoranyijwe mubazitabira cyamunara nyirizina  kuri Loti <?php echo Html::encode($lot)?> , iteganijwe kuwa <?=Html::encode($date) ?> , 
            izabera  <?=Html::encode($auction_location) ?>.
            </p>
    
     <p>Bidding Code / Nimero yi ipiganwa: <?php echo $bid_code?>,</p>
    
     <p>Thank you / Murakoze .</p>
   
</div>
