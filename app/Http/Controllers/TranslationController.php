<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Repositories\TranslationRepository;
use App\Http\Controllers\AppBaseController;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Rating;
use App\Models\User;
use App\Models\Post;
use Flash;
use Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\newCom;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;

class TranslationController extends AppBaseController
{
    /** @var  TranslationRepository */
    private $translationRepository;

    public function __construct(TranslationRepository $translationRepo)
    {
        $this->translationRepository = $translationRepo;
    }

    /**
     * Display a listing of the Translation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->translationRepository->pushCriteria(new RequestCriteria($request));
        $translations = $this->translationRepository->all();

        return view('translations.index')
            ->with('translations', $translations);
    }

    /**
     * Show the form for creating a new Translation.
     *
     * @return Response
     */
    public function create()
    {
        return view('translations.create');
    }

    /**
     * Store a newly created Translation in storage.
     *
     * @param CreateTranslationRequest $request
     *
     * @return Response
     */
    public function store(CreateTranslationRequest $request)
    {
        // $user = User::find(4);
        // $post = Post::find(1);
       // $user->notify(new newCom($post));
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        $translation = $this->translationRepository->create($input);
        //$owner = $translation->post->user;
       // print_r($owner->id);
        //echo "<script>console.log( 'Debug Objects: " . $owner_id . "' );</script>";
        //echo "here";
       // if($owner->id == 4)
        //Notification::send($user, new newCom($translation));
        //$user->notify(new newCom($translation));
        // $user->notify( (new MailMessage)
        //             ->greeting('Hello!')
        //             ->line('Someone translated your post')
        //             ->line('Thank you for using our application!')
        // );
        Flash::success('Translation saved successfully.');

        return redirect(route('translations.index'));
    }

    /**
     * Display the specified Translation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $translation = $this->translationRepository->findWithoutFail($id);

        if (empty($translation)) {
            Flash::error('Translation not found');

            return redirect(route('translations.index'));
        }

        return view('translations.show')->with('translation', $translation);
    }

    /**
     * Show the form for editing the specified Translation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $translation = $this->translationRepository->findWithoutFail($id);

        if (empty($translation)) {
            Flash::error('Translation not found');

            return redirect(route('translations.index'));
        }

        return view('translations.edit')->with('translation', $translation);
    }

    /**
     * Update the specified Translation in storage.
     *
     * @param  int              $id
     * @param UpdateTranslationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTranslationRequest $request)
    {
        $translation = $this->translationRepository->findWithoutFail($id);

        if (empty($translation)) {
            Flash::error('Translation not found');

            return redirect(route('translations.index'));
        }

        $translation = $this->translationRepository->update($request->all(), $id);

        Flash::success('Translation updated successfully.');

        return redirect(route('translations.index'));
    }

    /**
     * Remove the specified Translation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $translation = $this->translationRepository->findWithoutFail($id);

        if (empty($translation)) {
            Flash::error('Translation not found');

            return redirect(route('translations.index'));
        }

        $this->translationRepository->delete($id);

        Flash::success('Translation deleted successfully.');

        return redirect(route('translations.index'));
    }
    // public function vote(Request $request){
    //     //print_r("here");
    //     $data = $request->all();
    //     $tr = Translation::where('id' , $request->tr_id)->get();
    //     if(is_null($tr->rating_id)){
    //         print_r("null");
    //         return response()->json(['success' => true, 'msg' => "null"]);
    //     }
    //     //print_r($tr);
    //     //  $html = view('layouts.partials.cities')->with(compact('cities'))->render();
        
    // return response()->json(['success' => true, 'msg' => "lala"]);
    //     //$translation = $this->translationRepository->findWithoutFail($id);
    // }
    public function vote2(Request $request){
        $data = $request->all();
        $u = Auth::user()->id;
        $tr = Translation::where('id' , $request->tr_id)->get();

    //   $r = $tr[0]->rating;
        if(is_null($tr[0]->rating_id)){
                $rdata['translation_id'] = $request->tr_id;

                if($request["val"] == "minus"){
                $rdata['count'] = -1;
                $rdata['user_ids'] = '-'.$u.'';}
                else if($request["val"] == "plus"){
                $rdata['count'] = 1;
                $rdata['user_ids'] = '+'.$u.'';

                }
                $r = Rating::create($rdata);
                $tr = Translation::where('id', $request->tr_id)->update(array('rating_id' => $r->id));
            
            return response()->json(['success' => 2, 'msg' => $u]);
        }else{
           // 
          //  return response()->json(['success' => true, 'msg' => "in else"]);
            $rr = Rating::where('id', $tr[0]->rating_id)->get();
           // return response()->json(['success' => true ,  'rr' => $rr]);
            $uid = $rr[0]->user_ids;
           // return response()->json(['uid' => $uid]);
            $ids = explode(",", $uid);
           // return response()->json(['ids' => $ids]);
            foreach ($ids as $id) {
                if(abs(intval($id)) == $u){
                    return response()->json(['success' => 2, 'repeat' => true]);
                }
                //code...
            }
                if($request["val"] == "minus"){
                    $c = $rr[0]->count-1;
                    $r = Rating::where('id', $tr[0]->rating_id)->update(array('count' => $rr[0]->count-1, 'user_ids' => $rr[0]->user_ids.',-'.$u));
                    return response()->json(['success' => 1, 'count' => $c]);
                }else if($request["val"] == "plus"){
                    $c = $rr[0]->count+1;
                    $r = Rating::where('id', $tr[0]->rating_id)->update(array('count' => $rr[0]->count+1, 'user_ids' => $rr[0]->user_ids.',+'.$u));

                    return response()->json(['success' => 1, 'count' => $c]);
                }
        }

       //     print_r("asdadsdaull");
        return response()->json(['success' => 2, 'msg' => $tr, 'user_id' => $tr[0]->user_id]);
    }
}
