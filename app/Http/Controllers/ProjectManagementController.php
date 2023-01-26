<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectManagementController extends Controller
{
    public function projectMaster()
    {
        return view('project_management/project_master/index');
    } 

    public function editProject($id)
    {
        $prj = Project::where('id_project',$id)->firstOrFail();
        return view('project_management/project_master/edit')->with(['project' => $prj]);
    }
    public function projectAdd(Request $request)
    {
        $prj = Project::create($this->params($request));
        if($prj)
        {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Berhasil Menambahkan Project',
                    'data' =>  $prj,
                ], 200);

        } 

         return response()->json([
                    'type' => 'error',
                    'message' => 'Gagal Menambahkan Project',
                    'data' =>  null,
                ], 200);
    }
    public function updateProject(Request $request)
    {
        $prj = Project::where('id_project',$request->id_project)->update($this->params($request,true));
        if($prj)
        {
                return redirect()->route('project.management.master')->with(['message_success' => 'Berhasil mengubah data.']);

        } 

         return redirect()->route('project.management.master')->with(['message_fail' => 'Gagal mengubah data.']);
    }
    public function deleteProject($id)
    {
        $prj = Project::where('id_project',$id)->delete();
        if($prj)
        {
                return redirect()->route('project.management.master')->with(['message_success' => 'Berhasil menghapus data.']);

        } 

         return redirect()->route('project.management.master')->with(['message_fail' => 'Gagal menghapus data.']);
    }

    public function getProjectMaster()
    {
        $data = Project::get();

        return \DataTables::of($data)
                ->editColumn('last_change_by', function ($data) {
                                
                               return @$data->users->nm_user;
                            })  
                ->editColumn('modify_date', function ($data) {
                                
                               return date('d.m.y',strtotime($data->modify_date));
                            }) 
                ->editColumn('prod_assc', function ($data) {
                            if ($data->assigned == 'Y'){
                                $assigned = "<small class='badge bg-success'> Assigned</small>";
                            } elseif ($data->assigned == 'N') {
                                $assigned = "<small class='badge bg-warning'> Not-Assigned</small>";
                            }

                            if ($data->status == "A"){
                                $status = "<small class='badge bg-success'> Active</small>";
                            } elseif ($data->status == "N") {
                                $status = "<small class='badge bg-danger'> Non-active</small>";
                            }
 
                               return   $assigned;
                            }) 
                ->editColumn('action', function ($data) {
                                
                               return  view('project_management/project_master/buttons')->with(['data' => $data]);
                            }) 
                ->editColumn('number', function ($data) {
                                
                               return 1;
                            }) 
                ->rawColumns(['prod_assc','action'])
                            ->make(true);
    }

    private function params($request,$update=false)
    {
        $params = [
                    'proj_num' => $request->proj_num,
                    'nm_project' => $request->nm_project,
                    'modify_date' => date('Y-m-d'),
                    'id_user' => auth()->user()->id_user,
                    'status' => "A",
                    'assigned' => "N"
                ];
        if($update)
        {
            $params['id_project'] = $request->id_project;
        }
        return $params;
    }

}
