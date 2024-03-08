<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_attach_merge".
 *
 * @property int $id
 * @property int $document
 * @property int $attachement
 * @property string $visible
 */
class ErpDocumentAttachMerge extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_attach_merge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document', 'attachement'], 'required'],
            [['document', 'attachement'], 'integer'],
            [['visible'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document' => 'Document',
            'attachement' => 'Attachement',
            'visible' => 'Visible',
        ];
    }
}
