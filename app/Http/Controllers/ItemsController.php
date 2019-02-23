<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $items       = DB::select("SELECT * FROM items order by created_at desc");

        return response()->json([
            'success' => true,
            'data'    => $items
        ], 200);
    }

    public function completed(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $items       = DB::select("SELECT * FROM items where is_completed = '1' order by created_at desc");

        return response()->json([
            'success' => true,
            'data'    => $items
        ], 200);
    }
    public function incompleted(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $items       = DB::select("SELECT * FROM items where is_completed != '1' order by created_at desc");

        return response()->json([
            'success' => true,
            'data'    => $items
        ], 200);
    }

    public function show($id)
    {
        $items = Auth::user()->items()->find($id);

        if ($items) {
            return response()->json([
                'success'    => true,
                'data'      => $items
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
     * Store method to add/create new items list
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'description'          => 'required|max:500',
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

        $data = $request->all();

        $insert = DB::insert("INSERT into items
            (description, urgency, due) values
            ('".$data['description']."', '".$data['urgency']."', '".$data['due']."')");

        if ($insert) {
            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'New Items task has been successfully added'
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to add new Items task, please try again'
                ]
            ]);
        }
    }

    /**
     * Display form for editing specified items record.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = Items::where('id', $id)->get();

        return view('items.edit', compact('items'));
    }

    /**
     * Update specified items records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $items = Items::find($id);

        if ($items) {
            $validate = Validator::make($request->all(), [
                'description'          => 'required|max:500',
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

            if ($items->fill($request->all())->save()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Items task has been updated successfully'
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to update Items record, please try again'
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
     * Remove the specified items from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Items::findOrFail($id);

        if ($items) {
            if (Items::destroy($id)) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Selected items task has been deleted'
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
