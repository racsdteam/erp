<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sector".
 *
 * @property int $idSector
 * @property string $sector
 * @property int $district_id
 */
class Sector extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sector';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sector', 'district_id'], 'required'],
            [['district_id'], 'integer'],
            [['sector'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idSector' => 'Id Sector',
            'sector' => 'Sector',
            'district_id' => 'District ID',
        ];
    }
    
  /*   public function getVillages(){
    
     return $this->hasMany(Village::className(), ['sector_id' => 'id']);
     
}*/
}
