<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_org_positions".
 *
 * @property int $id
 * @property string $position
 * @property int $report_to
 */
class ErpOrgPositions extends \yii\db\ActiveRecord
{
   
   public $unit;
   public $status;
   public $level;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_org_positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position','position_code','org_unit'], 'required'],
            [['report_to','org_unit'], 'integer'],
            [['position','level'], 'string', 'max' => 255],
             [['job_role','position_code'], 'string', 'max' => 11],
            [['unit','status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'report_to' => 'Report To',
            
        ];
    }
    

public function getJobRole(){

return $this->hasOne(ErpOrgJobs::className(), ['code' => 'job_role']);

}

public function getReportingTo()
{
 return $this->hasOne(ErpOrgPositions::className(), ['id' => 'report_to']);
}

public function getOrgUnit(){

return $this->hasOne(ErpOrgUnits::className(), ['id' => 'org_unit']);
}

public function getPA(){

//return $this->hasOne(ErpOrgPositions::className(), ['report_to' =>$this->id])->andOnCondition(['job_role'=>'ADMSPT']);

return ErpOrgPositions::find()->where(['report_to'=>$this->id,'job_role'=>'ADMSPT'])->One();
}

public static function findByCode($code)
{
  return self::find()->where(['position_code'=>$code])->One() ;
}


}
