<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Storage;

class UserController extends Controller
{
    /**
     * ユーザーの編集画面を表示
     *
     * @param  App\User;
     */
    public function edit(User $user)
    {
        // $this->authorize('update', $user);

        return view('settings.account', compact('user'));
    }

    /**
     * ユーザー情報を編集する
     *
     * @param App\Http\Requests\UserRequest;
     *
     */
    public function update(UserRequest $request, User $user)
    {
        // $this->authorize('update', $user);

        // 画像アップロード
        if(is_uploaded_file($_FILES['thumb']['tmp_name'])){
            $image = $request->file('thumb');
            $path = Storage::disk('s3')->put('/user-thumbnail', $image, 'public');

            if($user->thumbnail) {
                $disk = Storage::disk('s3');
                $disk->delete('/user-thumbnail/' . basename($user->thumbnail));
            }
        }

        // リクエスト取得
        $user->name = $request->name;
        $user->email = $request->email;
        $user->thumbnail = Storage::disk('s3')->url($path);
        $user->save();

        session()->flash('flash_message', 'アカウント情報を編集しました');

        return redirect()->route('books.index');
    }

    /**
     * 退会する
     *
     * @param  App\User;
     *
     */
    public function destroy(User $user)
    {
        // 認可
        // $this->authorize('delete', $book);

        // サムネイル画像削除
        if($user->thumbnail) {
            $disk = Storage::disk('s3');
            $disk->delete('/user-thumbnail/' . basename($user->thumbnail));
        }

        $user->delete();
        session()->flash('flash_message', 'ユーザーを削除しました');

        return redirect()->route('login');
    }

}
