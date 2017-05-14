<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Picture */
/* @var $form yii\widgets\ActiveForm */
if($model->isNewRecord){
	$action="create";
}
else{
	$action="update";
}
?>

<div class="picture-form">

      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

   
		   <?= $form->field($model, 'uploadedImage')->fileInput(['accept' => 'image/*']) ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	
	
	 <table class="table">
		
		<tbody>
		<?php if (isset($pictures)): ?>
		<?php foreach ($pictures as $picture): ?>
			<?php if ($picture->user_id == Yii::$app->user->identity->id): ?>
		  <tr>
			<td><?php echo Html::img('@web/'.$picture->image_link, ["alt"=>"pic"]) ?></td>
			<td> <?= Html::a('Rotate', ['rotate', 'id' => $picture->id , 'action'=>$action], ['class' => 'btn btn-primary']) ?></td>
			<td> 
				<?= Html::a('Delete', ['delete', 'id' => $picture->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this item?',
					'method' => 'post',
				],
				]) ?>
			</td>
			
		  </tr>
			<?php endif; ?> 
		  
		  
		    
		 <?php endforeach; ?>

		 <?php else: ?>
		  <tr>
			<td>You do not have any uploaded pictures</td>
		  </tr>
		 <?php endif; ?> 
		</tbody>
	</table>
	

    <?php ActiveForm::end(); ?>

</div>
