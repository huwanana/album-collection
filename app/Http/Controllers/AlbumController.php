<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
	public function index(){
		return response()->json([
			'status' => 200,
			'albums' => Album::paginate(3)
		], 200);
	}

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
			'cover' => 'required',
			'title' => 'required|string',
			'artist' => 'required|string',
			'date_release' => 'required|date',
			'tracks' => 'required|string',
		]);
		if($validator->fails()){
			return response()->json([
				'status' => 500,
				'errors' => $validator->errors()
			], 500);
		}else{

			$file = $request->file('cover');
			$filename = '/storage/imgs/'.$file->getClientOriginalName();
			Storage::put('/public/imgs/'.$file->getClientOriginalName(), file_get_contents($file));

			Album::create([
				'cover' => $filename,
				'title' => $request->input('title'),
				'artist' => $request->input('artist'),
				'date_release' => $request->input('date_release'),
				'tracks' => $request->input('tracks')
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Album store successfully!'
			], 200);
		}
  }

	public function show(Album $album){
		$data = Album::find($album);
		if($data){
			return response()->json([
				'status' => 200,
				'album' => $album
			], 200);
		}else{
			return response()->json([
				'status' => 404,
				'message' => 'No record found'
			], 404);
		}
	}
  
  public function update(Request $request, int $id)
  {
		$filename = $request->input('cover');
    $validator = Validator::make($request->all(), [
      'cover' => 'required',
      'title' => 'required|string',
      'artist' => 'required|string',
      'date_release' => 'required|date',
      'tracks' => 'required|string',
    ]);

		if($validator->fails()){
			return response()->json([
				'status' => 500,
				'errors' => $validator->errors()
			], 500);
		}else{

			if($request->hasFile('cover')){
				$file = $request->file('cover');
				$filename = '/storage/imgs/'.$file->getClientOriginalName();
				Storage::put('/public/imgs/'.$file->getClientOriginalName(), file_get_contents($file));
			}

			Album::where('id', $id)->update([
				'cover' => $filename,
				'title' => $request->input('title'),
				'artist' => $request->input('artist'),
				'date_release' => $request->input('date_release'),
				'tracks' => $request->input('tracks')
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Updated'
			], 200);
		}
  }
  
  public function destroy(Album $album)
  {
    $album->delete();
		return response()->json('Successfully deleted!');
  }
}
