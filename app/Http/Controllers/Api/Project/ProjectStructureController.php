<?php

namespace App\Http\Controllers\Api\Project;

use Illuminate\Http\Request;
use App\Models\ProjectStructure;
use App\Http\Controllers\Controller;

class ProjectStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = ProjectStructure::all();
        
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
        $input = $request->all();
        $project = ProjectStructure::create($input);

        $response = ([
            'success' => true,
            'data' => $project,
            'message' => "saved"
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
        $input = $request->all();
        $project = ProjectStructure::findOrFail($id);

        $project->update($input);

        $response = ([
            'success' => true,
            'data' => $project,
            'message' => "Updated"
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
        $project = ProjectStructure::findOrFail($id);
        $project->delete();

        $response = ([
            'success' => true,
            'message' => "Delete"
            ]);
    
        return response()->json($response, 200);
    }
}
