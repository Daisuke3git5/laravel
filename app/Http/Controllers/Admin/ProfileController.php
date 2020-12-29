<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

//編集履歴の実装の追記内容
use App\ProfileHistory;

use Carbon\Carbon;

class ProfileController extends Controller
{
    //以下を追記
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        //Varidationを行う
        $this->validate($request, Profile::$rules);
        $profile = new Profile;
        $form = $request->all();
        
        //フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        //データベースに保存する
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if (cond_title != '') {
            $posts = Profile::where('title', $cond_title)->get();
        } else {
            $profile = Profile::all();
        }
        return view('admin.profile.index', ['posts'=>$posts, 'cond_title' => $cond_title]);
    }
    
    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if(empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
        //Validationをかける
        $this->validate($request, Profile::$rules);
        //送信されてきたフォームデータを格納する
        $profile = Profile::find($request->id);
        $profile_form = $request->all();
        
        unset($profile_form['_token']);
        //該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();
        
        //編集履歴の実装の追記内容
        $profilehistory = new ProfileHistory;
        $profilehistory->profile_id = $profile->id;
        $profilehistory->edited_at = Carbon::now();
        $profilehistory->save();
        
        return redirect('admin/profile/create');
    }
    
    public function delete(Request $request)
    {
        //該当するProfile Modelを取得
        $profile = Profile::find($request->id);
        //削除する
        $profile->delete();
        return redirect('admin/profile/');
    }
}
