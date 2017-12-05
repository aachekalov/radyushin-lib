<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use common\models\Genre;
use common\models\Writer;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'writers')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Writer::find()->all(), 'id', 'fullName'),
        'options' => [
            'placeholder' => 'Выберите автора(ов)',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'showToggleAll' => false,
    ])
    ?>

    <?= $form->field($model, 'genres')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Genre::find()->all(), 'id', 'name'),
        'options' => [
            'placeholder' => 'Выберите жанр(ы)',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'showToggleAll' => false,
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
