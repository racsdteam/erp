<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $idProvince
 * @property string $province
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province'], 'required'],
            [['province'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idProvince' => 'Id Province',
            'province' => 'Province',
        ];
    }
    
   public function getDistricts(){
    
     return $this->hasMany(District::className(), ['province_id' => 'idProvince']);
     
}
}
