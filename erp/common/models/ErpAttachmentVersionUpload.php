<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_attachment_version_upload".
 *
 * @property int $id
 * @property int $attach_version
 * @property string $attach_upload
 */
class ErpAttachmentVersionUpload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_attachment_version_upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attach_version', 'attach_upload'], 'required'],
            [['attach_version'], 'integer'],
            [['attach_upload','file_name'], 'string', 'max' => 255],
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
            'attach_upload' => 'Attach Upload',
        ];
    }
}
