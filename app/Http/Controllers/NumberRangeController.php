<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumberRange;

class NumberRangeController extends Controller
{

    public function editNumber($id)
    {
        $data = NumberRange::findOrFail($id);
        return view('regis_user/number-range/edit')->with(['number' => $data]);
    } 

    public function getNumberRange()
    {
        $data = NumberRange::all();
        return view('regis_user/number-range/index')->with(['number' => $data]);
    }

    public function getDataNumberRange()
    {
        $data = NumberRange::get();

        return \DataTables::of($data)
            ->editColumn('uom', function ($data) {
                if (@$data->uom === "D") {
                    return "Days";
                } else {

                    return 'Months';
                }
            })
            ->editColumn('cr_by', function ($data) {
                return @$data->users->nm_user;
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/number-range/buttons')->with(['data' => $data]);
            })
            ->editColumn('number', function ($data) {
                return 1;
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d/m/Y',strtotime($data->last_changed));
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }


    public function index(Request $request){
        $skip = $request->perpage * ($request->page - 1);
        $index = NumberRange::when(!empty($request->order_by), function($query) use ($request){
            foreach($request->order_by as $order_by) {
                $json = json_decode($order_by);
                $query->orderBy($json->field, $json->order === 'ascend' ? 'asc' : 'desc');
            }
        })
        ->where(function($query) use ($request){
            if (!empty($request->search)) {
                foreach ($request->search as $search) {
                    $json = json_decode($search);
                    $query->where($json->columns, 'like', '%'.$json->searchText.'%');
                    $query->where($json->columns, 'like', '%'.$json->searchText.'%');
                }
            }
        })
        ->where(function($where) use ($request){
            if (!empty($request->keyword)) {
                foreach ($request->columns as $index => $column) {
                    if ($index == 0) {
                        $where->where($column, 'like', '%'.$request->keyword.'%');
                    } else {
                        $where->orWhere($column, 'like', '%'.$request->keyword.'%');
                    }
                }
            }
        });

        $number_range = (clone $index)->take((int)$request->perpage)
            ->skip((int)$skip)
            ->get();

        $total = (clone $index)->count();

        return response()->json([
            'type' => 'success',
            'data' => $number_range,
            'total' => $total
        ], 200);

    }

    public function store(Request $request){
        $number_range = new NumberRange;
        $number_range->doc_type = $request->doc_type;
        $number_range->doc_year = $request->doc_year;
        $number_range->num_low = $request->num_low;
        $number_range->num_high = $request->num_high;
        $number_range->current_num = $request->current_num;
        $number_range->created_by = auth()->user()->full_name;
        $number_range->save();

        return response()->json([
            'message' => 'data created has been successfully',
            'type' => 'success'
        ], 201);
    }

    public function show($id){
        $number_range = NumberRange::find($id);
        return response()->json([
            'type' => 'success',
            'data' => $number_range
        ], 200);
    }

    public function updateNumber(Request $request){
        
        $number_range = NumberRange::find($request->id);
        // dd($number_range, $request);
        $number_range->doc_type = $request->doc_type;
        $number_range->doc_year = $request->doc_year;
        $number_range->num_low = $request->num_low;
        $number_range->num_high = $request->num_high;
        $number_range->role = $request->role;
        $number_range->save();

        return redirect()->route('regis-user.number-range')->with(['message_success' => 'Berhasil mengubah data.']);
    }

    public function deleteNumber($id){
        $number_range = NumberRange::find($id);
        $number_range->delete();

        return redirect()->route('regis-user.number-range')->with(['message_success' => 'Berhasil menghapus data.']);
    }
}