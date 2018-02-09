<?php

namespace common\rbac;

use yii\rbac\Rule;
use common\models\Presentation;

/**
 * Checks if user_id matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (!isset($params['id'])) {
            return false;
        }
        
        $query = Presentation::find();
        Presentation::setEditorQueryConditions($query);
        return ($query->andWhere(['id' => $params['id']])->count() > 0) ? true : false;
    }
}