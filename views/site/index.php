<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1><?=yii\helpers\Html::encode($this->title) ?></h1>

        <p class="lead"><?= $message ?></p>
    </div>
</div>