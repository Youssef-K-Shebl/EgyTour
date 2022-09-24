<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommentController extends Controller
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
            'reel_id' => ['required', Rule::exists('reels', 'id')],
            'content' => ['required', 'max:10000']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }



        $comment = Comment::create([
            'content' => $request->all()['content'],
            'user_id' => auth()->user()->id,
            'reel_id' => $request->all()['reel_id'],
        ]);

        return response()->json($comment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = Validator::make(array('id' => $id), [
            'id' => ['required','numeric', Rule::exists('comments', 'id')]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $comment = Comment::destroy($id);

        if (!$comment) {
            return response()->json(['message' => 'can not delete comment'], 404);
        }

        return response()->json(['message' => 'comment deleted successfully'], 200);

    }
}
