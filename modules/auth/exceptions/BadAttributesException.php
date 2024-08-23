<?php

declare(strict_types=1);

namespace modules\auth\exceptions;

use Exception;

class BadAttributesException extends Exception
{
    public static function unableToAuthorize(): self
    {
        return new self(\Yii::t('app', 'Unable to authorize try again'));
    }

}