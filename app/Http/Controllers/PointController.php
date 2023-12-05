<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PointController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {

        $point = Point::orderBy('user_fullname', 'asc')
            ->get();

        if (count($point) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'List Point User !',
                'data' => $point
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found !',
                'data' => ''
            ], 400);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_fullname' => 'required|unique:points,user_fullname',
            'user_point' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $point = Point::create([
            'user_fullname' => $request->input('user_fullname'),
            'user_point' => $request->input('user_point')
        ]);

        if ($point) {
            return response()->json([
                'success' => true,
                'message' => 'Data Successfully saved !',
                'data' => $point
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data failed saved !',
                'data' => ''
            ], 400);
        }
    }

    public function show($user_id)
    {
        $point = Point::where('user_id', $user_id)
            ->first();

        if ($point) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Point User !',
                'data' => $point
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found !',
                'data' => ''
            ], 400);
        }
    }

    public function update(Request $request, $user_id)
    {

        $validator = Validator::make($request->all(), [
            'user_fullname' => 'required|unique:points,user_fullname,' . $user_id . ',user_id',
            'user_point' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $point = Point::where('user_id', $user_id)
            ->first();

        $point->update([
            'user_fullname' => $request->input('user_fullname'),
            'user_point' => $request->input('user_point'),
        ]);


        if ($point) {
            return response()->json([
                'success' => true,
                'message' => 'Data Successfully updated !',
                'data' => $point
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data failed updated !',
                'data' => ''
            ], 400);
        }
    }

    public function destroy($user_id)
    {
        $point = Point::where('user_id', $user_id)
            ->first();

            if($point){
                $point->delete();
            }

            if ($point) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Successfully deleted !',
                    'data' => $point
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data failed deleted !',
                    'data' => ''
                ], 400);
            }
    }
}
