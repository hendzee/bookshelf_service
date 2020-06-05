<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ResetCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "reset:database";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Recreate database";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Run migration...');
        Artisan::call('migrate');

        $this->line('Creating users data...');
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        
        $this->line('Creating categories data...');
        Artisan::call('db:seed', ['--class' => 'CategorySeeder']);

        $this->line('Creating items data...');
        Artisan::call('db:seed', ['--class' => 'ItemSeeder']);

        $this->line('Creating transactions data...');
        Artisan::call('db:seed', ['--class' => 'TransactionSeeder']);
    }
}