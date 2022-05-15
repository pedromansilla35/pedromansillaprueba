<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
	use App\Models\User;
	use App\Models\Post;
	use App\Models\Tag;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Controllers\Controller;

class PostController extends Controller
{

	
	public function __construct()
    {
    	
        
    }


    function getPosts(Request $request){
            //var_dump($user->id);
    	try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }
            $posts = Post::where('id_user', $user->id)
               ->orderBy('id')
               ->get();
               foreach ($posts as $post) {
               		$post->tags = Tag::where('relation_tag.id_post', $post->id)
							        ->join('relation_tag', 'relation_tag.id_tag', '=', 'tag.id')
							        ->select('tag.*')
							        ->get();
               }
            return json_encode($posts);
    }
    function createPost(Request $request){
    	try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }

            $validator = Validator::make($request->all(), [
                'titulo' => 'required|string|max:255',
                'cuerpo' => 'required|string'
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $post = Post::create([
			    'titulo' => $request->get('titulo'),
			    'cuerpo' => $request->get('cuerpo'),
			    'id_user' => $user->id,
			]);

			echo json_encode($post);

    }
}
