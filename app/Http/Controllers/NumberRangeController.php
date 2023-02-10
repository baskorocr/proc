<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumberRange;

class NumberRangeController extends Controller
{
    public function index(Request $request)
    {
        $skip = $request->perpage * ($request->page - 1);
        $number_range = NumberRange::where(function($where) use ($request){
            
                        if (!empty($request->keyword)) {
                            foreach ($request->columns as $index => $column) {
                                if ($index == 0) {
                                    $where->where($column, 'like', '%'.$request->keyword.'%');
                                } else {
                                    $where->orWhere($column, 'like', '%'.$request->keyword.'%');
                                }
                            }
                                
                        }

                    })
                    ->when(!empty($request->sort), function($query) use ($request){
                        $query->orderBy($request->sort, $request->order == 'ascend' ? 'asc' : 'desc');
                    })
                    ->take((int)$request->perpage)
                    ->skip((int)$skip)
                    ->get();

        $total = NumberRange::where(function($where) use ($request){
            
            if (!empty($request->keyword)) {
                foreach ($request->columns as $index => $column) {
                    if ($index == 0) {
                        $where->where($column, 'like', '%'.$request->keyword.'%');
                    } else {
                        $where->orWhere($column, 'like', '%'.$request->keyword.'%');
                    }
                }
                    
            }

        })
        ->count();

        return response()->json([
            'type' => 'success',
            'data' => $number_range,
            'total' => $total
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $number_range = NumberRange::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $number_range
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $number_range = new NumberRange;
        $number_range->doc_year = $request->doc_year;
        $number_range->doc_type = $request->doc_type;
        $number_range->num_low = $request->num_low;
        $number_range->num_high = $request->num_high;
        $number_range->created_by = auth()->user()->full_name;
        //$number_range->changed_by = auth()->user()->full_name;
        $number_range->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data created successfully!'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $number_range = NumberRange::findOrFail($id);
        $number_range->doc_year = $request->doc_year;
        $number_range->doc_type = $request->doc_type;
        $number_range->num_low = $request->num_low;
        $number_range->num_high = $request->num_high;
        //$number_range->created_by = auth()->user()->full_name;
        $number_range->changed_by = auth()->user()->full_name;
        $number_range->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully!'
        ], 201);
    }

    public function destroy($id)
    {
        $number_range = NumberRange::findOrFail($id);
        $number_range->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data deleted Successfully!'
        ], 201);
    }
}
