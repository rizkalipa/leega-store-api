<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::get();
        return $this->sendResponse($types, 'List types.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $data = $request->except('_token');

        $type = Type::create([
            'name' => $data['name']
        ]);

        return $this->sendResponse($type, 'Success create type.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $typeId)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $data = $request->except('_token');

        $type = Type::where('id', $typeId);
        $type->update([
            'name' => $data['name']
        ]);

        return $this->sendResponse($type->first(), 'Success create type.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function delete(Type $type, $typeId)
    {
        Type::where('id', $typeId)->delete();
        return $this->sendResponse([], 'Success delete type.', 200);
    }
}
