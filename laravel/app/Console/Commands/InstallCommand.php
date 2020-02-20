<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bunkermaestro:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize a new instance of Bunker Maestro';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->title("Initializing Bunker Maestro");
        $this->output->writeln("Running Migrations");
        artisan::call("migrate", [], $this->output);

        $this->output->writeln("Installing Laravel Passport");
        artisan::call("passport:install", [], $this->output);

        $this->output->writeln("Clearing the cache");
        artisan::call("cache:clear", [], $this->output);
        artisan::call("config:clear", [], $this->output);
    }
}
