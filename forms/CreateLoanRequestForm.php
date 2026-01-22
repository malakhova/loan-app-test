<?php

namespace app\forms;

use yii\base\Model;

/**
 * Форма для создания заявки на займ
 */
class CreateLoanRequestForm extends Model
{
    public const string ATTR_USER_ID = 'user_id';
    public const string ATTR_AMOUNT = 'amount';
    public const string ATTR_TERM = 'term';

    public ?int $user_id = null;
    public ?int $amount = null;
    public ?int $term = null;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_USER_ID, self::ATTR_AMOUNT, self::ATTR_TERM], 'required'],
            [[self::ATTR_USER_ID, self::ATTR_AMOUNT, self::ATTR_TERM], 'integer', 'min' => 1],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => 'ID пользователя',
            'amount' => 'Сумма займа',
            'term' => 'Срок займа (дней)',
        ];
    }
}
