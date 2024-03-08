<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $idDistrict
 * @property integer $province_id
 * @property string $district
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'district'], 'required'],
            [['province_id'], 'integer'],
            [['district'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDistrict' => 'Id District',
            'province_id' => 'Province ID',
            'district' => 'District',
        ];
    }
    
      public function getSectors(){
    
     return $this->hasMany(Sector::className(), ['district_id' => 'idDistrict']);
     
}
}
