<?php

namespace common\models\query;

use common\models\Blog;
use yii\db\ActiveQuery;

class BlogQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['active' => Blog::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%blog}}.published_at', time()]);
        return $this;
    }
}
