<?php

// PostController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
      
      $imageName = '/images/'.time().'.'.$request->image->getClientOriginalExtension();
      
      $request->image->move(public_path('images'), $imageName);
      $post = new Post([
        'title' => $request->get('title'),
        'first_name' => $request->get('first_name'),
        'last_name' => $request->get('last_name'),
        'gender' => $request->get('gender'),
        'images' => $imageName,
        'body' => $request->get('body')
      ]);

      $post->save();

      return response()->json([
            'message'   => 'Data successfully added!'
      ]);
    }

    public function index()
    {
      //echo "sdfs"; exit;
      return new PostCollection(Post::all());
    }

    public function edit($id)
    {
      $post = Post::find($id);
      return response()->json($post);
    }

    public function update($id, Request $request)
    {
      if($request->post('image') != "undefined"){
        $imageName = '/images/'.time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);
      }else{
        $imageName = $request->post('photo');
      }
      $post = Post::where('id',$id)->update([
        'title' => $request->get('title'),
        'first_name' => $request->get('first_name'),
        'last_name' => $request->get('last_name'),
        'gender' => $request->get('gender'),
        'images' => $imageName,
        'body' => $request->get('body')
      ]);
      // $post->update($request->all());
      $post = Post::where('id',$id)->first();
      return response()->json([
        'message' => 'successfully updated',
        'data'    => $post
      ]);
    }

    public function delete($id)
    {
      $post = Post::find($id);

      $post->delete();

      return response()->json([
          'data'    => $post,
          'message' => 'successfully deleted'
      ]);
    }
   
}