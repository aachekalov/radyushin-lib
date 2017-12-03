<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Genre */

$this->title = 'Добавить жанр';
$this->params['breadcrumbs'][] = ['label' => 'Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
