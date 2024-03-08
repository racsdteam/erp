<?php
namespace frontend\modules\assets0\utils;


use Yii;
use yii\base\Component;
use frontend\modules\assets0\models\Assets;
use frontend\modules\assets0\models\AssetTypes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\UserException;


class AssetUtil extends Component {

public function generateTagNo($type){
    
  if(empty($type))  
  throw new UserException("Invalid Asset Type!") ;
 
  if(($model=AssetTypes::findByCode($type))==null)
  throw new UserException("Invalid Asset Type!") ;
   
    $pad_base=1;
    $prefix=$model->code;
    $lastAssetType=Assets::find()->select(['a.id','a.type','a.tagNo'])
                                   ->alias('a')
                                   ->innerJoinWith('type0')
                                   ->where(['type'=>$model->code])
                                   ->andWhere(["not",["a.tagNo"=> null]])
                                   ->orderBy(['id' => SORT_DESC])->one();
          
          if(!empty($lastAssetType)){
             $number=explode("-",$lastAssetType->tagNo);
         $pad_base=(int) filter_var($number[1], FILTER_SANITIZE_NUMBER_INT);
         ++$pad_base;
        }                      
        
         
        return $prefix."-".str_pad($pad_base, 6, '0', STR_PAD_LEFT);
}

  public function assetCountByType($type,$count=0){
 
  $count= Assets::find()->select(['id'=>'asset_id'])->innerJoinWith([
    'type0' => function($q)use($type) {
      $q->andOnCondition(['type' =>$type]);
    }
])->count();

return $count;
 
 }
 
 public function countByType($assetType,$totalAssets=0){
     
  $totalAssets = Assets::find()->where(['type' => $assetType])->count();  
  
  return $totalAssets;
     
 }
 
  public function totalAssets($count=0){
 
  $count= Assets::find()->count();

return $count;
 
 }

 } 
?>