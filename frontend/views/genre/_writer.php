<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Genre */
?>

<div class="writer">
    <?= Html::a($model['surname'] . ' ' . $model['name'], ['writer/view', 'id' => $model['writer_id']], ['class' => 'writer-link']) ?>
</div>
