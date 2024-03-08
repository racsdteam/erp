<?php

namespace frontend\modules\hr\models;

use Yii;


 
interface IReportExporter
{
 
public function exportToExcel();
public function exportToPDF();
}
