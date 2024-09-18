<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    function order(Request $request, Builder $query): Builder {
        if ($request['order'] && $request['order'][0]['column'] != '' ) {
            if ($request['order'][0]['name'] == 'name') {
                $query->orderBy('first_name', $request['order'][0]['dir']);
                $query->orderBy('last_name', $request['order'][0]['dir']);
            }

            else {
                $query->orderBy($request['order'][0]['name'], $request['order'][0]['dir']);
            }
        }

        return $query;
    }

    function limit(Request $request, Builder $query): Builder {
        if ($request['length']) {
            $query->limit($request->integer('length'));
        }

        return $query;
    }

    function offset(Request $request, Builder $query): Builder {
        if ($request['start']) {
            $query->offset($request->integer('start'));
        }

        return $query;
    }

    function search(Request $request, Builder $query): Builder {
        if ($request['search'] && $request['search']['value'] != '') {
            $query->where(function($query) use ($request) {

                foreach ($request['columns'] as $index => $column) {
                    if ($column['searchable'] != "true") continue;

                    if ($column['name'] == 'name') {
                        $query->orWhere('first_name', 'like', '%' . $request['search']['value'] . '%');
                        $query->orWhere('last_name', 'like', '%' . $request['search']['value'] . '%');
                        continue;
                    }

                    $query->orWhere($column['name'], 'like', '%' . $request['search']['value'] . '%');
                }
            });
        }

        return $query;
    }

    public function index(Request $request)
    {
        // dd($request->query());

        $employees = Employee::query();
        $employees = $this->order($request, $employees);
        $employees = $this->search($request, $employees);
        $totalCount = $employees->count();
        $employees = $this->limit($request, $employees);
        $employees = $this->offset($request, $employees);
        $employees = $employees->get();

        return response()->json([
                "draw" => $request->integer('draw'),
                "recordsTotal"=> Employee::count(),
                "recordsFiltered"=> $totalCount,
                "data" => EmployeeResource::collection($employees)
        ]);
    }
}
