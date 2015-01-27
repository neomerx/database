<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Models\Language;
use \Neomerx\Core\Models\CustomerRisk;
use \Neomerx\Core\Models\CustomerType;
use \Neomerx\Core\Models\Customer as Model;
use \Illuminate\Database\Schema\Blueprint;

class MigrateCustomers extends BaseMigrate
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
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_ID_CUSTOMER_RISK)->nullable();
            $table->unsignedInteger(Model::FIELD_ID_CUSTOMER_TYPE);
            $table->unsignedInteger(Model::FIELD_ID_LANGUAGE);
            $table->string(Model::FIELD_FIRST_NAME, Model::FIRST_NAME_MAX_LENGTH);
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_LAST_NAME, Model::LAST_NAME_MAX_LENGTH)->nullable();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_EMAIL, Model::EMAIL_MAX_LENGTH)->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string(Model::FIELD_MOBILE, Model::MOBILE_MAX_LENGTH)->unique();
            $table->enum(Model::FIELD_GENDER, [Model::GENDER_MALE, Model::GENDER_FEMALE]);

            if (self::usesTimestamps() === true) {
                $table->timestamps();
            }
            if (self::isSoftDeleting() === true) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CUSTOMER_RISK)
                ->references(CustomerRisk::FIELD_ID)->on(CustomerRisk::TABLE_NAME);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CUSTOMER_TYPE)
                ->references(CustomerType::FIELD_ID)->on(CustomerType::TABLE_NAME);

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
