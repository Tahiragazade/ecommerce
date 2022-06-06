<?php 
use yii\helpers\ArrayHelper;

$dataCategory=ArrayHelper::map(\backend\models\Category::find()->asArray()->all(), 'id', 'name');
	echo $form->field($model, 'category_id')->dropDownList($dataCategory, 
	         ['prompt'=>'-Choose a Category-',
			  'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('post/lists?id=').'"+$(this).val(), function( data ) {
				  $( "select#title" ).html( data );
				});
			']); 
	
	$dataPost=ArrayHelper::map(\common\models\Post::find()->asArray()->all(), 'id', 'title');
	echo $form->field($model, 'title')
        ->dropDownList(
            $dataPost,           
            ['id'=>'title']
        );
?>