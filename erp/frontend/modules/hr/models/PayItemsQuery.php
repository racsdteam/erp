<?php

namespace frontend\modules\hr\models;


/**
 * This is the ActiveQuery class for [[PayItems]].
 *
 * @see PayItems
 */
class PayItemsQuery extends \yii\db\ActiveQuery
{
    public const TBL_NAME='payItems';
    
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PayItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PayItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
     
     public function fixed(){
      
     return $this->andWhere([self::TBL_NAME.'.'.'proc_type'=>'fixed']);
       
        
      }
      
      public function variable(){
      
     return $this->andWhere([self::TBL_NAME.'.'.'proc_type'=>'variable']);
       
        
      }
      
     public function regular(){
      
     return $this->andWhere([self::TBL_NAME.'.'.'pay_type'=>'REG']);
       
        
      }
     public function suppl(){
      
     return $this->andWhere([self::TBL_NAME.'.'.'pay_type'=>'SUP']);
       
        
      }  
      
    public function earnings(){
      
    return $this->andWhere(['in', self::TBL_NAME.'.'.'category', [PayItemCategories::CAT_E,PayItemCategories::CAT_B]]);
       
        
    }
    
     public function deductions($cat='All'){
      
    return $this->andWhere(['in', self::TBL_NAME.'.'.'category', [PayItemCategories::CAT_D,PayItemCategories::CAT_SD]]);
       
        
    }
    
     public function totals(){
      
    return $this->andWhere(['in', self::TBL_NAME.'.'.'category', [PayItemCategories::CAT_N,PayItemCategories::CAT_G]]);
       
        
    }
    
}
