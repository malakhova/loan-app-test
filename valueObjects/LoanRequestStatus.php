<?php

namespace app\valueObjects;

enum LoanRequestStatus: string
{
    case PENDING = "pending";
    case APPROVED = "approved";
    case DECLINED = "declined";

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
