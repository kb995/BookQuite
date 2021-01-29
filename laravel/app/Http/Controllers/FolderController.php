<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FolderRequest;
use App\Models\Book;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm(Book $book)
    {
        return view('folders.create', compact('book'));
    }

    public function store(Folder $folder, Book $book, Request $request)
    {
        $folder->name = $request->name;
        $folder->user_id = Auth::id();
        $folder->book_id = $book->id;
        $folder->save();

        session()->flash('flash_message', 'フォルダーを作成しました');

        return redirect()->route('books.show', ['book' => $book]);
    }


}