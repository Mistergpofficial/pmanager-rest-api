<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Project;
use App\Notifications\NotifyProjectOwner;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'url' => 'required',
            'comment' => 'required'
        ]);

        $user = Auth::user();

        Comment::create([
            'body' => $request->input('comment'),
            'url' => $request->input('url'),
            'user_id' => $user->id,
            'commentable_type' => $request->input('commentable_type'),
            'commentable_id' => $request->input('commentable_id'),
        ]);

        $project = Project::find($request->commentable_id);
        User::find($project->user->id)->notify(new NotifyProjectOwner($project));

    }


    
}
