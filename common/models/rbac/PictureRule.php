<?php

namespace common\models\rbac;

use Yii;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class PictureRule extends Rule
{
    public $name = 'isPicture';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($userId, $item, $params)
    {
        return isset($params['post']) ? $params['post']->user_id == $userId : false;
    }
}
