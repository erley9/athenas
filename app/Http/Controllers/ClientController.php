<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreCreateClient;
use App\Http\Requests\StoreUpdateClient;
use App\Http\Resources\ClientCollection;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Client::paginate(5);
        $results->setPath('');
        return new ClientCollection($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreateClient $request)
    {
        DB::beginTransaction();

        try {
            $client = Client::create($request->all());
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Successfully',
            'data' => new ClientResource($client)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json([
            'status' => true,
            'message' => 'Successfully',
            'data' => new ClientResource($client)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateClient $request, Client $client)
    {
        DB::beginTransaction();

        try {
            $client->update($request->all());
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Client Updated',
            'data' => new ClientResource($client)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        DB::beginTransaction();

        try {
            $client->delete();
        } catch(Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Client Deleted'
        ], 200);
    }
}
