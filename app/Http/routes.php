<?php

use App\Post;
use App\User;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
//
//Route::get('/about', function () {
//    return "<h1>About Page</h1>";
//});
//
//Route::get('/contact', function () {
//    return "<h2>Contact Page</h2>";
//});
//
//Route::get('/post/{id}',function($id){
//   return "This is post number ".$id;
//});
//
//Route::get('/post/{id}/{name}',function($id,$name){
//    return "This is post number ".$id." ".$name;
//});
//
//
//Route::get('admin/posts/example',array('as' => 'admin.home',function(){
//    $url = route('admin.home');
//
//    return "This url is ".$url;
//}));

//Route::get('/post/{id}','PostController@index');

//Route::resource('posts','PostController');
//
//Route::get('/contact','PostController@contact');
//
//Route::get('post/{id}/{name}/{password}','PostController@show_post');


//|--------------------------------------------------------------------------
//| DATABASE Raw SQL Queries
//|--------------------------------------------------------------------------

Route::get('/insert',function(){
   DB::insert('insert into posts(title, content) values(?,?)',['Contvertial24 Company','New Startup']);
});

//
//
//Route::get('/read',function(){
//   $results = DB::select('select * from posts where id = ?', [1]);
//
//   foreach ($results as $post){
//       return $post->title;
//   }
//});
//
//Route::get('/update',function(){
//    $updated = DB::update('update posts set title="Update Title" where id=?',[1]);
//
//    return $updated;
//});
//
//Route::get('/delete',function(){
//   $deleted = DB::delete('delete from posts where id = ?', [1]);
//
//   return $deleted;
//});


//|--------------------------------------------------------------------------
//| ELOQUENT
//|--------------------------------------------------------------------------


Route::get('/read',function(){
   $posts = Post::all();

   foreach ($posts as $post){
       return $post->title;
   }
});


Route::get('/find',function(){
    $posts = Post::find(2);

    return $posts->title;
});


Route::get('/findWhere',function(){
    $posts = Post::where('id',3)->orderBy('id','desc')->take(1)->get();

    return $posts;
});

Route::get('/findMore',function(){
   $posts = Post::findOrFail(2);

   return $posts;
});

Route::get('/findCardit',function(){
    //users_count didnt exist you need add this
    $posts = Post::where('users_count', '<', 50)->firstOrFail();

    return $posts;
});

Route::get('/basicinsert',function(){
   $post = new Post;

   $post->title = 'New Eloquent title insert';
   $post->content = 'New Content';

   $post->save();
});


Route::get('/basicupdate',function(){
    $post = Post::find(4);

    $post->title = 'update Eloquent title insert';
    $post->content = 'update Content';

    $post->save();
});


Route::get('/createEQU',function(){
   Post::create(['title'=>'create new title', 'content'=>'This is a new content\'s']);
});

Route::get('/updateEQU',function(){
    Post::where('id',5)->where('is_admin',0)->update(['title'=>'update title', 'content'=>'Update content']);
});

Route::get('/deleteEQU',function(){
   $post = Post::find(5);
   $post->delete();

   //destory method to delete many raw's
    //you can delete by query ask where is admin and then delete
});


Route::get('/softDelete',function(){
    Post::find(7)->delete();
});

Route::get('/readSoftDelete',function(){
//    $post = Post::find(6);
//
//    return $post;

//    $post = Post::withTrashed()->where('id',6)->get();
//
//    return $post;

    $post = Post::onlyTrashed()->where('is_admin',0)->get();

    return $post;
});


Route::get('/restore',function(){
    $post = Post::withTrashed()->where('is_admin',0)->restore();

    return $post;
});


Route::get('/forcedelete',function(){
    $post = Post::onlyTrashed()->where('is_admin',0)->forceDelete();

    return $post;
});


//|--------------------------------------------------------------------------
//| ELOQUENT Relationships
//|--------------------------------------------------------------------------

/////////////////////////
//One to One Relationship
/////////////////////////

Route::get('/user/{id}/post',function($id){
    return User::find($id)->post->title;
    //return User::find($id)->post;

});

Route::get('/post/{id}/user',function($id){
    return Post::find($id)->user->name;
    //return Post::find($id)->user;

});

/////////////////////////
//One to Many Relationship
/////////////////////////
Route::get('/posts',function(){
    $user = User::find(1);

    foreach ($user->posts as $post){
        echo $post->title.'<br>';
    }
});


/////////////////////////
//Many to Many Relationship
/////////////////////////
Route::get('/user/{id}/role',function($id){
    $user = User::find($id);

    foreach ($user->roles as $role){
        echo $role->name;
    }
});