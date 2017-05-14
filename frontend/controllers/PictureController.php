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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        if ($model->load(Yii::$app->request->post()) ) {
			 if (!Yii::$app->user->can('picture')) {
			   throw new ForbiddenHttpException('You do not have permission to add pictures! Please, register first.');
		   }
		   else{
				$model->user_id = Yii::$app->user->identity->id;	
				$model->save();
			}
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
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

		 if (! \Yii::$app->user->can('picture.update.own', ['post' => $model])) {
			   throw new ForbiddenHttpException('You do not own this picture!');
		   }
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
		    
		$model->delete();

        return $this->redirect(['index']);
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
