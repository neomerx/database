<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Image;
use \Neomerx\Core\Models\ImageFormat;
use \Neomerx\Core\Models\ImagePath as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateImagePath extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_IMAGE);
            $table->unsignedInteger(Model::FIELD_ID_IMAGE_FORMAT);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_PATH, Model::PATH_MAX_LENGTH)->unique();

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_IMAGE)->references(Image::FIELD_ID)->on(Image::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_IMAGE_FORMAT)
                ->references(ImageFormat::FIELD_ID)->on(ImageFormat::TABLE_NAME);
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
