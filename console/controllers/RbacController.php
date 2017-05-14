<?php

namespace console\controllers;
use yii;
use common\models\rbac\PictureRule;
use yii\console\Controller;

class RbacController extends Controller
{
  public function actionInit()
    {
        $auth = Yii::$app->authManager;

		
		$rule = new PictureRule;
		$auth->add($rule);

		$pictureRole = $auth->createRole('picture');
		$pictureUpdate = $auth->createPermission('picture.update');

		//--- Updating		
		
		$updateOwnPicture = $auth->createPermission('picture.update.own');
		$updateOwnPicture->description = 'Update own picture';
		$updateOwnPicture->ruleName = $rule->name;
		$auth->add($updateOwnPicture);
			
		$auth->addChild($updateOwnPicture, $pictureUpdate);

		// giving pirmission to update user's own picture
		$auth->addChild($pictureRole, $updateOwnPicture);
		
		//--- Deleting
		
		$deleteOwnPicture = $auth->createPermission('picture.delete.own');
		$deleteOwnPicture->description = 'Delete own picture';
		$deleteOwnPicture->ruleName = $rule->name;
		$auth->add($deleteOwnPicture);
			
		$auth->addChild($deleteOwnPicture, $pictureUpdate);

		// giving pirmission to delete user's own picture
		$auth->addChild($pictureRole, $deleteOwnPicture);
		
		//--- Viewing
		
		$viewOwnPicture = $auth->createPermission('picture.view.own');
		$viewOwnPicture->description = 'View own picture';
		$viewOwnPicture->ruleName = $rule->name;
		$auth->add($viewOwnPicture);
			
		$auth->addChild($viewOwnPicture, $pictureUpdate);

		// giving pirmission to view user's own picture
		$auth->addChild($pictureRole, $viewOwnPicture);
		
		
			
	}
}
