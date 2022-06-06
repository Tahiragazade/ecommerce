<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cart_status".
 *
 * @property int $id
 * @property int $name
 * @property int $status
 * @property string $created_at
 * @property string|null $updated_at
 */
class CartStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'created_at'], 'required'],
            [[ 'status'], 'integer'],
            [['created_at', 'updated_at'], 'string', 'max' => 20],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
