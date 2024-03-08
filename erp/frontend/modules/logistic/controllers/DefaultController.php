<?php
namespace frontend\modules\logistic\controllers;
use Yii;
use yii\web\Controller;
use common\models\SearchModel;
use common\models\UserHelper;
/**
 * Default controller for the `logistic` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
         $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
  $userposition=$userinfo['position_code'];
  
        if($userposition == "MGRLGX" || $userposition == "STOFC"|| $userposition == "ITENG")
        {
        $searchModel= new SearchModel;
            if(!empty($_POST))
       {
           $searchmodel=$_POST['SearchModel'];
           $year=$searchmodel['year'];
       }
        return $this->render('index',["searchModel"=>$searchModel,"year"=>$year]);
        }else{
              return $this->redirect(['request-to-stock/create']);
        }
    }
}
