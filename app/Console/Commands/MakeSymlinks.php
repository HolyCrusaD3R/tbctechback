<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libs\Symlink;

class MakeSymlinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:symlink {--check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command make symlinks for your folders: scripts, storage';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Symlink $symlink
     * @return void
     */
    public function handle(Symlink $symlink): void
    {
        try {
            $check = $this->option('check');

            if ($check) {
                $symlink->checkLinks();
                $this->info('all links looks good');
            } else {
                $symlink->makeLinks();
                $this->info('all links are created');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
