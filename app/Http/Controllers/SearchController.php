<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class SearchController extends AppBaseController
{
	public function executeSearch(){
		$keywords = Input::get('keywords');
		$tags = Tag::all();
		$searchTags = new \Illuminate\Database\Eloquent\Collection();
		foreach ($tags as $t) {
			if(Str::contains(Str::lower($t->name), Str::lower($keywords)))
				$searchTags->add($t);
			# code...
		}
		return View::make('searchedTags')->with('searchedTags', $searchedTags);
	}
}
