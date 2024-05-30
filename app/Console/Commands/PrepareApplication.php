<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PrepareApplication extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'api:prepare';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Prepares the application';

  /**
   * Execute the console command.
   */

  public function handle()
  {
    $this->info('Preparing APIs...');

    $this->call('migrate');

    $this->call('db:seed');

    $this->call('passport:install', ['--force' => true]);

    $this->call('serve');
  }
}
