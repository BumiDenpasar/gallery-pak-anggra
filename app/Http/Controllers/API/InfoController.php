<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Info;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\InfoResource;
use Illuminate\Http\JsonResponse;
   
class InfoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $infos = Info::all();
    
        return $this->sendResponse(InfoResource::collection($infos), 'Infos retrieved successfully.');
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
            'title' => 'required',
            'desc' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $info = Info::create($input);
   
        return $this->sendResponse(new InfoResource($info), 'Info created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $info = Info::find($id);
  
        if (is_null($info)) {
            return $this->sendError('Info not found.');
        }
   
        return $this->sendResponse(new InfoResource($info), 'Info retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Info $info): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $info->title = $input['title'];
        $info->desc = $input['desc'];
        $info->save();
   
        return $this->sendResponse(new InfoResource($info), 'Info updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Info $info): JsonResponse
    {
        $info->delete();
   
        return $this->sendResponse([], 'Info deleted successfully.');
    }
}