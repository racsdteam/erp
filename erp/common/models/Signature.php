<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "signature".
 *
 * @property int $id
 * @property int $user
 * @property string $signature
 * @property string $timestamp
 *
 * @property User $user0
 */
class Signature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'signature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'signature'], 'required'],
            [['user'], 'integer'],
            [['timestamp'], 'safe'],
            [['signature'], 'string', 'max' => 256],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'user_id']],
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
            'signature' => 'Signature',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user']);
    }
}
