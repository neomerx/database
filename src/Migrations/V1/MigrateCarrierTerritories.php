<?php namespace Neomerx\Database\Migrations\V1;

use \Schema;
use \Neomerx\Core\Support as S;
use \Neomerx\Core\Models\Carrier;
use \Illuminate\Database\Schema\Blueprint;
use \Neomerx\Core\Models\CarrierTerritory as Model;

class MigrateCarrierTerritories extends BaseMigrate
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
            $table->unsignedInteger(Model::FIELD_ID_CARRIER);

            // instead of ->morph(...) I want use enum but not just string in 'item_type'
            /** @noinspection PhpUndefinedMethodInspection */
            $table->unsignedInteger(Model::FIELD_TERRITORY_ID)->nullable();
            $table->enum(Model::FIELD_TERRITORY_TYPE, [
                S\nameToDbEnum(Model::TERRITORY_TYPE_COUNTRY),
                S\nameToDbEnum(Model::TERRITORY_TYPE_REGION),
            ]);
            $table->index([Model::FIELD_TERRITORY_ID, Model::FIELD_TERRITORY_TYPE]);

            if (self::usesTimestamps()) {
                $table->timestamps();
            }
            if (self::isSoftDeleting()) {
                $table->softDeletes();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            $table->foreign(Model::FIELD_ID_CARRIER)->references(Carrier::FIELD_ID)->on(Carrier::TABLE_NAME)
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
