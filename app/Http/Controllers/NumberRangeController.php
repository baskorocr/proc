<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumberRange;

class NumberRangeController extends Controller
{
    public function index(Request $request)
    {
       return view('regis_user.number-range.index');
    } 

    public function getNumberRange(Request $request)
    {
       $data = NumberRange::get();

        return \DataTables::of($data)
             ->editColumn('last_changed_by', function ($data) {
              return @$data->users->nm_user;
                
            })
            ->editColumn('action', function ($data) {
                return  view('regis_user/number-range/buttons')->with(['data' => $data]);
            })
            ->editColumn('last_changed', function ($data) {                    
                return date('d.m.Y H:i:s',strtotime($data->last_changed));
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function show(Request $request, $id)
    {
        $number_range = NumberRange::findOrFail($id);

        return response()->json([
            'type' => 'success',
            'data' =>  $number_range
        ]);
    }

    public function editNumber(Request $request, $id)
    {
         $data['number'] = NumberRange::findOrFail($id);
         return view('regis_user.number-range.edit')->with($data);
    }

    public function numberAdd(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'full_name' => 'required|string',
        // ]);

        $number_range = new NumberRange;
        $number_range->doc_year = $request->doc_year;
        $number_range->doc_type = strtolower($request->doc_type);
        $number_range->num_low = $request->num_low;
        $number_range->num_high = $request->num_high;
        $number_range->current_num = 0;
        $number_range->last_changed = now();
        $number_range->last_changed_by = auth()->user()->id_user;
        //$number_range->changed_by = auth()->user()->id_user;
        $number_range->save();

        return redirect()->route('regis-user.number-range')->with(['message_success' => 'Data created Successfully']);
    }

    public function updateNumber(Request $request)
    {
        // $request->validate([
        //     // 'username' => 'required|string|unique:users,username,'.$id.',_id',
        //     //'email' => 'required|string',
        //     // 'id_user' => 'required|string',
        // ]);

        $number_range = NumberRange::findOrFail($request->id);
         $number_range->doc_year = $request->doc_year;
        $number_range->doc_type = $request->doc_type;
        $number_range->num_low = $request->num_low;
        $number_range->num_high = $request->num_high;
        $number_range->current_num = 0;
        $number_range->last_changed = now();
        $number_range->last_changed_by = auth()->user()->id_user;
        //$number_range->changed_by = auth()->user()->id_user;
        $number_range->save();

        return redirect()->route('regis-user.number-range')->with(['message_success' => 'Data updated Successfully']);
    }

    public function destroy($id)
    {
        $number_range = NumberRange::findOrFail($id);
        $number_range->delete();

       return redirect()->route('regis-user.number-range')->with(['message_success' => 'Data deleted Successfully']);
    }
}
