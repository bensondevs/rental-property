<?php

namespace App\Services\Utility;

use App\Repositories\LogRepository;

class LogService
{
    /**
     * Log repository instance class container property.
     *
     * @var LogRepository
     */
    private $repository;

    /**
     * List of log types.
     *
     * @var array
     */
    private $types = [];

	/**
	 * Create New Service Instance
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->repository = app(LogRepository::class);
		$this->prepareTypes();
	}

    /**
     * Prepare available log types.
     *
     * @return void
     */
    private function prepareTypes(): void
    {
        $enumPath = app_path('Enums/Log');
        $enumNamespace = 'App\\Enums\\Log';

        $fileNames = load_folder_file_names($enumPath);
        foreach ($fileNames as $fileName) {
            $className = str_replace('.php', '', $fileName);
            $enum = app($enumNamespace . '\\' . $className);
            $this->types = array_merge($this->types, $enum->collectValues());
        }
    }

    /**
     * Write log into the database.
     *
     * @param string $type
     * @param string $message
     * @param array $resources
     * @return bool
     */
    public function write(
        string $type = 'unknown:type',
        string $message = '',
        array $resources = []
    ): bool
    {
        return $this->repository->save([
            'user_id' => auth()->check() ? authUserId() : 0,
            'ip' => request_ip(),
            'type' => $type,
            'resources' => json_encode($resources),
            'message' => $message,
        ]);
    }
}
