<?php

namespace app\helpers;

use Yii;

class DateTimeHelper
{
    /**
     * @return string|null
     */
    public static function getNowTimestamp(): ?string
    {
        return Yii::$app->formatter->asTimestamp(time());
    }
}
