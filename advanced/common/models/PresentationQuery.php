<?php 

namespace common\models;

use yii\db\ActiveQuery;

class PresentationQuery extends ActiveQuery
{

    public function public($state = true)
    {
        return $this->andOnCondition(['is_public' => $state]);
    }

}
