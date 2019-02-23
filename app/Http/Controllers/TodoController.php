<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $todo       = Auth::user()->todo()->orderBy($orderBy, $direction)->get();

        return response()->json([
            'success' => true,
            'data'    => $todo
        ], 200);
    }

    public function completed(Request $request)
    {
        $orderBy    = (!empty($request->get('order_by'))) ? $request->get('order_by') : 'created_at';
        $direction  = (!empty($request->get('direction'))) ? $request->get('direction') : 'DESC';
        $todo       = Auth::user()->todo()->where('completed', true)->orderBy($orderBy, $direction)->get();

        return response()->json([
            'success' => true,
            'data'    => $todo
        ], 200);
    }

    public function show($id)
    {
        $todo = Auth::user()->todo()->find($id);

        if ($todo) {
            return response()->json([
                'success'    => true,
                'data'      => $todo
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
     * Store method to add/create new todo list
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'          => 'required|max:500',
            'priority'      => 'digits_between:0,2',
            'location'      => 'max:273',
            'start_time'    => 'date_format:H:i'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => $validate->errors()->first()
                ]
            ]);
        }

        if (Auth::user()->todo()->Create($request->all())) {
            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'New Todo task has been successfully added'
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to add new Todo task, please try again'
                ]
            ]);
        }
    }

    /**
     * Display form for editing specified todo record.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::where('id', $id)->get();

        return view('todo.edit', compact('todo'));
    }

    /**
     * Update specified todo records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Auth::user()->todo()->find($id);

        if ($todo) {
            $validate = Validator::make($request->all(), [
                'name'          => 'filled|max:500',
                'priority'      => 'filled|digits_between:0,2',
                'location'      => 'filled|max:273',
                'start_time'    => 'filled|date_format:H:i'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'message' => $validate->errors()->first()
                    ]
                ]);
            }

            if ($todo->fill($request->all())->save()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Todo task has been updated successfully'
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'Unable to update Todo record, please try again'
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
     * Remove the specified todo from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Auth::user()->todo()->findOrFail($id);

        if ($todo) {
            if (Todo::destroy($id)) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'message' => 'Selected todo task has been deleted'
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
