@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content" x-data="courses">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="portfolio-item">
                        <div class="pro-head p-0 pb-4">
                            <h3 class="mb-0">{{ language('My courses') }}</h3>
                            <a href="{{route('frontend.dashboard.freelancer.create.courses')}}" class="btn btn-primary back-btn br-0 addPortfolio" >{{ language('+ Add Course') }}</a>
                        </div>

                        <div class="pro-content pt-4 pb-4">
                            <div class="row">
                                <div class="course">
                                    <template x-for="course, index in listCourses" :key="course.id">
                                        <div class="course__item">
                                            <h3 x-text="course.name"></h3>
                                            <h5 x-text="`Access type ${course.access}`"></h5>

                                            <div class="course__item-content" x-html="course.description"></div>
                                            <div class="course__item-files" x-show="course.files.length > 0">
                                                <template x-for="(file, index) in course.files" :key="file.id">
                                                    <div class="single__tab-files-item">
                                                        <template x-if="file.type == 'image'">
                                                            <img class="single__tab-files-item-img" width="400" height="400" :src="file.promo">
                                                        </template>
                                                        <template x-if="file.type != 'image'">
                                                            <a  :href="file.path" download >
                                                                <img width="400" height="400" :src="file.promo">
                                                            </a>
                                                        </template>
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm mt-2"
                                                                @click="removeFile(index, file?.link)">
                                                            Remove
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm mt-2"
                                                    @click="remove(index, course.delete_link)">
                                                Remove Course Item
                                            </button>
                                            <a :href="course.edit_link" class="btn btn-primary btn-sm mt-2">
                                                Update Course Item
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('CSS')
    <!-- CROPPER CSS  -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/cropper/croppie.css') }}">
    <style>
        .course__item + .course__item {
            margin-top: 25px;
        }
        .course__item-content {
            margin-top: 20px;
        }
        .course__item-files {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-left: -25px;
        }
        .single__tab-files-item {
            display: flex;
            flex-basis: calc(25% - 25px);
            margin-left: 25px;
            flex-direction: column;
        }
        @media (max-width: 1200px) {
            .course__item-files {
                margin-left: 0px;
            }
            .single__tab-files-item {
                flex-basis: 100%;
                margin-left: 0px;
            }
            .single__tab-files-item img {
                width: 100%;
                height: 100%;
            }
            .course {
                margin-left: 0px;
            }
        }


    </style>
@endsection

@section('JS')
    <script>
        function courses() {
            return {
                listCourses: @json($courses),
                async  removeFile(index, link) {
                    if(link) {
                        const result = await fetch(link, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        if(result.ok) {
                            return   this.listCourses  = (await result.json()).data;
                        }
                    }
                },
                async remove(index, link) {
                    const result = await fetch(link, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if(result.status === 204) {
                        this.listCourses.splice(index, 1);
                    }
                },
            }
        }
    </script>
@endsection
