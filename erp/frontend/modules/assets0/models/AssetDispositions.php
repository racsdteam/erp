<?php

namespace frontend\modules\assets0\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "asset_dispositions".
 *
 * @property int $id
 * @property int $asset
 * @property string $dspl_date
 * @property string $dspl_reason
 * @property string $comment
 * @property int $user
 * @property string $timestamp
 */
class AssetDispositions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_dispositions';
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
            [['asset', 'dspl_date', 'dspl_reason', 'user'], 'required'],
            [['asset', 'user'], 'integer'],
            [['dspl_date', 'timestamp'], 'safe'],
            [['comment'], 'string'],
            [['dspl_reason'], 'string', 'max' => 11],
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
            'dspl_date' => 'Dspl Date',
            'dspl_reason' => 'Dspl Reason',
            'comment' => 'Comment',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
     public function getAsset0()
    {
        return $this->hasOne(Assets::className(), ['id' => 'asset']);
    }
    
    
     public function getReason0()
    {
        return $this->hasOne(AssetDsplReasons::className(), ['code' => 'dspl_reason']);
    }
    
    
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user']);
    }
}
