<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_version".
 *
 * @property int $id
 * @property int $version_number
 * @property int $document
 * @property string $timestamp
 * @property int $user
 */
class ErpDocumentVersion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_version';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version_number', 'document', 'user'], 'required'],
            [['version_number', 'document', 'user'], 'integer'],
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
            'version_number' => 'Version Number',
            'document' => 'Document',
            'timestamp' => 'Timestamp',
            'user' => 'User',
        ];
    }
}
