<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemoRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Memo;
use App\Models\Folder;
use App\User;

class MemoController extends Controller
{
    /**
     * メモを保存する
     *
     * @param App\Models\Book
     * @param App\Models\Memo
     * @param App\Http\Requests\MemoRequest;
     *
     */
    public function store(Book $book, Memo $memo, MemoRequest $request)
    {
        $memo->memo = $request->memo;
        $memo->folder = $request->folder;
        $memo->book_id = $book->id;
        $memo->save();

        session()->flash('flash_message', 'メモを追加しました');

        return redirect()->route('books.show', ['book' => $book]);
    }

    /**
     * メモ編集画面を表示する
     *
     * @param App\Models\Book
     * @param App\Models\Memo
     */
    public function edit(Book $book, Memo $memo)
    {
        $this->authorize('update', $book);

        $folders = Folder::where('user_id', Auth::id())->get();

        return view('memos.edit', compact('book', 'memo', 'folders'));
    }

    /**
     * メモを編集する
     *
     * @param App\Http\Requests\MemoRequest
     * @param App\Models\Book
     * @param App\Models\Memo
     */
    public function update(MemoRequest $request, Book $book, Memo $memo)
    {
        $this->authorize('update', $book);

        $memo->memo = $request->memo;
        $memo->folder = $request->folder;
        $memo->save();

        session()->flash('flash_message', 'メモを編集しました');

        return redirect()->route('books.show', ['book' => $book]);
    }

    /**
     * メモを削除する
     *
     * @param App\Models\Book
     * @param App\Models\Memo
     */
    public function destroy(Book $book, Memo $memo)
    {
        $this->authorize('delete', $book);

        $memo->delete();

        session()->flash('flash_message', 'メモを削除しました');

        return redirect()->route('books.show', ['book' => $book]);
    }

}
