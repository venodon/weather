<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

class Weather extends \yii\base\BaseObject
{
    private const API_URL = 'api.openweathermap.org/data/2.5/weather';

    public static function getWeather(string $city): array
    {
        $lang = Yii::$app->params['lang'];
        $key = Yii::$app->params['apiKey'];
        $client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
        $response = $client->createRequest()
            ->setUrl(self::API_URL)
            ->setData([
                'appid' => $key,
                'lang'  => $lang,
                'q'     => $city,
                'units' => 'metric'
            ])
            ->send();
        if ($response->isOk) {
            return ['status' => 'success', 'data' => $response->data];
        }
        return [
            'status'  => 'fail',
            'message' => ArrayHelper::getValue($response->data, 'cod') === '404' ? 'Город не найден' : 'Ошибка при получении данных'
        ];
    }

    public static function getDirection(int $dec)
    {
        if(!$dec){
            return null;
        }
        $direction = 'Северный';
        if($dec>22 && $dec<=67){
            $direction = 'Северо-восточный';
        }elseif ($dec>67 && $dec<=112){
            $direction = 'Восточный';
        }elseif ($dec>112 && $dec<=157){
            $direction = 'Юго-восточный';
        }elseif ($dec>157 && $dec<=202){
            $direction = 'Южный';
        }elseif ($dec>202 && $dec<=247){
            $direction = 'Юго-западный';
        }elseif ($dec>247 && $dec<=292){
            $direction = 'Западный';
        }elseif ($dec>292 && $dec<=337){
            $direction = 'Северо-западный';
        }
        return $direction;
    }
}
