<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel common\models\PictureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pictures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Picture', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?php yii\widgets\Pjax::begin(['id' => 'demo']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		
		
		
        'columns' => [
		
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
             [
                'format' => ['image', ['width' => 250, 'height' => 250]],
                'attribute' => 'imageLink',
            ],
			
			[ 
                'attribute'=>'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
				'options' => ['width' => '200']
            ],
			[ 
                'attribute'=>'updated_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
				'options' => ['width' => '200']
            ],
			
			 [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {rotate}',
            'buttons' => [
                'rotate' => function ($url,$model) {
                    return Html::a(
                    'rotate', $url, ['data-pjax'=>'w0']);
                },
               
            ],
			],
         

           
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end(); ?>
</div>
