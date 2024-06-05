<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validazione
        $request->validate(
            [
                'name' => 'required|max:249|unique:projects,name',
                'client_name' => 'required',
                'summary' => 'max:500',
                'cover_image' => 'nullable|image|max:256',
                'type_id' => 'nullable|exists:types,id'
            ]
        );

        $formData = $request->all();
        if ($request->hasFile('cover_image')) {
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            $formData['cover_image'] = $img_path;
        }
        // dd($formData);
        $newProject = new Project();
        $newProject['slug'] = Str::slug($formData['name'], '-');
        $newProject->fill($formData);
        // $newProject->slug = Str::slug($newProject->name, '-');
        $newProject->save();

        session()->flash('message', 'Project successfully created.');
        return redirect()->route('admin.projects.show', ['project' => $newProject->slug]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * Project $project è la dependence injection ed è l'equivalente del findOrFail ma migliorato
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // validazione
        $request->validate(
            [
                'name' => [
                    'required',
                    'max:249',
                    Rule::unique('projects')->ignore($project->id)
                ],
                'client_name' => 'required',
                'summary' => 'max:500',
                'cover_image' => 'nullable|image|max:256'
            ]
        );
        $formData = $request->all();
        if ($request->hasFile('cover_image')) {
            if($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            $formData['cover_image'] = $img_path;
        }
        $project['slug'] = Str::slug($formData['name'], '-');
        $project->update($formData);
        session()->flash('message', 'Project successfully updated.');
        return redirect()->route('admin.projects.show', ['project' => $project->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // dd('oh mannaggia fai attenzione!');
        $project->delete();
        session()->flash('message', 'Project successfully deleted.');
        return redirect()->route('admin.projects.index');
    }
}
