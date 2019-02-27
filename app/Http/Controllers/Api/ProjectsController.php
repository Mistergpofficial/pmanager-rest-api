<?php

namespace App\Http\Controllers\Api;
use App\Models\Project;
use App\Models\Comment;
use App\Models\ProjectUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    public function index()
    {
        //$projects = Auth::user()->projects()->get();
        $projects = Project::where('user_id', Auth::user()->id)->get();

        return response()->json($projects);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'description' => 'required'
        ]);

        $user = Auth::user();

        $project = new Project();
        $project->user_id = $user->id;
        $project->company_id = $request->input('company_id');
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->save();

        //  \Log::info($request->all());

        return response()->json(['data' => $project], 200, [], JSON_NUMERIC_CHECK);

    }

    public function store1(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'company_id' => 'required|not_in:0'
        ]);

        $user = Auth::user();

        $project = new Project();
        $project->user_id = $user->id;
        $project->company_id = $request->input('company_id');
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->save();

        //  \Log::info($request->all());

        return response()->json(['data' => $project], 200, [], JSON_NUMERIC_CHECK);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\AppModelsProject  $appModelsProject
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*$Project = Project::find($Project->id);*/
    //    $comment = Comment::where('id', $id)->with('user')->get();
        $project = Project::where('id', $id)->first();
        $user = Comment::where('commentable_id', $project->id)->with('user')->get();
      //  $project = Project::find($id);
        //$comments = $project->comments;
        if(count($project) > 0)
            return response()->json([
                'proj' => $project,
                'user' => $user
            ]);

        return response()->json(['error' => 'Project not found'], 404);
    }

    public function adduser(Request $request){

        $this->validate($request, [
           'email' => 'required'
        ]);

        //take a project and add a user to it
      $project = Project::find($request->input('project_id'));
        if(Auth::user()->id == $project->user_id){
        $user = User::where('email', $request->input('email'))->first();
            $projectUser = ProjectUser::where('user_id', $user->id)->where('project_id', $project->id)->first();
            if($user && $project){
              $project->users()->attach($user->id);

          }
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AppModelsProject  $appModelsProject
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
     * @param  \App\AppModelsProject  $appModelsProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project = Project::find($project->id);
        $project->update($request->all());

        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AppModelsProject  $appModelsProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        try {
            Project::destroy($project->id);
            return response([], 204);
        }catch (\Exception $exception){
            return response(['Problem deleting the Project'], 500);
        }
    }

}
