<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklists;
use Auth;
use Illuminate\Support\Facades\Validator;

class ChecklistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $checklists = Checklists::orderBy($orderBy, $direction)->get();

        return response()->json([
            'success' => true,
            'data'    => $checklists
        ], 200);
    }

    public function completed(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $checklists       = Checklists::where('completed', true)->orderBy($orderBy, $direction)->get();

        return response()->json([
            'success' => true,
            'data'    => $checklists
        ], 200);
    }

    public function show($id)
    {
        $checklists = Checklists::find($id);

        if ($checklists) {
            return response()->json([
                'success'    => true,
                'data'      => $checklists
            ], 200);
        }

        return response()->json([
            'success' => false,
            'data' => [
                'message' => 'Task not found'
            ]
        ], 401);
    }

    /**
     * Store method to add/create new checklists list
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'description'          => 'required|max:500',
            'object_domain'          => 'required|max:500',
            'object_id'          => 'required|max:500',
            'urgency'      => 'digits_between:0,2',
            'due'    => 'date_format:H:i'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => $validate->errors()->first()
                ]
            ]);
        }

        if (Checklists::Create($request->all())) {
            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'New Checklists task has been successfully added'
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to add new Checklists task, please try again'
                ]
            ]);
        }
    }

    /**
     * Display form for editing specified checklists record.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $checklists = Checklists::where('id', $id)->get();

        return view('checklists.edit', compact('checklists'));
    }

    /**
     * Update specified checklists records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $checklists = Checklists::find($id);

        if ($checklists) {
            $validate = Validator::make($request->all(), [
                'description'          => 'required|max:500',
                'object_domain'          => 'required|max:500',
                'object_id'          => 'required|max:500',
                'urgency'      => 'digits_between:0,2',
                'due'    => 'date_format:H:i'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'message' => $validate->errors()->first()
                    ]
                ]);
            }

            if ($checklists->fill($request->all())->save()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Checklists task has been updated successfully'
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to update Checklists record, please try again'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => [
                'message' => 'Task not found'
            ]
        ]);
    }

    /**
     * Remove the specified checklists from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checklists = Checklists::findOrFail($id);

        if ($checklists) {
            if (Checklists::destroy($id)) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Selected checklists task has been deleted'
                    ]
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'data' => [
                'message' => 'Task not found'
            ]
        ]);
    }
}
