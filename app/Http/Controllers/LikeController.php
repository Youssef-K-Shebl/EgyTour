<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reel_id' => ['required', Rule::exists('reels', 'id'), Rule::unique('likes','reel_id')->where('user_id', auth()->user()->id)],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }



        $like = Like::create([
            'user_id' => auth()->user()->id,
            'reel_id' => $request->all()['reel_id'],
        ]);

        return response()->json($like, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = Validator::make(array('id' => $id), [
            'id' => ['required','numeric', Rule::exists('likes', 'id')]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $like = Like::destroy($id);

        if (!$like) {
            return response()->json(['message' => 'can not delete like'], 404);
        }

        return response()->json(['message' => 'like deleted successfully'], 200);
    }
}
