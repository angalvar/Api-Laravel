<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return $this->sendResponse(ClientResource::collection($clients), 'Clients consulted successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identification' => 'required|unique:clients|max:25',
            'name' => 'required|max:300',
            'status' => 'required|max:1'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } else {
            $client = Client::create($request->all());
            return $this->sendResponse(new ClientResource($client), 'Client created successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        if (! empty($client)) {
            return $this->sendResponse(new ClientResource($client), 'Client found.');
        } else {
            return $this->sendError('Client not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if (!empty($client)) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'identification' => 'required|max:25',
                'name' => 'required|max:300',
                'status' => 'required|max:1'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            } else {
                $client->identification = $input['identification'];
                $client->name = $input['name'];
                $client->status = $input['status'];
                $client->save();
                return $this->sendResponse(new ClientResource($client), 'Client updated successfully.');
            }
        }else {
            return $this->sendError('Client not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if (! empty($client)) {
            $client->delete();
            return $this->sendResponse([], 'Client deleted successfully.');
        } else {
            return $this->sendError('Client not found.');
        }
    }
}
