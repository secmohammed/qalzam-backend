@extends('layouts.website', ['activeRoute' => 'gallery', 'headerClass' => 'header-inner'])
@section('content')
    <section class="gallary">
        <div class="container">
            <ul class="wizard">
                <li> <a href="index.html">
                        الرئيسيه
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li> معرض الصور </li>
            </ul>
            <h2 class="title">معرض الصور</h2>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach($branches as $branch)
                    <li class="nav-item"><a class="nav-link " id="item-{{$branch->id}}-tab" data-toggle="tab" href="#item-{{$branch->id}}" role="tab" aria-controls="item-1" aria-selected="true" onclick="addActiveClass({{$branch->id}})">{{$branch->name}}</a></li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                @foreach($branches as $preview_branch)
                    <div class="tab-pane fade" id="item-{{$preview_branch->id}}" role="tabpanel" aria-labelledby="item-{{$preview_branch->id}}-tab">
                    <div class="row">
                        @foreach($preview_branch->albums as $album)
                            <div class="col-sm-4 item-bra"><a class="photo" href="{{route('website.gallery', ['gallery' => $album])}}"><img src="{{$album->getLastMediaUrl('album-gallery')}}" alt="" title="">
                                <div class="content">
                                    <div>
                                        <h3 class="title">{{$album->name}} </h3><span>{{count($album->media)}} صورة</span>
                                    </div>
                                </div></a></div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            function addActiveClass(id){
                $(".tab-pane").removeClass("active")
                $("#item-" + id + "tab").addClass('active')
                $("#item-" + id).addClass('show active')
                console.log(id)
            }
        </script>
    @endpush
@endsection
