<?php

namespace Modules\Faq\Enums;

use Modules\Role\Contracts\PermissionEnum;

class QuestionCategoryPermission implements PermissionEnum
{
    const CREATE_QUESTION_CATEGORIES = 'create question categories';
    const VIEW_QUESTION_CATEGORIES = 'view question categories';
    const EDIT_QUESTION_CATEGORIES = 'edit question categories';
    const DELETE_QUESTION_CATEGORIES = 'delete question categories';
    const SORT_QUESTION_CATEGORIES = 'sort question categories';

    public static function module(): string
    {
        return 'Категории вопросов';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_QUESTION_CATEGORIES => 'Добавление категорий вопросов',
            static::VIEW_QUESTION_CATEGORIES => 'Просмотр категорий вопросов',
            static::EDIT_QUESTION_CATEGORIES => 'Редактирование категорий вопросов',
            static::DELETE_QUESTION_CATEGORIES => 'Удаление категорий вопросов',
            static::SORT_QUESTION_CATEGORIES => 'Сортировка категорий вопросов',
        ];
    }
}
