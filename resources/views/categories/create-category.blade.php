@extends('layout')

@section('head')
<!-- Ck Editor -->
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
@endsection

@section('main')
    <!-- main -->
    <main class="container" style="background-color: #fff;">
        <section id="contact-us">
            <h1 style="padding-top: 50px;"> Create New Category!</h1>
            @include('includes.flash-message')
            <!-- Contact Form -->
            <div class="contact-form">
                <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Title -->
                    <label for="title"><span>Name</span></label>
                    <input type="text" id="name" name="name" value="{{old('name')}}" />
                    @error('name')
                    {{--the $attributevalue field is/must be $validationRule--}}
                    <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                    @enderror

                    <!-- Button -->
                    <input type="submit" value="Submit" />
                </form>
            </div>

            <div class="create-categories">
                <a href="{{route('categories.index')}}">Category list <span>&#8594;</span></a>
            </div>
        </section>
    </main>
@endsection

@section('script')
<!-- Ck Editor Script-->
    <script>
        CKEDITOR.replace( 'body' );
    </script>
@endsection

