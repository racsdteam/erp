<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_user_activity_log".
 *
 * @property int $id
 * @property int $user
 * @property string $action
 * @property string $timestamp
 */
class ErpUserActivityLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_user_activity_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'action'], 'required'],
            [['user'], 'integer'],
            [['timestamp'], 'safe'],
            [['action'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'action' => 'Action',
            'timestamp' => 'Timestamp',
        ];
    }
}
