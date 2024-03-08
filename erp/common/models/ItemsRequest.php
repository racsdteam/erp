<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items_request".
 *
 * @property int $id
 * @property int $request_id
 * @property int $it_id
 * @property int $req_qty
 * @property int $out_qty
 * @property string $timestamp
 */
class ItemsRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_request';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'it_id', 'req_qty', 'out_qty'], 'required'],
            [['request_id', 'it_id'], 'integer'],
            [[ 'req_qty', 'out_qty'], 'number'],
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
            'request_id' => 'Request ID',
            'it_id' => 'Item',
            'req_qty' => 'Req Qty',
            'out_qty' => 'Out Qty',
            'comment' => 'Comment',
            'timestamp' => 'Timestamp',
        ];
    }
}
