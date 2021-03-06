<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cart */

$this->title = 'Create Cart';
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('site/view', [
        'model' => $model,
    ]) ?>

</div>
