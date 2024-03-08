<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[EmpAddress]].
 *
 * @see EmpAddress
 */
class EmpAddressQuery extends \yii\db\ActiveQuery
{
    
    public $address_type;
    public function prepare($builder)
    {
        if ($this->address_type !== null) {
            $this->andWhere(['address_type' => $this->address_type]);
        }
        return parent::prepare($builder);
    }
    
    public function employee($emp){
     
      return $this->andWhere(['employee' => $emp]);   
        
    }
    
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmpAddress[]|array
     */
   /* public function all($db = null)
    {
        return parent::all($db);
    }*/

    /**
     * {@inheritdoc}
     * @return EmpAddress|array|null
     */
  /*  public function one($db = null)
    {
        return parent::one($db);
    }*/
}
