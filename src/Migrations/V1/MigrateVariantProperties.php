<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Language;
use \Neomerx\Core\Models\Variant;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\VariantProperties as Model;

class MigrateVariantProperties extends BaseMigrate
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
        return self::$model = self::$model ?: new Model();
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
            $table->unsignedInteger(Model::FIELD_ID_VARIANT);
            $table->unsignedInteger(Model::FIELD_ID_LANGUAGE);
            $table->string(Model::FIELD_NAME, Model::NAME_MAX_LENGTH);
            $table->string(Model::FIELD_DESCRIPTION, Model::DESCRIPTION_MAX_LENGTH);

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            $table->unique([Model::FIELD_ID_VARIANT, Model::FIELD_ID_LANGUAGE]);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_VARIANT)->references(Variant::FIELD_ID)->on(Variant::TABLE_NAME)
                ->onDelete('cascade');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_LANGUAGE)->references(Language::FIELD_ID)->on(Language::TABLE_NAME);
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
