<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;

class PostController extends Controller
{
    public function showData(){
            return Models\Post::latest()->paginate(30);
    }

    public  function deleteData($id){
        Models\Post::find($id)->delete();
    }

    public  function addData($title,$desc){
       $post = new  Models\Post([
           'title'=>$title,
           'description'=>$desc
       ]);

       $post->save();
    }


    public function editData($id,$title,$des){
        $post = Models\Post::find($id);
        $post->title=$title;
        $post->description=$des;

        $post->save();

    }
}
