@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content bookmark">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <div class="col-xl-9 col-md-8">
                    @if($subscribers)
                        <div class="pro-head p-0 pb-2">
                            <h3 class="mb-0">Subscriber Update</h3>
                        </div>
                        <div>
                            <div class="row">
                                <div>
                                    <form class="form" id="submit-form" method="post"
                                          action="{{route('frontend.dashboard.subscribers.update')}}">
                                        @csrf
                                        <div class="form-group">
                                            <span class="span-dvidder">Name</span>
                                            <input type="text" name="name" value="{{$subscribers->name}}"
                                                   class="form-control">
                                        </div>

                                        <!--  CONTENT START  -->
                                        <div class="form-group">
                                            <span class="span-dvidder">Description </span>
                                            <textarea
                                                type="text"
                                                name="description"
                                                class="tinymceEditor form-control">{{$subscribers->description}}</textarea>
                                        </div>

                                        <div class="form-group row">
                                            <label for="price" class="col-lg-3 col-form-label">Price</label>
                                            <div class="col-lg-12">
                                                <input id="price" type="number" name="price"
                                                       value="{{$subscribers->price}}"
                                                       class="form-control form-control-lg" placeholder="Enter price"
                                                       step="0.01" min="0.01" required="">
                                            </div>
                                        </div>

                                        <button type="submit" form="submit-form" class="btn btn-success btn-sm ">
                                            Update
                                        </button>
                                        <!--  CONTENT END  -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="pro-head p-0 pb-2">
                            <h3 class="mb-0">Subscriber Create</h3>
                        </div>
                        <div>
                            <div class="row">
                                <div>
                                    <form class="form" id="submit-form" method="post"
                                          action="{{route('frontend.dashboard.subscribers.store')}}">
                                        @csrf
                                        <div class="form-group">
                                            <span class="span-dvidder">Name</span>
                                            <input type="text" name="name" value=""
                                                   class="form-control">
                                        </div>

                                        <!--  CONTENT START  -->
                                        <div class="form-group">
                                            <span class="span-dvidder">Description </span>
                                            <textarea
                                                type="text"
                                                name="description"
                                                class="tinymceEditor form-control"></textarea>
                                        </div>

                                        <div class="form-group row">
                                            <label for="price" class="col-lg-3 col-form-label">Price</label>
                                            <div class="col-lg-12">
                                                <input id="price" type="number" name="price"
                                                       value=""
                                                       class="form-control form-control-lg" placeholder="Enter price"
                                                       step="0.01" min="0.01" required="">
                                            </div>
                                        </div>

                                        <button type="submit" form="submit-form" class="btn btn-success btn-sm ">
                                            Create
                                        </button>
                                        <!--  CONTENT END  -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <!--  TINYMCE START -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.1/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinymceEditor',
            height: 263,
            resize: false,
            menubar: false,
            block_formats: "Paragraph=p;Heading 1=h1;Heading 2=h2",
            valid_elements: "p,h1,h2,ul,ol,li,strong,em,a[href],br",
            invalid_elements: "script,iframe,object,embed",
            forced_root_block: 'p',
            toolbar: 'undo redo |   h2   |  removeformat | bullist numlist |',
            valid_styles: {},
            plugins: 'paste lists',
            paste_as_text: true,
        });
    </script>

@endsection
