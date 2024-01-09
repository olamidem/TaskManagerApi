<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    //

    public function index(Request $request)
    {
        $project = QueryBuilder::for(Project::class)
            ->allowedIncludes('tasks')
            ->paginate();
        return new ProjectCollection($project);
    }


    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $project = Auth::user()->projects()->create($validated);
        return new ProjectResource($project);
    }

    public function show(Request $request, Project $project)
    {
        return (new ProjectResource($project))->load('tasks');
    }
    public function update(UpdateTaskRequest $request, Project $project)
    {

        $validated = $request->validated();
        $project->update($validated);
        return new ProjectResource($project);
    }
}
