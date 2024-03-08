<?php

namespace common\models;

use Yii;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\EmpEmployment;
/**
 * This is the model class for table "erp_org_units".
 *
 * @property int $id
 * @property string $unit_name
 * @property int $unit_level
 * @property int $parent_unit
 */
class ErpOrgUnits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_org_units';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_name','unit_code', 'unit_level'], 'required'],
            [['unit_level', 'parent_unit'], 'integer'],
            [['unit_name'], 'string', 'max' => 255],
            [['unit_code'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_name' => 'Unit Name',
            'unit_level' => 'Unit Type',
            'parent_unit' => 'Parent Unit',
        ];
    }
    
  function isMember($user) { 
  
  $res=ErpPersonsInPosition::find()->where(['person_id'=>$user->user_id,'unit_id'=>$this->id])->one();
  
  if($res!=null)
    
        return true;
    
    return false;
  
  

}

function getParent(){
return $this->hasOne(ErpOrgUnits::className(), ['id' => 'parent_unit']);
}
function getType(){

return $this->hasOne(ErpOrgLevels::className(), ['id' => 'unit_level']);
}

function getPositions(){

//return $this->hasMany(ErpOrgPositions::className(), ['org_unit' => 'id'])->andwhere(['active_status'=>1]);

 return $this->hasMany(ErpOrgPositions::className(), ['id' => 'position_id'])
            ->viaTable(ErpUnitsPositions::tableName(), ['unit_id' => 'id'])->onCondition(['active_status' => true]);;

}

function getEmployees(){

 return $this->hasMany(Employees::className(), ['id' => 'employee'])
            ->viaTable(EmpEmployment::tableName(), ['org_unit' => 'id']);

}

public static function findByCode($code)
{
  return self::find()->where(['unit_code'=>$code])->One() ;
}


}
