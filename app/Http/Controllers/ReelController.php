<?php

namespace App\Http\Controllers;

use App\Http\Traits\SecurityTrait;
use App\Models\Reel;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ReelController extends Controller
{
    use SecurityTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->all() == null) {
            return response()->json(Reel::with('comments.user', 'likes.user', 'user')->get(), 200);
        }

        if (isset($request->all()['category']) && !isset($request->all()['governorate'])) {
            return response()->json(Reel::with('comments.user', 'likes.user', 'user')->where('category_id', $request->all()['category'])->get() , 200);
        }

        if (isset($request->all()['governorate']) && !isset($request->all()['category'])) {
            return response()->json(Reel::with('comments.user', 'likes.user', 'user')->where('governorate_id', $request->all()['governorate'])->get(), 200);
        }


        return response()->json(Reel::with('comments.user', 'likes.user', 'user')->where([
            ['category_id', $request->all()['category']],
            ['governorate_id', $request->all()['governorate']]
        ])->get());



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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

//        return response()->json($request->file('reel')->getClientOriginalName(), 200);

        $validator = Validator::make($request->all(), [
            'reel' => ['required','mimes:mp4,ogx,oga,ogv,ogg,webm','max:10240'],
            'description' => 'required',
            'location' => 'required',
            'category_id' => [Rule::exists('categories', 'id'), 'required'],
            'governorate_id' => [Rule::exists('governorates', 'id'), 'required'],

        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }




        $reelFile = $request->file('reel');

        $reelName = rand(0, 200000) . '_' . $request->file('reel')->getClientOriginalName();

        $path = public_path() . '/reels/'. auth()->user()->id;
        $reelFile->move($path, $reelName);
        $fullPath = $path.'/'.$reelName;

        $this->encryptFile($fullPath,'123456', $fullPath.'.enc');




        $reel = Reel::create([
            'reel' => $fullPath,
            'description' => $request->all()['description'],
            'location' => $request->all()['location'],
            'user_id' => auth()->user()->id,
            'category_id' => $request->all()['category_id'],
            'governorate_id' => $request->all()['governorate_id'],

        ]);
        return response()->json($reel, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function show(Reel $reel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function edit(Reel $reel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reel $reel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reel $reel)
    {
        //
    }

    public function decVideo(Request $request)
    {
        $fullPath = $request->all()['fullPath'];
        $array = explode('/', $fullPath);
        $decPath = public_path('decVideos/') . end($array);
        $this->decryptFile($fullPath.'.enc', '123456', $decPath);
        return response()->json(['message' => 'Video decrypted successfully in '. $decPath], 200);
    }

}
