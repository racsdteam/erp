<?php

namespace frontend\modules\assets0\models;

use Yii;

/**
 * This is the model class for table "asset_status_details".
 *
 * @property int $id
 * @property int $asset
 * @property string $status
 * @property string $status_date
 * @property string $comment
 * @property int $user
 * @property string $timestamp
 */
class AssetStatusDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_status_details';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db7');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset', 'status', 'status_date', 'user'], 'required'],
            [['asset', 'user'], 'integer'],
            [['status_date', 'timestamp'], 'safe'],
            [['comment'], 'string'],
            [['status'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset' => 'Asset',
            'status' => 'Status',
            'status_date' => 'Status Date',
            'comment' => 'Comment',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}
