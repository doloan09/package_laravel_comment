<?php

namespace Doloan09\Comments;

use App\Models\Article;
use App\Models\User;
use Doloan09\Comments\Notifications\LikeCmtNotify;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class LikeController extends Controller
{
    /**
     * Creates a new comment for given model.
     */
    public function LikeClass(){
        $likeClass = Config::get('likes.model'); //  \Doloan09\Comments\Likes::class,
        $like = new $likeClass;
        return $like;
    }

    public function store(Request $request)
    {
        $like = $this->LikeClass();

        $check = $like::select("liker_id")->where('liker_id', $request->liker_id)->where('liketable_id', $request->liketable_id)->first();
        if (!$check) {
            $like->liker_id = $request->liker_id;
            $like->liker_type = $request->liker_type;
            $like->liketable_id = $request->liketable_id;
            $like->save();

            // notifincation
            $userLike = User::where('id', $request->liker_id)->first();
            $info = Comment::where('id', $request->liketable_id)->select('commenter_id', 'commentable_id')->first(); // lay ra id user cua chu comment

            $slug_article = Article::where('id', $info['commentable_id'])->first();
            if ($request->liker_id != $info['commenter_id']) {
                $user = User::where('id', $info['commenter_id'])->first(); // notifiable_id: id cua nguoi nhan thong bao -> chu comment
                Notification::send($user, new LikeCmtNotify($userLike, $slug_article['slug'])); // Auth::user() -> data: thong tin nguoi like comment
            }
        }
        return $like;
    }

    // kiem tra xem user dang login co like comment nay khong
    public function getLike($id_comment, $id_user){
        $like = $this->LikeClass();

        $check = $like::select("liker_id")->where('liker_id', $id_user)->where('liketable_id', $id_comment)->first();
        if ($check){
            return response()->json(['status' => 'true']);
        }
        return response()->json(['status' => 'false']);
    }

    // tra ve tong so like cua 1 comment
    public function getSumLike($id_comment){
        $like = $this->LikeClass();

        $sum_like = $like::where('liketable_id', $id_comment)->count();
        return response()->json(['data' => $sum_like]);
    }

    // tra ve danh sach user like comment
    public function getListLiker($id_comment){
        $like = $this->LikeClass();

        $list_liker = $like::join('users', 'users.id', '=', 'likes.liker_id')->select('users.name', 'users.email')->where('liketable_id', $id_comment)->get();

        return response()->json(['data' => $list_liker]);
    }
    /**
     * Deletes a comment.
     */
    public function destroy($id_comment, Request $request)
    {
        $like = $this->LikeClass();

        $check = $like::select("liker_id")->where('liker_id', $request->liker_id)->where('liketable_id', $id_comment)->first();
        if ($check){
                $delete_like = $like::select("liker_id")->where('liker_id', $request->liker_id)->where('liketable_id', $id_comment);
            if (Config::get('likes.soft_deletes') == true) {
                $delete_like->delete();
            } else {
                $delete_like->forceDelete();
            }
        }
    }
}
