<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductGender */

$this->title = 'Create Product Gender';
$this->params['breadcrumbs'][] = ['label' => 'Product Genders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-gender-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
