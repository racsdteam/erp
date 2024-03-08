<?php

namespace frontend\modules\hr\controllers;
use Yii;
use yii\base\Component;

class LeaveInfoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionGetLeaveBalance($category,$financial_year,$user_id)
    {
        $balance=Yii::$app->leave->getRemainingDays($user_id,$category,$financial_year);
        $frequency=Yii::$app->leave->getFrequency($user_id,$category,$financial_year);
        $result["balance"]=$balance;
        $result["frequency"]=$frequency;
        return json_encode($result);
    }

}
