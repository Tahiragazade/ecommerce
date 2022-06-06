<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CartStatus */

$this->title = 'Create Cart Status';
$this->params['breadcrumbs'][] = ['label' => 'Cart Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
