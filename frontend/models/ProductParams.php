<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_params".
 *
 * @property int $id
 * @property int $product_id
 * @property int $size_id
 * @property int $color_id
 * @property int $count
 * @property int $cost
 * @property int $status
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Cart[] $carts
 * @property Color $color
 * @property Product $product
 * @property Size $size
 */
class ProductParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'size_id', 'color_id', 'count', 'cost', 'status', 'created_at'], 'required'],
            [['product_id', 'size_id', 'color_id', 'count', 'cost', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'string', 'max' => 25],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::className(), 'targetAttribute' => ['size_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'color_id' => 'Color ID',
            'count' => 'Count',
            'cost' => 'Cost',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['param_id' => 'id']);
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Size]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
    }
}
