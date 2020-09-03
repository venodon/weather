<?php

namespace app\controllers;

use app\models\Weather;
use app\models\WeatherRequestForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;


class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $message = '';
        $model = new WeatherRequestForm();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $data = Weather::getWeather($model->city);
            if(ArrayHelper::getValue($data,'status')==='success'){
                $model->loadData(ArrayHelper::getValue($data, 'data'));
            }else{
                $message = ArrayHelper::getValue($data, 'message');
                $model->status = WeatherRequestForm::STATUS_ERROR_DATA;
            }
        }
        return $this->render('index', ['model' => $model, 'message'=>$message]);
    }
}
