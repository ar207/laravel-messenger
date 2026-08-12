<?php

namespace mar\messenger\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messenger:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the messenger assets';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if($this->option('force')){
            $this->call('vendor:publish', [
                '--tag' => 'messenger-config',
                '--force' => true,
            ]);

            $this->call('vendor:publish', [
                '--tag' => 'messenger-migrations',
                '--force' => true,
            ]);
        }

        $this->call('vendor:publish', [
            '--tag' => 'messenger-views',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'messenger-assets',
            '--force' => true,
        ]);
    }
}
