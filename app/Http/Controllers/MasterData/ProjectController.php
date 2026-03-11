<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Project;
use App\Models\masterData\Customer;



class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('customer');
        
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name_project', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('customer', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
        }
        
        $projects = $query->get();
        $customers = Customer::all();
        return view('projects.index', compact('projects', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('projects.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'name_project' => 'required',
            'customer_id' => 'required',
        ]);
        
        // Verify customer exists manually since MongoDB IDs might not validate correctly with exists rule
        $customer = Customer::find($request->customer_id);
        if (!$customer) {
            return back()->withErrors(['customer_id' => 'The selected customer does not exist.'])->withInput();
        }

        Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $customers = Customer::all();
        return view('projects.edit', compact('project', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name_project' => 'required',
            'customer_id' => 'required',
        ]);
        
        $customer = Customer::find($request->customer_id);
        if (!$customer) {
            return back()->withErrors(['customer_id' => 'The selected customer does not exist.'])->withInput();
        }

        $project->update($request->all());

        $redirectUrl = route('projects.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project)
    {
        $project->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Project deleted successfully.']);
        }

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}