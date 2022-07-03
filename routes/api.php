<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* //tutti i posts con response json custom
Route::get('posts', function(){
    $posts = Post::paginate(10);   //paginazione 
    return response()->json([
        'status_code' => 200,
        'posts' => $posts,
    ]);
});
 */
//alternativa del comando sopra
Route::get('posts', 'API\PostsController@index');

Route::get('categories', 'API\CategoryController@index');

Route::get('tags', 'API\TagController@index');