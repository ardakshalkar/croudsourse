<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TagRepository;
//use App\Models\Tag; 
use App\Http\Controllers\Tag;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    //
    // private $tagRepository;

    // public function __construct(TagRepository $tagRepo);
    // {
    // 	$this->tagRepository = $tagRepo;
    
    public function store(Request $request)
    {
        $input = $request->all();
        $tag= new Tag;
		$tag->fill($input);
		$tag->save();
        Flash::success('Tag saved successfully.');
		return redirect('posts/create');
        // $user = Auth::user();
        // $input['user_id'] = $user->id;
        // //print_r($input);
        // //die();
        // $post = $this->postRepository->create($input);

        // Flash::success('Post saved successfully.');

        // //return redirect(route('posts.index'));
        // return redirect(route('posts.show',$post->id));
    }
}
