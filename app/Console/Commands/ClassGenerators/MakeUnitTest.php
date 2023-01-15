<?php

namespace App\Console\Commands\ClassGenerators;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeUnitTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:unit-test {unit-test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate unit test.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->output = new ConsoleOutput();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $unitTest = $this->argument('unit-test');

        Artisan::call('make:test', [
            'name' => $unitTest,
            '--unit' => true,
        ], $this->output);

        return 0;
    }
}
