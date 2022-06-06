<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductMaterial */

$this->title = 'Create Product Material';
$this->params['breadcrumbs'][] = ['label' => 'Product Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
