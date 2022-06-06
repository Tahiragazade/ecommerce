<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "discount".
 *
 * @property int $id
 * @property string $name
 * @property int $product_id
 * @property int $discount_percent
 * @property int $status
 * @property int $deadline
 * @property int $created_at
 * @property int $updated_at
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ ], 'required'],
            [['product_id', 'discount_percent', 'status', ], 'integer'],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'product_id' => 'Product ID',
            'discount_percent' => 'Discount Percent',
            'status' => 'Status',
            'deadline' => 'Deadline',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
