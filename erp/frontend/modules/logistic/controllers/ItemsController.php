<?php

namespace frontend\modules\logistic\controllers;

use Yii;
use common\models\Items;
use common\models\Categories;
use common\models\SubCategories;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
             /*  'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ],
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Items models.
     * @return mixed
     */
    public function actionIndex()
    {
      
        return $this->render('index');
    }
    public function actionCheck()
    {
      
        return $this->render('check');
    }
    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionUpdateCode()
    {
         
        $categorys=Categories::find()->all();
         foreach($categorys as $category)
          {
              
         $sub_categorys=SubCategories::find()->where(["category"=>$category->id])->all();
          foreach($sub_categorys as $sub_category)
          {
              $i=0;
           $items=Items::find()->where(["it_sub_categ"=>$sub_category->id])->all();
            foreach($items as $item)
          {
              $i++;
             $item->it_code=$category['identifier']."-".$sub_category['identifier']."-".str_pad($i, 3, '0', STR_PAD_LEFT); 
              $item->save();
          }
          
          
          }
          
          }
          return "ok";
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Items();


            if(Yii::$app->request->post()){
        $model->attributes=$_POST['Items'];
        
        
        $sub_category=SubCategories::find()->where(["id"=>  $model->it_sub_categ])->one();
        $category=Categories::find()->where(["id"=>$sub_category['category']])->one() ;
        
        $last_item=Items::find()->where(["it_sub_categ"=>$model->it_sub_categ])->orderBy(['it_code' => SORT_DESC,])->one();
          $code_part=explode("-",$last_item->it_code);
          $last_number=intval($code_part[2]);
          $last_number++;
        $model->it_code=$category['identifier']."-".$sub_category['identifier']."-".str_pad($last_number, 3, '0', STR_PAD_LEFT); 
            $model->user=Yii::$app->user->identity->user_id;
            $model->save();
           return $this->redirect(['view', 'id' => $model->it_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

          if(Yii::$app->request->post()){
        $model->attributes=$_POST['Items'];
        
        
        $sub_category=SubCategories::find()->where(["id"=>  $model->it_sub_categ])->one();
        $category=Categories::find()->where(["id"=>$sub_category['category']])->one() ;
        $code_part=explode("-",$model->it_code);
        if($code_part[0]!=$category['identifier']||$code_part[1]!=$sub_category['identifier'])
        {
        
       $last_item=Items::find()->where(["it_sub_categ"=>$model->it_sub_categ])->orderBy(['it_code' => SORT_DESC,])->one();
          $code_part=explode("-",$last_item->it_code);
          $last_number=intval($code_part[2]);
          $last_number++;
        $model->it_code=$category['identifier']."-".$sub_category['identifier']."-".str_pad($last_number, 3, '0', STR_PAD_LEFT);
       // var_dump($model->it_code); die();
        }
            $model->user=Yii::$app->user->identity->user_id;
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->it_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
