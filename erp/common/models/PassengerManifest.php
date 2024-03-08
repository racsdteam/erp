<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "passenger_manifest".
 *
 * @property int $id
 * @property string $check_in_sequence_number
 * @property string $compartment_code
 * @property string $date_of_flight
 * @property string $flight_number
 * @property string $from_city_airport_code
 * @property string $operating_carrier_pnr_code
 * @property string $Operating_carrier_designator
 * @property string $passenger_description
 * @property string $passenger_fn
 * @property string $passenger_ln
 * @property string $passenger_status
 * @property string $recorded
 * @property string $seat_number
 * @property string $to_city_airport_code
 */
class PassengerManifest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     
     public $date;
    public static function tableName()
    {
        return 'passenger_manifest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['check_in_sequence_number', 'compartment_code', 'date_of_flight', 'flight_number', 'from_city_airport_code', 'operating_carrier_pnr_code', 'Operating_carrier_designator', 'passenger_description', 'passenger_fn', 'passenger_ln', 'passenger_status', 'seat_number', 'to_city_airport_code'], 'required'],
            [['date_of_flight'], 'safe'],
            [['check_in_sequence_number', 'compartment_code', 'flight_number', 'from_city_airport_code', 'operating_carrier_pnr_code', 'Operating_carrier_designator', 'passenger_description', 'passenger_fn', 'passenger_ln', 'passenger_status', 'seat_number', 'to_city_airport_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'check_in_sequence_number' => 'Check In Sequence Number',
            'compartment_code' => 'Compartment Code',
            'date_of_flight' => 'Date Of Flight',
            'flight_number' => 'Flight Number',
            'from_city_airport_code' => 'From City Airport Code',
            'operating_carrier_pnr_code' => 'Operating Carrier Pnr Code',
            'Operating_carrier_designator' => 'Operating Carrier Designator',
            'passenger_description' => 'Passenger Description',
            'passenger_fn' => 'Passenger Fn',
            'passenger_ln' => 'Passenger Ln',
            'passenger_status' => 'Passenger Status',
            'recorded' => 'Recorded',
            'seat_number' => 'Seat Number',
            'to_city_airport_code' => 'To City Airport Code',
        ];
    }
}
