<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CartStatus */

$this->title = 'Update Cart Status: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cart Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cart-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
