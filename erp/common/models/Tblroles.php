<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tblroles".
 *
 * @property int $id
 * @property string $role
 * @property int $user
 * @property string $timestamp
 */
class Tblroles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblroles';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'user'], 'required'],
            [['user'], 'integer'],
            [['timestamp'], 'safe'],
            [['role'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}
