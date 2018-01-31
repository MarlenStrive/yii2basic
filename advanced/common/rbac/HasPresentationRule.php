<?php

namespace common\rbac;

use yii\rbac\Rule;
use common\models\Presentation;

/**
 * Checks if user has at least one presentation, shown on the frontend
 */
class HasPresentationRule extends Rule
{
    public $name = 'hasPresentation';

    /**
     * @param int $userId
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return Presentation::getPublicPresentationsCount($user) > 0;
    }
}