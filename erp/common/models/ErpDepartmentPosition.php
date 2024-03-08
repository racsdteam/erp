<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_department_position".
 *
 * @property int $id
 * @property string $postion
 * @property int $depart
 */
class ErpDepartmentPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_department_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postion', 'depart'], 'required'],
            [['depart'], 'integer'],
            [['postion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postion' => 'Postion',
            'depart' => 'Depart',
        ];
    }
}
