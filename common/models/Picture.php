<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "picture".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $image_link
 * @property integer $created_at
 * @property integer $updated_at
 */
class Picture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['image_link'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'image_link' => 'Image Link',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	/**	
	* Creates and updates date for pictures
	*/
	 public function behaviors()
	{
		return [
			'timestamp' => [
				
						 'class' => 'yii\behaviors\TimestampBehavior',
						 'attributes' => [
							 ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
							 ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
						 ],
					 
			],
		];
	}
}
