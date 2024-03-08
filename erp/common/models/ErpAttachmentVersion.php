<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_attachment_version".
 *
 * @property int $id
 * @property int $version_number
 * @property int $attachment
 * @property string $timestamp
 * @property int $user
 */
class ErpAttachmentVersion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_attachment_version';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version_number', 'attachment', 'user'], 'required'],
            [['version_number', 'attachment', 'user'], 'integer'],
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
            'version' => 'Version',
            'attachment' => 'Attachment',
            'timestamp' => 'Timestamp',
            'user' => 'User',
        ];
    }
}
