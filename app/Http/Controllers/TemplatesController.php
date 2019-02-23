<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Templates;
use Auth;
use Illuminate\Support\Facades\Validator;

class TemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $templates       = Templates::orderBy($orderBy, $direction)->get();

        return response()->json([
            'success' => true,
            'data'    => $templates
        ], 200);
    }

    public function completed(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $templates       = Templates::where('completed', true)->orderBy($orderBy, $direction)->get();

        return response()->json([
            'success' => true,
            'data'    => $templates
        ], 200);
    }

    public function show($id)
    {
        $templates = Templates::find($id);

        if ($templates) {
            return response()->json([
                'success'    => true,
                'data'      => $templates
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
     * Store method to add/create new templates list
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'          => 'required|max:500',
            'checklist'      => 'required',
            'items'    => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => $validate->errors()->first()
                ]
            ]);
        }

        if (Templates::Create($request->all())) {
            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'New Templates task has been successfully added'
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to add new Templates task, please try again'
                ]
            ]);
        }
    }

    /**
     * Display form for editing specified templates record.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $templates = Templates::where('id', $id)->get();

        return view('templates.edit', compact('templates'));
    }

    /**
     * Update specified templates records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $templates = Templates::find($id);

        if ($templates) {
            $validate = Validator::make($request->all(), [
                'name'          => 'required|max:500',
                'checklist'      => 'required',
                'items'    => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'message' => $validate->errors()->first()
                    ]
                ]);
            }

            if ($templates->fill($request->all())->save()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Templates task has been updated successfully'
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to update Templates record, please try again'
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
     * Remove the specified templates from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $templates = Templates::findOrFail($id);

        if ($templates) {
            if (Templates::destroy($id)) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Selected templates task has been deleted'
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
