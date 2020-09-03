<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class WeatherRequestForm extends Model
{
    public $city;
    public $status;
    public $description;
    public $humidity;
    public $pressure;
    public $temp;
    public $windSpeed;
    public $windDirection;
    public $icon;


    public const STATUS_FULL = 1;
    public const STATUS_NO_DATA = 0;
    public const STATUS_ERROR_DATA = 2;

    public const PRESSURE_K = 1.333;

    public const ICON_URL = 'http://openweathermap.org/img/wn/';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city' => 'Город',
        ];
    }


    public function loadData($data)
    {
        $weather = ArrayHelper::getValue(ArrayHelper::getValue($data, 'weather'), 0);
        $main = ArrayHelper::getValue($data, 'main');
        $wind = ArrayHelper::getValue($data, 'wind');

        $this->description = ArrayHelper::getValue($weather, 'description');
        $this->icon = ArrayHelper::getValue($weather, 'icon').'.png';
        $this->humidity = ArrayHelper::getValue($main, 'humidity');
        $this->pressure = (int) ArrayHelper::getValue($main, 'pressure') / self::PRESSURE_K;
        $this->temp = ArrayHelper::getValue($main, 'temp');
        $this->windSpeed = ArrayHelper::getValue($wind, 'speed');
        $this->windDirection = Weather::getDirection((int) ArrayHelper::getValue($wind, 'deg'));
        $this->status = self::STATUS_FULL;
    }
}
