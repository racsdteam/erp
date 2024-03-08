<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_unit_department".
 *
 * @property int $id
 * @property string $depart_name
 * @property int $unit
 */
class ErpUnitDepartment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_unit_department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['depart_name', 'unit'], 'required'],
            [['unit'], 'integer'],
            [['depart_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'depart_name' => 'Depart Name',
            'unit' => 'Unit',
        ];
    }
}
