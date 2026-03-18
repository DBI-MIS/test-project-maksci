<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TypeController extends Controller
{
    
     public function index(){
        $types = Type::get();
        return Inertia::render('Type/Index', ['types' => $types]);
    }


    public function created()
    {
        return Inertia::render('Type/Created');
    }

    public function store()
    {
        $data = request()->validate([
            'type' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        Type::create($data);
        return to_route('type.index');
    }

    public function edit(Type $type)
    {
        return Inertia:: render('Type/Edit', ['type' => $type]);
    }
    public function update(Type $type){

        $data = request()->validate([
            'type' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        $type->update($data);
        return to_route('type.index');
    }

    public function destroy(Type $type) {
        $type->delete();
        return to_route('type.index');
    }



}
