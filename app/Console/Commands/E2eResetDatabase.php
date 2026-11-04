<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class E2eResetDatabase extends Command
{
    protected $signature = 'e2e:reset';

    protected $description = 'Kosongkan database e2e lalu isi ulang data minimum';

    public function handle(): int
    {
        // Pengaman: jangan pernah reset database local/dev.
        if (! app()->environment('testing')) {
            $this->error('e2e:reset hanya boleh dijalankan dengan APP_ENV=testing.');

            return self::FAILURE;
        }

        Schema::disableForeignKeyConstraints();

        foreach (Schema::getTables() as $table) {
            if ($table['name'] === 'migrations') {
                continue;
            }

            DB::table($table['name'])->truncate();
        }

        Schema::enableForeignKeyConstraints();

        $this->callSilent('db:seed', ['--force' => true]);
        $this->callSilent('db:seed', ['--class' => 'E2eSeeder', '--force' => true]);

        $this->info('Database e2e sudah di-reset.');

        return self::SUCCESS;
    }
}
