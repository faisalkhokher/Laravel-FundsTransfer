<?php

namespace App\Http\Controllers\Api\Project;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::with('images','project_rating','project_return','project_str','project_type')->get();
        
        $response = ([
            'success' => true,
            'data' => $project,
            ]);
    
        return response()->json($response, 200);
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
    public function store(Request $request)
    {
       
        $uploaded_files = [];
        $projectSave = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'type_id' => $request->type_id,
            'str_id' => $request->str_id,
            'return_id' => $request->return_id,
            'rating_id' => $request->rating_id,
        ]);

        $pro = Project::where('id' , $projectSave->id)->with('project_rating','project_return','project_str','project_type')->get();
        


        
    //    $input = $request->all();
       if($request->hasfile('path'))
       {
        //  dd($request->file('path'));
         
         foreach($request->path as $file)
          {
              $name = time() . $file->getClientOriginalName();
              $file->move('images/projects', $name);
              $input['path'] = $name;

              // !! Create Files
              $file = new Image();
              $file->path = $input['path'];
              $file->save();
              $uploaded_files[] = $file;
              // !! Pivot
              $projectSave->images()->attach($file->id);
          }

       }

       $response = ([
        'success' => true,
        'data' => $pro,
        'files' => $uploaded_files,
        'message' => "Project Saved Successfully",
        ]);

        return response()->json($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       dd($request->all());
        $uploaded_files = [];
        $project = Project::find($id);
        $project->title = $request->title;
        $project->description = $request->description;
        $project->type_id = $request->type_id;
        $project->str_id = $request->str_id;
        $project->return_id = $request->return_id;
        $project->rating_id = $request->rating_id;
        $project->save();


       if($request->hasfile('path'))
       {
        //  dd($request->file('path'));
         
         foreach($request->path as $file)
          {
              $name = time() . $file->getClientOriginalName();
              $file->move('images/projects', $name);
              $input['path'] = $name;

              // !! Create Files
              $file = new Image();
              $file->path = $input['path'];
              $file->save();
              $uploaded_files[] = $file;
              // !! Pivot
              $project->images()->attach($file->id);

          }

       }

       $response = ([
        'success' => true,
        'data' => $projectSave,
        'files' => $uploaded_files,
        'message' => "Project Saved Successfully",
        ]);

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $project = Project::find($id);
       $project->delete();
       $response = ([
        'success' => true,
        'message' => "Project Deleted",
        ]);

        return response()->json($response, 200);
    }

    public function updateProject(Request $request , $id)
    {
      
        $uploaded_files = [];
        $project = Project::find($id);
        $project->title = $request->title;
        $project->description = $request->description;
        $project->type_id = $request->type_id;
        $project->str_id = $request->str_id;
        $project->return_id = $request->return_id;
        $project->rating_id = $request->rating_id;
        $project->save();


       if($request->hasfile('path'))
       {
        //  dd($request->file('path'));
         
         foreach($request->path as $file)
          {
              $name = time() . $file->getClientOriginalName();
              $file->move('images/projects', $name);
              $input['path'] = $name;

              // !! Create Files
              $file = new Image();
              $file->path = $input['path'];
              $file->save();
              $uploaded_files[] = $file;
              // !! Pivot
              $project->images()->attach($file->id);

          }

       }

       $response = ([
        'success' => true,
        'data' => $project,
        'files' => $uploaded_files,
        'message' => "Project Saved Successfully",
        ]);

        return response()->json($response, 200);
    }
    
}
