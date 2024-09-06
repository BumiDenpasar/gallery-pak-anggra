<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Gallery;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\GalleryResource;
use Illuminate\Http\JsonResponse;
   
class GalleryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $gallery = Gallery::all();
    
        return $this->sendResponse(GalleryResource::collection($gallery), 'galleries retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'img' => 'required',
            'title' => 'required',
            'desc' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $gallery = Gallery::create($input);
   
        return $this->sendResponse(new GalleryResource($gallery), 'Gallery created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $gallery = Gallery::find($id);
  
        if (is_null($gallery)) {
            return $this->sendError('Gallery not found.');
        }
   
        return $this->sendResponse(new GalleryResource($gallery), 'Gallery retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'img' => 'required',
            'title' => 'required',
            'desc' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $gallery->img = $input['img'];
        $gallery->title = $input['title'];
        $gallery->desc = $input['desc'];
        $gallery->save();
   
        return $this->sendResponse(new GalleryResource($gallery), 'Gallery updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        $gallery->delete();
   
        return $this->sendResponse([], 'Gallery deleted successfully.');
    }
}