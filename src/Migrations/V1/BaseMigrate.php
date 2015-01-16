<?php namespace Neomerx\Database\Migrations\V1;

use \Illuminate\Database\Migrations\Migration;
use \Neomerx\Core\Exceptions\NotImplementedException;

/**
 * Base class for migrations. Gives common properties such as table name from associated model,
 * key column name, if created/updated timestamps should be generated, etc.
 *
 * @package Neomerx\Migrations\V1
 */
abstract class BaseMigrate extends Migration
{
    /**
     * @throws \Neomerx\Core\Exceptions\NotImplementedException If not implemented in the child class.
     *
     * @return \Neomerx\Core\Models\BaseModel
     */
    protected static function getModel()
    {
        throw new NotImplementedException();
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
