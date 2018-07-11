@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Post
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) !!}

                        @include('posts.fields')

                   {!! Form::close() !!}

                   {!! Form::model($tag, ['route' => ['tags.store', $tag->id], 'method' => 'patch']) !!}
                  <div class="form-group col-sm-12">
                      {!! Form::label('content', 'тег') !!}
                      {!! Form::textarea('name', null, ['class' => 'form-control']) !!}
                      {!! Form::submit('tag Сақтау', ['class' => 'btn btn-primary']) !!}
                  </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection