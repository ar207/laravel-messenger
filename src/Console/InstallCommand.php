<?php

namespace mar\messenger\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messenger:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laravel Messenger package';

    /**
     * Check Laravel version.
     *
     * @var bool
     */
    private $isV8;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->isV8 = explode('.',app()->version())[0] >= 8;

        $this->info('Installing Laravel Messenger...');

        $this->line('----------');
        $this->line('Configurations...');
        $this->info('[✓] done');

        $assetsToBePublished = [
            'config' => config_path('messenger.php'),
            'views' => resource_path('views/vendor/'),
            'assets' => public_path('messenger'),
            'migrations' => database_path('migrations/2023_12_18_999999_create_messages_table.php'),
        ];

        foreach ($assetsToBePublished as $target => $path) {
            $this->line('----------');
            $this->process($target, $path);
        }

        $this->line('----------');
        $this->info('[✓] Messenger installed successfully');
    }

    /**
     * Check, publish, or overwrite the assets.
     *
     * @param string $target
     * @param string $path
     * @return void
     */
    private function process($target, $path)
    {
        $this->line('Publishing '.$target.'...');
        if (!File::exists($path)) {
            $this->publish($target);
            $this->info('[✓] '.$target.' published.');
            return;
        }
        if ($this->shouldOverwrite($target)) {
            $this->line('Overwriting '.$target.'...');
            $this->publish($target,true);
            $this->info('[✓] '.$target.' published.');
            return;
        }
        $this->line('[-] Ignored, The existing '.$target.' was not overwritten');
    }

    /**
     * Ask to overwrite.
     *
     * @param string $target
     * @return void
     */
    private function shouldOverwrite($target)
    {
        return $this->confirm(
            $target.' already exists. Do you want to overwrite it?',
            false
        );
    }

    /**
     * Call the publish command.
     *
     * @param string $tag
     * @param bool $forcePublish
     * @return void
     */
    private function publish($tag, $forcePublish = false)
    {
        $this->call('vendor:publish', [
            '--tag' => 'messenger-'.$tag,
            '--force' => $forcePublish,
        ]);
    }
}
