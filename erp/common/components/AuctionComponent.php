<?php
namespace common\components;

use Yii;
use yii\base\Component;
use frontend\modules\auction\models\User;
use frontend\modules\auction\models\Bids;
use frontend\modules\auction\models\Lots;
use frontend\modules\auction\models\LotsLocations;



class AuctionComponent extends Component {

   public function getUserBid($_user,$item){
  
  $cond[]="and"; 
  $cond[]=['user'=>$_user];
  $cond[]=['item'=>$item];
   $bid= Bids::find()
    ->where($cond)
    ->One();
   // return $count->createCommand()->getRawSql() ; 
      
    return $bid ;      
    
   }
 public function biddersCount(){
   $number= User::find()->where(['user_level'=>2])->count();
    return $number ;     
   } 
 public function bidsCount(){
   $number= Bids::find()->count();
    return $number ;     
   }   
   
  public function LotsCount(){
   $number= Lots::find()->count();
    return $number ;     
   } 
   
     
  public function locationCount(){
   $number= LotsLocations::find()->count();
    return $number ;     
   }   


   public function getLotsMaxPrice(){
       
   $lots=Lots::find()->all();
   foreach($lots as $lot)
   {
     
      $max_price="0";
      
      $value= Bids::find()->where(["item"=>$lot->id])->max("cast(REPLACE(`amount`,',','') as unsigned)");
      if($value!=null)
      {
          $max_price=$value;
          
      }
      $lotIt[]="Lot ".$lot['lot'];
      $max_prices[]=$max_price;
   }
   
   $result['lots']=$lotIt;
   $result['max_prices']=$max_prices;
   
    return $result ;     
   } 
   
    public function getLotsBids(){
       
   $lots=Lots::find()->all();
   foreach($lots as $lot)
   {
     
      $max_bid="0";
      
      $value= Bids::find()->where(["item"=>$lot->id])->count();
      if($value!=null)
      {
          $max_bid=$value;
          
      }
      $lotIt[]="Lot ".$lot['lot'];
      $max_bids[]=$max_bid;
   }
   
   $result['lots']=$lotIt;
   $result['max_bids']=$max_bids;
   
    return $result ;     
   }
   
    public function getLotsInfo(){
       
   $lots=Lots::find()->all();
   foreach($lots as $lot)
   {
     
      $bid="0";
      
      $value= Bids::find()->where(["item"=>$lot->id])->count();
      if($value!=null)
      {
          $bid=$value;
          
      }
      $lotIt[]="Lot ".$lot['lot'];
      $init_price[]=$lot['reserve_price'];
      $bids[]=$bid;
      
                $max_price="0";
       $value= Bids::find()->where(["item"=>$lot->id])->max("cast(REPLACE(`amount`,',','') as unsigned)");
      if($value!=null)
      {
          $max_price=$value;
          
      }
      $max_prices[]=$max_price;
      
   }
   
   $result['lots']=$lotIt;
   $result['init_price']=$init_price;
   $result['bids']=$bids;
   $result['max_prices']=$max_prices;
    return $result ;     
   }
   
}

?>