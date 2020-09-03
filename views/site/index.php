<?php

use app\models\WeatherRequestForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model WeatherRequestForm */
/* @var $message string */

$this->title = 'Weather';
?>
<?php $form = ActiveForm::begin(['action' => Url::to('/site/weather')]) ?>
<?= $form->field($model, 'city')->label('Введите город') ?>
<?= Html::submitButton('Проверить погоду', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
<?php if ($model->status === WeatherRequestForm::STATUS_FULL): ?>
    <div class="row">
        <div class="col-xs-3"><img src="<?= WeatherRequestForm::ICON_URL.$model->icon ?>"/><?= $model->description ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3">Температура: <?= $model->temp ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3">Влажность: <?= $model->humidity ?>%</div>
    </div>
    <div class="row">
        <div class="col-xs-3">Давление: <?= $model->pressure ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3">Скорость ветра: <?= $model->windSpeed ?></div>
    </div>
    <?php if ($model->windDirection): ?>
        <div class="row">
            <div class="col-xs-3">Ветер: <?= $model->windDirection ?></div>
        </div>
    <?php endif; ?>
<?php else: ?>
<h3>Ошибка: <?=$message?></h3>
<?php endif; ?>
