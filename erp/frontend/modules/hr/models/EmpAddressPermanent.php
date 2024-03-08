<?php

namespace frontend\modules\hr\models;

class EmpAddressPermanent extends EmpAddress
{
    const TYPE = 'PA';
    public function init()
    {
        $this->address_type = self::TYPE;
        parent::init();
    }
    public static function find()
    {
        return new EmpAddressQuery(get_called_class(), ['address_type' => self::TYPE]);
    }
    public function beforeSave($insert)
    {
        $this->address_type = self::TYPE;
        return parent::beforeSave($insert);
    }
}

?>