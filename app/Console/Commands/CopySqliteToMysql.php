<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CopySqliteToMysql extends Command
{
    protected $signature = 'db:copy-sqlite-to-mysql {--chunk=500}';
    protected $description = 'Copy data from current SQLite to MySQL connection';

    public function handle()
    {
        $sqlite = DB::connection('sqlite');
        $mysql  = DB::connection('mysql');

        $tables = [
            'users',
            'products',
            'product_serial_numbers',
            'warehouse_transactions',
            'password_reset_tokens',
            'sessions',
        ];
        $chunk  = (int) $this->option('chunk');

        try {
            // Disable foreign key constraints
            $mysql->statement('SET FOREIGN_KEY_CHECKS=0');
            $this->info('Foreign key checks disabled.');

            foreach ($tables as $table) {
                $this->info("Copying table: {$table}");
                
                // Truncate
                $mysql->table($table)->truncate();

                // Copy data
                $sqlite->table($table)->orderBy('id')->chunk($chunk, function ($rows) use ($mysql, $table) {
                    $insert = [];
                    foreach ($rows as $row) {
                        $insert[] = (array) $row;
                    }
                    if (!empty($insert)) {
                        $mysql->table($table)->insert($insert);
                        $this->line("  ✓ Inserted " . count($insert) . " rows");
                    }
                });
            }

            // Re-enable foreign key constraints
            $mysql->statement('SET FOREIGN_KEY_CHECKS=1');
            $this->info('Foreign key checks re-enabled.');

            $this->info('✅ Copy completed successfully!');
            return 0;

        } catch (\Exception $e) {
            $mysql->statement('SET FOREIGN_KEY_CHECKS=1');
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}