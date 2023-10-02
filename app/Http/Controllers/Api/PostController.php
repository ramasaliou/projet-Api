<?php

namespace App\Http\Controllers\Api;
use App\Models\Post;
use illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\LogUserRequest;



class PostController extends Controller
{

    public function index(Request $request)
    {
   
    try{
                
    $query =Post::query();
    $perPage= 1;
    $page =$request->input('page',1);  
    $search = $request->input('search');
    
    if($search){
        $query->whereRaw("titre LIKE'%".$search."%'");
    }
    $total = $query->count();

    $result =$query->offset(($page -1) * $perPage)->limit($perPage)
    ->get();
        return response()->json([
            'status-code' =>200,
            'status_message' =>'Les posts a ete recuperer',
            'current_page' =>$page,
            'last-page'=>ceil($total / $perPage),
            'items' =>$result
        ]);
       }catch(Exception $e){
        return response()->json($e);

    }
    }

  public function store(CreatePostRequest $request)
    {



try{ 
    
    $post = new Post();
    
    $post->titre = $request->titre;
    $post->description = $request->description; 
     $post->user_id=auth()->user()->id;
    $post->save();

    return response()->json([
        'status-code' =>200,
        'status_message' =>'Le post a ete modifier',
        'data' =>$post
    ]);

} catch(Exception $e ){ 

    return response()->json($e);
     
    }
}

public function update(EditPostRequest $request,Post $post)
{
try{
    $post -> titre = $request->titre;
    $post -> description = $request->description;
       $post->save();

       return response()->json([
        'status-code' =>200,
        'status_message' =>'Le post a ete ajouter',
        'data' =>$post
    ]);


}catch(Exception $e){
    return response()->json($e);


}
}

 public function delete(Post $post){
    try{
       $post->delete();


    }catch(Exception $e){
        return response()->json($e); 

        return response()->json([
            'status-code' =>200,
            'status_message' =>'Le post a ete supprimer',
            'data' =>$post
        ]);
    
    }
 }
}  