<?php 
namespace common\helpers;
use Yii;
class UnitePriceHelper
{
    public $unit_price=0;
    public static function Calculate($item,$startdate,$enddate)
    {
        $q=" SELECT * FROM items_reception as rec inner join reception_goods as gr on gr.id=rec.reception_good   where rec.item='".$item."' and rec.status='approved'
        and gr.reception_date  between '".$startdate."' and '".$enddate."' order by  gr.reception_date  desc limit 5";
          $com= Yii::$app->db1->createCommand($q);
           $rows = $com->queryall();
           $i=0;
            foreach($rows as $row):
                $i++;
                $total=0;
                $temp=0;
                $total=$row['total_price'];
                
               $temp=$total/$row['item_qty'];
                $data[]= intVal($temp);
            endforeach;
            
           if(!empty($data))
           {
            $unit_price_frequency=array_count_values($data);
            $total_up=0;
            $total_down=0;
            foreach($unit_price_frequency as $key => $frequency){
                $total_up=$total_up+($key*$frequency);
                $total_down=$total_down+$frequency;
            }
            if($total_up!=0 &&$total_up!=0 )
            {
            $unit_price=$total_up / $total_down;
            }else{
                $unit_price=0;
            }
           }
            if($unit_price==0)
            {
               return  0; 
            }else{
          return  $unit_price;
            }
    }
    
}

?> 