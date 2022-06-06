<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("span").click(function(){
    $("table").append($("tr:first").clone(true));
  });
 
});
</script>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),

    ]) ?>

        <?= $form->field($model, 'image',['inputOptions' => [
        'autocomplete' => 'off']])->widget(InputFile::className(), [
        'language'      => 'en',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => true       // возможность выбора нескольких файлов
    ]);?>

        
        <?=  $form->field($model, 'category')->dropDownList($model::getItems(),[ 'prompt'=>'Select Category']);?>

             
        <table class="table table-striped">
            <?php if(!empty($params)) { foreach($params as $key => $value): ?>
            <tr>
                <td align="center">
                   <?= $form->field($model, 'size[]')->dropDownList(
                    [ $data['size'],        ], 
                    [ 'prompt'=>'Size','value' => $value->size_id]) ?>
                </td>
                <td align="center">
                    <?= $form->field($model, 'color[]')->dropDownList(
                    [ $data['color'],        ], 
                    [ 'prompt'=>'Color','value' => $value->color_id]) ?>
                </td>
                <td align="center">
                    <?= $form->field($model, 'count[]')->textInput(['maxlength' => true,'value' => $value->count]) ?>
                </td>
                <td align="center">
                    <?= $form->field($model, 'product_cost[]')->textInput(['maxlength' => true,'value' => $value->cost]) ?>
                </td>
                <td align="center">
                    <span class='btn btn-primary'>Add</span>
                    
                </td>
            </tr>
            <?php endforeach; } else { ?>
                 <tr>
                <td align="center">
                   <?= $form->field($model, 'size[]')->dropDownList(
                    [ $data['size'],        ], 
                    [ 'prompt'=>'Size']) ?>
                </td>
                <td align="center">
                    <?= $form->field($model, 'color[]')->dropDownList(
                    [ $data['color'],        ], 
                    [ 'prompt'=>'Color']) ?>
                </td>
                <td align="center">
                    <?= $form->field($model, 'count[]')->textInput(['maxlength' => true]) ?>
                </td>
                <td align="center">
                    <?= $form->field($model, 'product_cost[]')->textInput(['maxlength' => true]) ?>
                </td>
                <td align="center">
                    <span class='btn btn-primary'>Add</span>
                    
                </td>
            </tr>
            <?php } ?>
            
        </table>
        <?= $form->field($model, "material")->widget(Select2::classname(), [
           
            'data'=>$data['material'],
            
            'options' => ['placeholder' => 'Select Material'],
            'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,


            ],
          
        ]); 

        ?>

        <?= $form->field($model, 'gender')->widget(Select2::classname(), [
           
            'data'=>$data['gender'],
            
            'options' => ['placeholder' => 'Select Gender'],
            'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,


            ],]); ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'discount_name')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput(['placeholder' => 'Discount Percent (%)']) ?>

    <?= $form->field($model, 'deadline')->widget(DatePicker::className(),[ 'options' => ['placeholder' => 'Discount Deadline','autocomplete' => 'off'],],)?>

    <?= $form->field($model, 'status')->dropDownList(
        [
        '1' => 'Active',
        '0' => 'Deaktive',
        ], 
    [ 'prompt'=>'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
