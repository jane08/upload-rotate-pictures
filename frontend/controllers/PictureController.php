<?php

namespace frontend\controllers;

use Yii;
use common\models\Picture;
use common\models\PictureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\ConvertDate;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * PictureController implements the CRUD actions for Picture model.
 */
class PictureController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Picture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PictureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model = Picture::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Picture model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if (!Yii::$app->user->can('picture')) {
			   throw new ForbiddenHttpException('You do not have permission to manage pictures! Please, register first.');
		   }
		  
			$model =  $this->findModel($id);
		   
		 if (! \Yii::$app->user->can('picture.view.own', ['post' => $model])) {
			   throw new ForbiddenHttpException('You do not own this picture!');
		   }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Picture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		 if (!Yii::$app->user->can('picture')) {
			   throw new ForbiddenHttpException('You do not have permission to manage pictures! Please, register first.');
		   }
        $model = new Picture();
		$pictures = Picture::find()->all();

        if ($model->load(Yii::$app->request->post()) ) {
			 if (!Yii::$app->user->can('picture')) {
			   throw new ForbiddenHttpException('You do not have permission to add pictures! Please, register first.');
		   }
		   else{
				$model->user_id = Yii::$app->user->identity->id;	
				
				 // set file object to attribute uploadedImage
				 $model->uploadedImage = UploadedFile::getInstance($model, 'uploadedImage');
				 $newImg = $model->savePicture(false, $model);
				 
				  if($newImg)
					{
						$model->image_link = $newImg;
					}
				else
					{
						$model->image_link = NULL;
					}
				
				$model->save();
			}
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'pictures' => $pictures,
            ]);
        }
    }

    /**
     * Updates an existing Picture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		
        $model = $this->findModel($id);
		$pictures = Picture::find()->all();
		 if (! \Yii::$app->user->can('picture.update.own', ['post' => $model])) {
			   throw new ForbiddenHttpException('You do not own this picture!');
		   }
		
		 $oldImageName = $model->image_link;
		
        if ($model->load(Yii::$app->request->post()) ) {
			$model->user_id = Yii::$app->user->identity->id;	
			$model->uploadedImage = UploadedFile::getInstance($model, 'uploadedImage');
            $newImg = $model->savePicture($oldImageName,$model);
                	        
            if($newImg)
            {
                $model->image_link = $newImg;
				
            }
			$model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'pictures' => $pictures,
            ]);
        }
    }

    /**
     * Deletes an existing Picture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		if (!Yii::$app->user->can('picture')) {
			   throw new ForbiddenHttpException('You do not have permission to manage pictures! Please, register first.');
		   }
		   
		 $model = $this->findModel($id);
		 
		 
       
		 if (! \Yii::$app->user->can('picture.delete.own', ['post' => $model])) {
			   throw new ForbiddenHttpException('You do not own this picture!');
		   }
		   
		   if (file_exists((\Yii::$app->basePath).'/web/'.$model->image_link)) {
					unlink((\Yii::$app->basePath).'/web/'.$model->image_link);
					
			}
		    
		$model->delete();

        return $this->redirect(['index']);
    }

	 public function actionRotate($id,$action=false)
    {
		if (!Yii::$app->user->can('picture')) {
			   throw new ForbiddenHttpException('You do not have permission to manage pictures! Please, register first.');
		   }
		   
		 $model = $this->findModel($id);
		 $pictures = Picture::find()->all();
       
		 if (! \Yii::$app->user->can('picture.delete.own', ['post' => $model])) {
			   throw new ForbiddenHttpException('You do not own this picture!');
		   }
		 /*   
		Image::frame(\Yii::$app->basePath .'/web/'.$model->image_link , 0, '666', 0)
		->rotate(-90)
		->save(\Yii::$app->basePath.'/web/'.$model->image_link , ['jpeg_quality' => 50]);
		*/
		
		$image = Image::getImagine();
			$newImage = $image->open(Yii::getAlias(\Yii::$app->basePath.'/web/'.$model->image_link));
			 
			$newImage->rotate(-90);
			 
			$newImage->save(Yii::getAlias(\Yii::$app->basePath.'/web/'.$model->image_link), ['quality' => 80]);
		
		 $searchModel = new PictureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model = Picture::find()->all();
		 
	
		if($action=="create"){
			return $this->redirect(['create', 
				'model' => $model,
				'pictures' => $pictures,
				]);
		}
		else if($action=="update"){
			$model = $this->findModel($id);
			
				 return $this->redirect(['update', 'id' => $model->id, 
				 'model' => $model,
				'pictures' => $pictures,]);
		}
	
			 return $this->redirect(['index', 
					'searchModel' => $searchModel,
					'dataProvider' => $dataProvider,
					'model' => $model,
				]);
		 
		
			
    }
	
	
    /**
     * Finds the Picture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Picture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Picture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
