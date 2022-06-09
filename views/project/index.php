<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>



<h2 class="text-center">Project 1 status</h2>
<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?= $completedReports ?>%" aria-valuenow="<?= $completedReports ?>" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<div class="d-flex flex-row justify-content-center">
    <p><?= Html::encode($status) ?></p>
</div>
