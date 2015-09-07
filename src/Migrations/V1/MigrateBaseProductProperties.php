<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Language;
use \Neomerx\Core\Models\BaseProduct;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\BaseProductProperty as Model;

class MigrateBaseProductProperties extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_BASE_PRODUCT);
            $table->unsignedInteger(Model::FIELD_ID_LANGUAGE);
            $table->string(Model::FIELD_NAME, Model::NAME_MAX_LENGTH);
            $table->string(Model::FIELD_DESCRIPTION_SHORT, Model::DESCRIPTION_SHORT_MAX_LENGTH);
            $table->string(Model::FIELD_DESCRIPTION, Model::DESCRIPTION_MAX_LENGTH);
            $table->string(Model::FIELD_META_TITLE, Model::META_TITLE_MAX_LENGTH);
            $table->string(Model::FIELD_META_KEYWORDS, Model::META_KEYWORDS_MAX_LENGTH);
            $table->string(Model::FIELD_META_DESCRIPTION, Model::META_DESCRIPTION_MAX_LENGTH);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            $table->unique([Model::FIELD_ID_BASE_PRODUCT, Model::FIELD_ID_LANGUAGE]);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_BASE_PRODUCT)
                ->references(BaseProduct::FIELD_ID)
                ->on(BaseProduct::TABLE_NAME)
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
