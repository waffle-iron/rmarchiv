<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(){
        $cats = \DB::table('board_cats')
            ->orderBy('order')
            ->get();

        $threads = array();

        foreach ($cats as $cat){
            $thr = \DB::table('board_threads')
                ->leftJoin('users as usercreate', 'board_threads.user_id', '=', 'usercreate.id')
                ->leftJoin('users as userlast', 'board_threads.last_user_id', '=', 'userlast.id')
                ->select([
                    'board_threads.id as threadid',
                    'board_threads.title as threadtitle',
                    'usercreate.id as usercreateid',
                    'usercreate.name as usercreatename',
                    'userlast.id as userlastid',
                    'userlast.name as userlastname',
                    'board_threads.created_at as threaddate',
                    'board_threads.last_created_at as lastdate',
                ])
                ->selectRaw('(SELECT COUNT(*) FROM board_posts WHERE board_posts.thread_id = board_threads.id) as posts')
                ->where('board_threads.cat_id', '=', $cat->id)
                ->orderBy('board_threads.last_created_at', 'desc')
                ->orderBy('board_threads.id', 'desc')
                ->limit(10)
                ->get();

            $threads[$cat->id] = $thr;
        }

        return view('board.index', [
            'cats' => $cats,
            'threads' => $threads,
        ]);
    }

    public function show_cat($catid){

    }

    public function create_cat(){

        $cats = \DB::table('board_cats')
            ->select([
                'id as catid',
                'title as cattitle',
                'order as catorder',
                'created_at as catdate',
            ])
            ->selectRaw('(SELECT COUNT(id) FROM board_threads WHERE cat_id = board_cats.id) as catthreads')
            ->selectRaw('(SELECT COUNT(id) FROM board_posts WHERE cat_id = board_cats.id) as catposts')
            ->orderBy('board_cats.order')
            ->get();

        return view('board.cats.create', [
            'cats' => $cats,
        ]);
    }

    public function order_cat($catid, $direction){
        if($direction == 'up'){
            \DB::table('board_cats')
                ->where('id', '=', $catid)
                ->increment('order');
        }else{
            \DB::table('board_cats')
                ->where('id', '=', $catid)
                ->decrement('order');
        }

        return redirect()->action('BoardController@create_cat');
    }

    public function store_cat(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'desc' => 'required',
        ]);

        \DB::table('board_cats')->insert([
            'order' => 0,
            'title' => $request->get('name'),
            'desc' => $request->get('desc'),
            'created_at' => \Auth::id(),
        ]);

        return redirect()->action('BoardController@create_cat');
    }

    public function show_thread($threadid){
        return('Test');
    }

    public function create_thread($catid){

    }

    public function store_thread(Request $request){
        $date = Carbon::now();

        $threadid = \DB::table('board_threads')->insertGetId([
            'cat_id' => $request->get('category'),
            'user_id' => \Auth::id(),
            'title' => $request->get('topic'),
            'closed' => 0,
            'pinned' => 0,
            'last_user_id' => \Auth::id(),
            'created_at' => $date,
            'last_created_at' => $date,
        ]);

        \DB::table('board_posts')->insert([
            'cat_id' => $request->get('category'),
            'thread_id' => $threadid,
            'user_id' => \Auth::id(),
            'content_md' => $request->get('message'),
            'content_html' => \Markdown::convertToHtml($request->get('message')),
            'created_at' => $date,
        ]);

        return redirect()->action('BoardController@show_thread', [$threadid]);
    }

    public function store_post($threadid){

    }
}
