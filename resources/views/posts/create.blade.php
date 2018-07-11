@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Шығарма
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'posts.store']) !!}

                        @include('posts.fields')

                    {!! Form::close() !!}
                </div>
                    {!! Form::open(['route' => 'tags.store']) !!}
                        <div class="col-lg-4 col-lg-offset-4">

                            <div id="hide" style="margin:0px; padding: 0px; ">
                            </div>
                            <div class="form-group">
                            <input type="text" id="search-input" class="form-control" placeholder="search" onkeyup="up()" onkeydown="down()">
                                
                            </div>
                            <div class="col-lg-12" id="search-results">
                            </div>
                            
                        </div>
                  <div class="form-group col-sm-12">
                      {!! Form::label('content', 'тег') !!}
                      {!! Form::textarea('name', null, ['class' => 'form-control']) !!}
                      {!! Form::submit('tag Сақтау', ['class' => 'btn btn-primary']) !!}
                  </div>
                   {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
