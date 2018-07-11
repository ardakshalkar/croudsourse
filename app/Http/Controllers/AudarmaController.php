<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use App\Http\Controllers\AppBaseController;

use Flash;
//use App\Models\Tag;
use App\Http\Controllers\Tag;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;

class AudarmaController extends AppBaseController
{
    /** @var  TranslationRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepository = $postRepo;
    }

    /**
     * Display a listing of the Post.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->postRepository->pushCriteria(new RequestCriteria($request));
        $posts = $this->postRepository->all();

        return view('posts.index')
            ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new Post.
     *
     * @return Response
     */
    public function create()
    {
        return view('audarmas.create');
    }

    /**
     * Store a newly created Post in storage.
     *
     * @param CreatePostRequest $request
     *
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        //dump($request->"invisible");
        $input = $request->all();
       // dump($input);
        $ids = explode(", ", $input['invisible']);
       // dump($ids);
        $user = Auth::user();
        $input['user_id'] = $user->id;
        //print_r($input);
        //die();
        $post = $this->postRepository->create($input);

        foreach ($ids as $ii) {
            $tag = Tag::find($ii);
            $post->tags()->save($tag);
            # code...
        }
        $tag = Tag::find(6);
        $post->tags()->save($tag);
        Flash::success('Post saved successfully.');

        //return redirect(route('posts.index'));
       return redirect(route('posts.show',$post->id));
    }

    /**
     * Display the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function sortt($a, $b){
        return ($a[1] <= $b[1]) ? -1 : 1;
    }
    public function show($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }
        $trans = $post->translations;
        //$ar = array_map(null, $a, $b, $c)
        $ids = array();
        $we = array();
        foreach ($trans as $tran) {
            # code...
            $us_roles = $tran->user->roles;
            $weight = 0;
            foreach ($us_roles as $role) {
                $weight += $role->weight;
                # code...
            }
            array_push($ids, $tran);
            array_push($we, $weight);
        }
        $map = array_map(null, $ids, $we);
        usort($map, function($a, $b){
        return ($a[1] <= $b[1]) ? -1 : 1;
        });
        return view('posts.show')->with(['post' => $post,
                                            'map' => $map]);
    }

    /**
     * Show the form for editing the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified Post in storage.
     *
     * @param  int              $id
     * @param UpdatePostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostRequest $request)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        $post = $this->postRepository->update($request->all(), $id);

        Flash::success('Post updated successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified Post from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        $this->postRepository->delete($id);

        Flash::success('Post deleted successfully.');

        return redirect(route('posts.index'));
    }
}
