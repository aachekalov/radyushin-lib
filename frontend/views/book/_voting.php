<?php

use yii\helpers\Html;

?>
Голосовать:
<?= Html::a(
    Html::tag('span', '', ['class' => 'glyphicon glyphicon-thumbs-up']),
    ['upvote', 'id' => $model->id],
    ['class' => 'btn btn-default btn-lg', 'disabled' => !$canVote]
) ?>
 <?= (int) $model->votes ?> 
<?= Html::a(
    Html::tag('span', '', ['class' => 'glyphicon glyphicon-thumbs-down']),
    ['downvote', 'id' => $model->id],
    ['class' => 'btn btn-default btn-lg', 'disabled' => !$canVote]
) ?>
