<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('island_destinations')) {
            Schema::table('island_destinations', function (Blueprint $table) {
                if (!Schema::hasColumn('island_destinations', 'slug')) {
                    $table->string('slug')->nullable()->unique()->after('id');
                }
                if (!Schema::hasColumn('island_destinations', 'features')) {
                    $table->json('features')->nullable()->after('description_ar');
                }
                if (!Schema::hasColumn('island_destinations', 'image')) {
                    $table->string('image')->nullable()->after('features');
                }
                if (!Schema::hasColumn('island_destinations', 'price')) {
                    $table->decimal('price', 10, 2)->nullable()->after('image');
                }
                if (!Schema::hasColumn('island_destinations', 'rating')) {
                    $table->decimal('rating', 3, 2)->nullable()->after('price');
                }
                if (!Schema::hasColumn('island_destinations', 'city_id')) {
                    $table->unsignedBigInteger('city_id')->nullable()->after('rating');
                }
                if (!Schema::hasColumn('island_destinations', 'type')) {
                    $table->string('type')->nullable()->after('city_id');
                }
            });

            // add foreign key if column exists and foreign doesn't
            if (Schema::hasColumn('island_destinations', 'city_id')) {
                try {
                    Schema::table('island_destinations', function (Blueprint $table) {
                        $sm = Schema::getConnection()->getDoctrineSchemaManager();
                        // avoid duplicate foreign key creation
                        $exists = false;
                        foreach ($sm->listTableForeignKeys('island_destinations') as $fk) {
                            if (in_array('city_id', $fk->getLocalColumns())) {
                                $exists = true; break;
                            }
                        }
                        if (!$exists) {
                            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
                        }
                    });
                } catch (\Exception $e) {
                    // ignore foreign key creation errors on some MySQL setups
                }
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('island_destinations')) {
            Schema::table('island_destinations', function (Blueprint $table) {
                if (Schema::hasColumn('island_destinations', 'slug')) {
                    $table->dropColumn('slug');
                }
                if (Schema::hasColumn('island_destinations', 'features')) {
                    $table->dropColumn('features');
                }
                if (Schema::hasColumn('island_destinations', 'image')) {
                    $table->dropColumn('image');
                }
                if (Schema::hasColumn('island_destinations', 'price')) {
                    $table->dropColumn('price');
                }
                if (Schema::hasColumn('island_destinations', 'rating')) {
                    $table->dropColumn('rating');
                }
                if (Schema::hasColumn('island_destinations', 'city_id')) {
                    $table->dropColumn('city_id');
                }
                if (Schema::hasColumn('island_destinations', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
};
