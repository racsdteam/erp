<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[EmpAddress]].
 *
 * @see EmpAddress
 */
class ApprovalWorkflowInstancesQuery extends \yii\db\ActiveQuery
{
    
    public $entity_type;
    
  
    public function prepare($builder)
    {
        if ($this->entity_type !== null) {
            $this->andWhere(['entity_type' => $this->entity_type]);
        }
        return parent::prepare($builder);
    }
    
     public function findByRecord($record)
     {
        return $this->andWhere(['entity_record' =>$record]);
     }
   
     public function all($db = null)
    {
        return parent::all($db);
    } 
    
    public function one($db = null)
    {
        return parent::one($db);
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
