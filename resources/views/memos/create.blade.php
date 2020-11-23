<form method="POST" action="{{ route('books.memos.store', ['book' => $book]) }}" class="card p-3 my-3">
    @csrf
    <div class="form-group">
        <label for="memo"></label>
        <textarea class="form-control" id="memo" name="memo" value="{{ old('memo') }}" rows="4" cols="40" placeholder="読書メモ"></textarea>

        <memo-tags-input-component
        :initial-tags='@json($tagNames ?? [])'
        :autocomplete-items='@json($allTagNames ?? [])'
        >
        </memo-tags-input-component>

        <input type="submit" class="btn btn-primary my-4">
    </div>
</form>
