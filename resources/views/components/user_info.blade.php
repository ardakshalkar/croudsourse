
<div class="info">
    <div class="time">
        {!! $post->created_at->diffForHumans() !!}
    </div>
    <div class="author">
        <span><a href="#">{{ $post->user->display() }}</a></span>
    </div>
    <div class="role">
        @foreach($post->user->roles as $role)
            <div>{{ $role->name }}</div>
        @endforeach
    </div>
</div>