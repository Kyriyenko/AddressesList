<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;

class PostController extends Controller
{
    public function showData(){
            return Models\Record::latest()->paginate(30);
    }

    public  function deleteData($id){
        Models\Record::find($id)->delete();
    }

    public  function addData($name,$email,$address){
       $post = new  Models\Record([
           'name'=>$name,
           'email'=>$email,
           'address'=>$address,
       ]);

       $post->save();
    }


    public function editData($id,$name,$email,$address){
        $post = Models\Record::find($id);
        $post->name=$name;
        $post->email=$email;
        $post->address=$address;

        $post->save();

    }
}
