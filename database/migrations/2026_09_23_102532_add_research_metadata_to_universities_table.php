<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | External / source identity
            |--------------------------------------------------------------------------
            */
            $table->string('external_source', 50)
                ->nullable()
                ->after('slug');

            $table->string('external_id', 100)
                ->nullable()
                ->after('external_source');

            $table->string('data_source_url')
                ->nullable()
                ->after('external_id');

            $table->timestamp('data_verified_at')
                ->nullable()
                ->after('data_source_url');

            /*
            |--------------------------------------------------------------------------
            | Ranking metadata
            |--------------------------------------------------------------------------
            |
            | world_ranking alone is not enough.
            |
            | Example:
            | QS #100 != THE #100.
            |
            */
            $table->string('ranking_source', 100)
                ->nullable()
                ->after('world_ranking');

            $table->unsignedSmallInteger('ranking_year')
                ->nullable()
                ->after('ranking_source');

            $table->string('ranking_url')
                ->nullable()
                ->after('ranking_year');

            /*
            |--------------------------------------------------------------------------
            | Acceptance rate metadata
            |--------------------------------------------------------------------------
            */
            $table->unsignedSmallInteger('acceptance_rate_year')
                ->nullable()
                ->after('acceptance_rate');

            $table->string('acceptance_rate_source_url')
                ->nullable()
                ->after('acceptance_rate_year');

            /*
            |--------------------------------------------------------------------------
            | Cost metadata
            |--------------------------------------------------------------------------
            |
            | Prevent:
            |
            | JPY 100000
            | EUR 100000
            | INR 100000
            |
            | from being treated as the same thing.
            |
            */
            $table->char('cost_currency', 3)
                ->nullable()
                ->after('application_fee');

            $table->unsignedSmallInteger('cost_year')
                ->nullable()
                ->after('cost_currency');

            $table->string('cost_source_url')
                ->nullable()
                ->after('cost_year');

            /*
            |--------------------------------------------------------------------------
            | Stable external identifier
            |--------------------------------------------------------------------------
            */
            $table->unique(
                [
                    'external_source',
                    'external_id',
                ],
                'universities_external_source_id_unique'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Scholarship must support UNKNOWN
        |--------------------------------------------------------------------------
        |
        | NULL  = unknown / not verified
        | true  = scholarship confirmed available
        | false = confirmed unavailable
        |
        */
        Schema::table('universities', function (Blueprint $table) {
            $table->boolean('scholarship_available')
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    public function down(): void
    {
        DB::table('universities')
            ->whereNull('scholarship_available')
            ->update([
                'scholarship_available' => false,
            ]);

        Schema::table('universities', function (Blueprint $table) {
            $table->dropUnique(
                'universities_external_source_id_unique'
            );

            $table->dropColumn([
                'external_source',
                'external_id',
                'data_source_url',
                'data_verified_at',

                'ranking_source',
                'ranking_year',
                'ranking_url',

                'acceptance_rate_year',
                'acceptance_rate_source_url',

                'cost_currency',
                'cost_year',
                'cost_source_url',
            ]);
        });

        Schema::table('universities', function (Blueprint $table) {
            $table->boolean('scholarship_available')
                ->nullable(false)
                ->default(false)
                ->change();
        });
    }
};
