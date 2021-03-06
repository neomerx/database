<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Role;
use \Neomerx\Core\Models\ObjectType;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\RoleObjectType as Model;

class MigrateRolesObjectTypes extends BaseMigrate
{
    /**
     * @var Model
     */
    private static $model = null;

    /**
     * @return Model
     */
    protected static function getModel()
    {
        return self::$model = (self::$model !== null ? self::$model : new Model());
    }

    /**
     * Run the migrations.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public static function up()
    {
        Schema::create(Model::TABLE_NAME, function (Blueprint $table) {
            $table->increments(Model::FIELD_ID);
            $table->unsignedInteger(Model::FIELD_ID_TYPE);
            $table->unsignedInteger(Model::FIELD_ID_ROLE);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ALLOW_MASK)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_DENY_MASK)->nullable();

            $table->unique([Model::FIELD_ID_TYPE, Model::FIELD_ID_ROLE]);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_TYPE, 'roles_types_id_type')->references(ObjectType::FIELD_ID)
                ->on(ObjectType::TABLE_NAME)->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_ROLE)->references(Role::FIELD_ID)->on(Role::TABLE_NAME)
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public static function down()
    {
        Schema::dropIfExists(Model::TABLE_NAME);
    }
}
