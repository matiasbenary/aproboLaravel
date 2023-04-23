<?php

namespace App\Actions\Project;

use App\Data\Project\CreateProjectData;
use App\Models\Project;
use Spatie\QueueableAction\QueueableAction;

class CreateProjectAction
{
    use QueueableAction;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(CreateProjectData $data): Project
    {
        return Project::create($data->toArray());
    }
}
