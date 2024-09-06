<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Agenda;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AgendaResource;
use Illuminate\Http\JsonResponse;
   
class AgendaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $agendas = Agenda::all();
    
        return $this->sendResponse(AgendaResource::collection($agendas), 'agendas retrieved successfully.');
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
   
        $agenda = Agenda::create($input);
   
        return $this->sendResponse(new AgendaResource($agenda), 'Agenda created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $agenda = Agenda::find($id);
  
        if (is_null($agenda)) {
            return $this->sendError('Agenda not found.');
        }
   
        return $this->sendResponse(new AgendaResource($agenda), 'Agenda retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agenda $agenda): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $agenda->title = $input['title'];
        $agenda->desc = $input['desc'];
        $agenda->save();
   
        return $this->sendResponse(new AgendaResource($agenda), 'Agenda updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agenda $agenda): JsonResponse
    {
        $agenda->delete();
   
        return $this->sendResponse([], 'Agenda deleted successfully.');
    }
}