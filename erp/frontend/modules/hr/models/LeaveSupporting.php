<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "leave_supporting".
 *
 * @property int $id
 * @property int $leave_request_id
 * @property string $doc
 * @property int $uploaded_by
 * @property string $timestamp
 */
class LeaveSupporting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
  public $attach_files;
    public static function tableName()
    {
        return 'leave_supporting';
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
            [['leave_request_id', 'doc'], 'required'],
            [['leave_request_id', 'uploaded_by'], 'integer'],
            [['doc'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leave_request_id' => 'Leave Request ID',
            'doc' => 'Doc',
            'uploaded_by' => 'Uploaded By',
            'timestamp' => 'Timestamp',
        ];
    }
}
