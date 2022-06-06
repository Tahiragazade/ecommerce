<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_gender".
 *
 * @property int $id
 * @property int $product_id
 * @property int $gender_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gender $gender
 * @property Product $product
 */
class ProductGender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'product_id', 'gender_id', 'status', ], 'required'],
            [[ 'product_id', 'gender_id', 'status', ], 'integer'],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender_id' => 'id']],
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
            'gender_id' => 'Gender ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
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
}
