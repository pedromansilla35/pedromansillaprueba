<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
	use App\Models\User;
	use App\Models\Tag;
	use App\Models\Video;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Controllers\Controller;


class VideoController extends Controller
{
    function getVideos(Request $request){
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
            $videos = Video::where('id_user', $user->id)
               ->orderBy('id')
               ->get();
               foreach ($videos as $video) {
               		$video->tags = Tag::where('relation_tag.id_video', $video->id)
							        ->join('relation_tag', 'relation_tag.id_tag', '=', 'tag.id')
							        ->select('tag.*')
							        ->get();
               }
            return json_encode($videos);
    }
    function createVideo(Request $request){
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
                'nombre' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $Video = Video::create([
			    'nombre' => $request->get('nombre'),
			    'id_user' => $user->id,
			]);

			echo json_encode($Video);

    }
}
