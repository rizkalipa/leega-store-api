<?php

namespace App\Http\Controllers;

use App\Models\SubType;
use Illuminate\Http\Request;

class SubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subTypes = SubType::get();
        return $this->sendResponse($subTypes, 'List sub type products.');
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
        $subType = SubType::create([
            'name' => $data['name']
        ]);

        return $this->sendResponse($subType, 'Success create sub type.', 201);
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
    public function update(Request $request, $subTypeId)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $data = $request->except('_token');

        $type = SubType::where('id', $subTypeId);
        $type->update([
            'name' => $data['name']
        ]);

        return $this->sendResponse($type->first(), 'Success update sub type.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function delete(SubType $subType, $subTypeId)
    {
        SubType::where('id', $subTypeId)->delete();
        return $this->sendResponse([], 'Success delete sub type.');
    }
}
