<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        $customers = $query->paginate(10)->appends($request->query());

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer->update($request->all());

        // Build redirect URL with preserved parameters
        $redirectUrl = route('customers.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Customer $customer)
    {
        $customer->delete();

        // Build redirect URL with preserved parameters
        $redirectUrl = route('customers.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)
            ->with('success', 'Customer deleted successfully.');
    }
}