<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_persons_in_position".
 *
 * @property int $id
 * @property int $person_id
 * @property int $position_id
 * @property int $unit_id
 */
class ErpPersonsInPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_persons_in_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'position_id', 'unit_id'], 'required'],
            [['person_id', 'position_id', 'unit_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'position_id' => 'Position ID',
            'unit_id' => 'Unit ID',
        ];
    }
    
  
 public function getOrgUnit(){
     
      return $this->hasOne(ErpOrgUnits::className(), ['id' => 'unit_id'])->one();
 
 }
  
  public function getPosition(){
     
      return $this->hasOne(ErpOrgPositions::className(), ['id' => 'position_id'])->one();
 
 }
  

  function isMember($user) { 
  
  $res=ErpPersonsInPosition::find()->where(['person_id'=>$user->user_id,'unit_id'=>$this->id])->one();
  
  if($res!=null)
    
        return true;
    
    return false;
  }
}
