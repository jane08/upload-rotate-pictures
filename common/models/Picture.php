<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

use yii\web\UploadedFile;
use yii\imagine\Image;

use common\helpers\CustomStringHelper;
use common\helpers\ConvertDate;
use yii\helpers\BaseFileHelper;

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
	
	public $uploadedImage;
    public $imageLink;

	
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
			[['uploadedImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
	
	/**	
	* Saving a picture
	*/
	 public function savePicture($oldImageName = false, $model)
    {
        if($this->uploadedImage  && $this->uploadedImage->tempName) {
            
			 $BaseFileHelper=new BaseFileHelper();
			 $BaseFileHelper->createDirectory ((\Yii::$app->basePath).'/web/uploads/'.$model->user_id.'/', $mode = 0777, $recursive = true );
            
			$newFileName = CustomStringHelper::generateRandomString() .'.'. $this->uploadedImage->extension;
			
			$filepath = 'uploads/'.$model->user_id.'/'. $newFileName;
			
			
			
            // saving original photo to server folder
            if($this->uploadedImage->saveAs($filepath)) {
                 
				 if($oldImageName)
                {
					
                    static::deleteImage($oldImageName);  
									
                }   
				  
				$basepath =  \Yii::$app->basePath .'/web/';
               
				Image::thumbnail($basepath.$filepath, 250, 250)->save(Yii::getAlias($basepath.$filepath), ['quality' => 100]); 
               
               // unlink($filepath);
                $this->uploadedImage = false;
                return $filepath; 
            }    
        }
        else
        {
            return false;    
        }
    }
	
	/**	
	* Deleting a picture
	*/
	 public static function deleteImage($oldImageName)
    {
      
        $basepath =  \Yii::$app->basePath .'/web/';
		$filepath = $basepath.$oldImageName;
		if (file_exists($filepath)) {
            unlink($filepath);
		}   
                       
            
    }
	
	 public function afterFind()
    {
		
        $this->imageLink = '/'.$this->image_link;
        
		$this->created_at = ConvertDate::convert($this->created_at);
        $this->updated_at = ConvertDate::convert($this->updated_at);
        
        return true;
    }
	
}
