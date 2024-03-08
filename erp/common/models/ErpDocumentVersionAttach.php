<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_version_attach".
 *
 * @property int $id
 * @property int $version
 * @property int $attachment
 */
class ErpDocumentVersionAttach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_version_attach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_version', 'attach_id'], 'required'],
            [['doc_version', 'attach_id'], 'integer'],
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
        ];
    }
}
