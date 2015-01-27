<?php namespace Neomerx\Database\Migrations\V1;

use \Illuminate\Database\Migrations\Migration;

/**
 * Base class for migrations. Gives common properties such as table name from associated model,
 * key column name, if created/updated timestamps should be generated, etc.
 *
 * @package Neomerx\Migrations\V1
 */
abstract class BaseMigrate extends Migration
{
    /**
     * @return \Neomerx\Core\Models\BaseModel
     */
    protected static function getModel()
    {
        return null;
    }

    /**
     * @return bool
     */
    public static function usesTimestamps()
    {
        return static::getModel()->usesTimestamps();
    }

    /**
     * @return bool
     */
    public static function isSoftDeleting()
    {
        return method_exists(static::getModel(), 'getDeletedAtColumn');
    }
}
