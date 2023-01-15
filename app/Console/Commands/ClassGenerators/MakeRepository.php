<?php

namespace App\Console\Commands\ClassGenerators;

use App\Services\Utility\ClassGeneratorService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository : Name of repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate repository class.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $repositoryName = $this->argument('repository');

        $generatorService = (new ClassGeneratorService)
            ->setType('repository')
            ->setFileName($repositoryName);

        if ($exists = file_exists($generatorService->getFullDesignatedPath())) {
            $question = 'The class is already exist. Are you sure want to override the existing class?';
            if (! $this->confirm($question)) {
                $this->error('Class overriding process aborted.');
                return ConsoleCommand::FAILURE;
            }
        }

        $className = $generatorService->getClassName();
        $type = $exists ? 'overridden' : 'created';
        $generatorService->generate() ?
            $this->info($className . ' has been ' . $type . ' successfully!') :
            $this->error('Failed to generate the class! Please check permission');

        return ConsoleCommand::SUCCESS;
    }
}
