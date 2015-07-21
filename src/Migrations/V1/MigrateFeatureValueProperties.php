<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Language;
use \Neomerx\Core\Models\FeatureValue;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\FeatureValueProperties as Model;

/**
 * @package Neomerx\Database
 */
class MigrateFeatureValueProperties extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_FEATURE_VALUE);
            $table->unsignedInteger(Model::FIELD_ID_LANGUAGE);
            $table->string(Model::FIELD_VALUE, Model::VALUE_MAX_LENGTH);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            $table->unique(
                [Model::FIELD_ID_FEATURE_VALUE, Model::FIELD_ID_LANGUAGE],
                'characteristic_value_properties_unique'
            );

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_FEATURE_VALUE)->references(FeatureValue::FIELD_ID)
                ->on(FeatureValue::TABLE_NAME)->onDelete('cascade');

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
