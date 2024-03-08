<?php

namespace frontend\modules\auction\controllers;
use Yii;

class ActionApiController extends \yii\web\Controller
{
    public function actionBids()
    {
        $bids=Yii::$app->auction->bidsCount();
        return $bids;
    }
     public function actionBidders()
    {
        $bidders=Yii::$app->auction->biddersCount();
        return $bidders;
    }
    public function actionLots()
    {
        $bids=Yii::$app->auction->LotsCount();
        return $bids;
    }
        public function actionSites()
    {
        $bids=Yii::$app->auction->locationCount();
        return $bids;
    }
        public function actionLotsMaxBid()
    {
        $bids=Yii::$app->auction->getLotsMaxPrice();
        return json_encode ($bids);
    }
         public function actionLotsBids()
    {
        $bids=Yii::$app->auction->getLotsBids();
        return json_encode ($bids);
    }
         public function actionLotsInfo()
    {
        $infos=Yii::$app->auction->getLotsInfo();
        return json_encode ($infos);
    }

}
