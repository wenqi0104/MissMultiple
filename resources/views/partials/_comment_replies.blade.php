
@foreach($comments as $comment)
    <div class="display-comment" >
        <strong>{{ $comment->user->name }}</strong>
        <p>{{ $comment->body }}</p>
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('reply.add') }}" class="form-row aligh-items-center">
            @csrf
            <div class="form-group col-8">
                <input type="text" name="comment_body" class="form-control" required/>
                <input type="hidden" name="material_id" value="{{ $material_id }}" />
                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group col-3">
               <input type="submit" class="btn btn-warning text-right" value="Reply" />
            </div>
        </form>
        @include('partials._comment_replies', ['comments' => $comment->replies])
    </div>
@endforeach