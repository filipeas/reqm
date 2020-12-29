<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProject;
use App\Http\Requests\UpdateProject;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::where('user', auth()->user()->id)->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProject $request)
    {
        $project = new Project();
        $project->setAttributes($request->all());
        $project->save();

        return response()->json($project, $status = 201)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return Project::where('user', auth()->user()->id)->where('id', $project->id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProject $request, Project $project)
    {
        $project->setAttributes($request->all());
        $project->save();

        return response()->json($project, $status = 200)->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if (auth()->user()->id == $project->user)
            $project->delete();
        else
            return response()->json(['message' => 'Project not found.', $status = 404])->setStatusCode(404);

        return response()->json(['message' => 'Project removed successfully.', $status = 200])->setStatusCode(200);
    }
}
