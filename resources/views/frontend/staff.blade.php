@extends('layouts.frontend.head')

@section('content')
    <div class="container">
        
        <h4 class="text-center pt-2"><strong>ہمارا سٹا ف</strong></h4>
        <div dir="rtl" class="row">
            <div class="row p-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center breaking-news bg-white">
                        <div
                            class="d-flex flex-row m-3 flex-grow-1 flex-fill justify-content-center py-2 text-white px-1 news rounded" style="background-color: #f14c38">
                            <span class="d-flex align-items-center">&nbsp;اہم خبریں</span></div>
                        <marquee class="news-scroll" behavior="scroll" loop="100" scrolldelay="1"
                            scrollamount="12" direction="right" onmouseover="this.stop();"
                            onmouseout="this.start();">
                            @foreach ($breaking_news as $item)
                                <a href="{{ route('news.detail', [$item->slug]) }}">{{ $item->title }}</a>
                                <span class="dot"></span>
                            @endforeach

                        </marquee>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="profile-card-4 text-center my-5">
                    <img src="{{ asset('assets/staff/ajmal.jpg') }}" style="width:100% !important" ;
                        class="img img-responsive">
                    <h4 class="pt-3">Ajmal</h4>
                    <div class="profile-description" style="font-size:16px;">Laravel Developer</div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="profile-card-4 text-center my-5">
                    <img src="{{ asset('assets/staff/ajmal.jpg') }}" style="width:100% !important" ;
                        class="img img-responsive">
                    <h4 class="pt-3">Ajmal</h4>
                    <div class="profile-description" style="font-size:16px;">Laravel Developer</div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="profile-card-4 text-center my-5">
                    <img src="{{ asset('assets/staff/ajmal.jpg') }}" style="width:100% !important" ;
                        class="img img-responsive">
                    <h4 class="pt-3">Ajmal</h4>
                    <div class="profile-description" style="font-size:16px;">Laravel Developer</div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="profile-card-4 text-center my-5">
                    <img src="{{ asset('assets/staff/ajmal.jpg') }}" style="width:100% !important" ;
                        class="img img-responsive">
                    <h4 class="pt-3">Ajmal</h4>
                    <div class="profile-description" style="font-size:16px;">Laravel Developer</div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="profile-card-4 text-center my-5">
                    <img src="{{ asset('assets/staff/ajmal.jpg') }}" style="width:100% !important" ;
                        class="img img-responsive">
                    <h4 class="pt-3">Ajmal</h4>
                    <div class="profile-description" style="font-size:16px;">Laravel Developer</div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="profile-card-4 text-center my-5">
                    <img src="{{ asset('assets/staff/ajmal.jpg') }}" style="width:100% !important" ;
                        class="img img-responsive">
                    <h4 class="pt-3">Ajmal</h4>
                    <div class="profile-description" style="font-size:16px;">Laravel Developer</div>
                </div>
            </div>



        </div>
    </div>
    </div>
@endsection
