<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_size".
 *
 * @property int $id
 * @property int $product_id
 * @property int $size_id
 * @property int $count
 * @property int|null $cost
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class ProductSize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_size';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'size_id', 'count', 'status', 'created_at', 'updated_at'], 'required'],
            [['product_id', 'size_id', 'count', 'cost', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'size_id' => 'Size ID',
            'count' => 'Count',
            'cost' => 'Cost',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
