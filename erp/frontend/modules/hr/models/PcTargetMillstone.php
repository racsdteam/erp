<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_target_millstone".
 *
 * @property int $id
 * @property int $target_id
 * @property string $millstone
 * @property string $quarter
 * @property string $status
 * @property string $timestamp
 */
class PcTargetMillstone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_target_millstone';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target_id', 'millstone', 'quarter'], 'required'],
            [['target_id'], 'integer'],
            [['millstone', 'quarter'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_id' => 'Target ID',
            'millstone' => 'Millstone',
            'quarter' => 'Quarter',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
