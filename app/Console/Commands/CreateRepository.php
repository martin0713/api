<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a repository';

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
     * @return int
     */
    public function handle()
    {
        $dir = base_path('app/Repositories');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $name = $this->argument('name') . 'Repository';
        $path = base_path() . '/app/Repositories/' . $name . '.php';
        if (file_exists($path)) {
            $this->error($name . ' already exists');
            return 1;
        }
        $file = fopen($path, "w");
        fwrite($file, "<?php\n\nnamespace App\Repositories;\n\nclass $name{};\n");
        fclose($file);
        $this->info($name . ' created successfully');
        return 0;
    }
}
