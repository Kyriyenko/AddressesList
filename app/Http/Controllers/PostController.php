<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Models;

class PostController extends Controller
{
    public function showData(){
            return Record::latest()->paginate(30);
    }

    public  function deleteData($id){
        Record::find($id)->delete();

        $params = [
            'success' => 'true',
            'message' => 'data was deleted',

        ];
        response()->json($params, 200)->send();
    }

    public  function addData(Request $request){
       $post = new  Record([
           'name'=>$request->name,
           'email'=>$request->email,
           'address'=>$request->address
       ]);

       $post->save();

        $params = [
            'success' => 'true',
            'message' => 'data has been added',
            'record'=> $post->toArray()
        ];
        response()->json($params, 200)->send();

    }


    public function editData(Request $request){
        $post = Record::find($request->id);
        $post->name='dmitriy';
        $post->email='lirienko';
        $post->address='asdasdsa';

        $post->save();

        $params = [
            'success' => 'true',
            'message' => 'data updated',
            'record'=> $post->toArray()
        ];
        response()->json($params, 200)->send();

    }
}
