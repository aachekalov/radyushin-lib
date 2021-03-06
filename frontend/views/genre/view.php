<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Genre */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genre-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? if (!Yii::$app->user->isGuest) { ?>
    <p>
        <?php Pjax::begin(['enablePushState' => false]); ?>
        <?= $this->render('_voting', $_params_); ?>
        <?php Pjax::end(); ?>
    </p>
    <? } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

    <h2>Авторы, написавшие в жанре</h2>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_writer',
    ]) ?>

    <h2>Авторы, написавшие в жанре (отсортированные по рейтингу)</h2>
    <?= ListView::widget([
        'dataProvider' => $dataProvider2,
        'itemView' => '_writer2',
    ]) ?>
</div>
