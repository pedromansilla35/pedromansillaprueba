<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
	use App\Models\User;
	use App\Models\Tag;
	use App\Models\RelationTag;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Controllers\Controller;

class TagController extends Controller
{
    function getTags(Request $request){
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
            $posts = Tag::
               orderBy('id')
               ->get();
            return json_encode($posts);
    }
    function createTag(Request $request){
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
                'nombre' => 'required|string|max:255',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }


            $tag = Tag::where('nombre', $request->get('nombre'))->first();
            if(!$tag){
            	$tag = Tag::create([
			  	  'nombre' => $request->get('nombre')
				]);
            }

            $relation = RelationTag::create([
			  	  'id_tag' => $tag->id,
			  	  'id_video' => $request->get('id_video'),
			  	  'id_post' => $request->get('id_post'),
				]);

			echo json_encode($tag);

    }
}
