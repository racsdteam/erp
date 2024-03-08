<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request_request_for_action".
 *
 * @property int $id
 * @property int $tr
 * @property string $action_description
 * @property int $requested_by
 * @property int $action_handler
 * @property int $is_new
 * @property string $status
 * @property string $timestamp
 */
class ErpTravelRequestRequestForAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_request_request_for_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr', 'action_description', 'requested_by', 'action_handler'], 'required'],
            [['tr', 'requested_by', 'action_handler', 'is_new'], 'integer'],
            [['action_description', 'status'], 'string'],
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
            'tr' => 'Travel Resquest',
            'action_description' => 'Action Description',
            'requested_by' => 'Requested By',
            'action_handler' => 'Action Handler',
            'is_new' => 'Is New',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
