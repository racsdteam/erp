<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_org_levels".
 *
 * @property int $id
 * @property string $level_name
 */
class ErpOrgLevels extends \yii\db\ActiveRecord
{
     const TYPE_DEPT='D';
     const TYPE_UNIT='U';
     const TYPE_OFFICE='O';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_org_levels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level_name','level_code'], 'required'],
            [['level_name'], 'string', 'max' => 255],
            [['level_code'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_name' => 'Level Name',
        ];
    }
}
