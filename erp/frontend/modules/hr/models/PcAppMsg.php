<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_app_msg".
 *
 * @property int $id
 * @property int $pc_id
 * @property int $emp_id
 * @property string $msg
 * @property string $timestamp
 */
class PcAppMsg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_app_msg';
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
            [['pc_id', 'emp_id', 'msg'], 'required'],
            [['pc_id', 'emp_id'], 'integer'],
            [['msg'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pc_id' => 'Pc ID',
            'emp_id' => 'Emp ID',
            'msg' => 'Msg',
            'timestamp' => 'Timestamp',
        ];
    }
}
