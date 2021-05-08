@extends('layouts.website', ['activeRoute' => 'reservation' , 'headerClass' => 'header-inner' ])
@section('content')
<section class="branch-reservations">
    <div class="container">
        <ul class="wizard">
            <li> <a href="index.html">
                    الرئيسيه
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li> حجوزات القلزم</li>
        </ul>
        <h2 class="title">حجوزات القلزم</h2>
        <div class="listorder">
            <p class="text">إختر الفرع</p>
            <nav class="list-filter">
                <div class="row">

                    @foreach($branches as $branch)
                        <a class="list-branches " id="branch-{{$branch->id}}" href="#" onclick="activeLinkById({{$branch->id}})">{{$branch->name}}</a>
                    @endforeach
                </div>
            </nav>
        </div>
        <!--div.alert.alert-success
        svg(width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg")
          path(d="M39.2853 18.2363V20.0106C39.2829 24.1694 37.9363 28.2161 35.4461 31.547C32.956 34.8779 29.4559 37.3147 25.4678 38.4939C21.4796 39.673 17.2172 39.5314 13.3161 38.0902C9.41497 36.6489 6.08427 33.9852 3.82072 30.4964C1.55717 27.0075 0.482036 22.8805 0.755672 18.7307C1.02931 14.5809 2.63705 10.6307 5.33912 7.46926C8.04119 4.30784 11.6928 2.10457 15.7494 1.18804C19.8059 0.271518 24.0501 0.690841 27.8489 2.38348M39.2853 4.58207L19.9996 23.8871L14.2139 18.1014" stroke="white" stroke-linecap="round" stroke-linejoin="round")
        div.contant
         p تم التعديل بنجاح
        -->
        <!--div.alert.alert-danger
        svg(width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg")
         path(d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round")
        div.contant
         p هناك خطأ ما , يرجى إعاده المحاولة
        -->
        <div class="inner">
            <form action="#" method="post">
                <div class="row">
                    <div class="col-sm-6 field">
                        <label>الإسم الأول</label>
                        <input class="form-control" type="text" placeholder="الإسم الأول" value="">
                    </div>
                    <div class="col-sm-6 field">
                        <label>الإسم الأخير</label>
                        <input class="form-control" type="text" placeholder="الإسم الأخير" value="">
                    </div>
                    <div class="col-sm-6 field">
                        <label>الجول</label>
                        <input class="form-control" type="number" placeholder="الجول" value="">
                    </div>
                    <div class="col-sm-6 field">
                        <label>البريد الإلكتروني</label>
                        <input class="form-control" type="email" placeholder="البريد الإلكتروني" value="">
                    </div>
                    <div class="col-sm-6 field">
                        <label>التاريخ </label>
                        <input class="form-control" placeholder="التاريخ" id="date" name="date" value=""><img src="images/calendar.svg" alt="" title="">
                    </div>
                    <div class="col-sm-6 field">
                        <label>توقيت الوصول </label>
                        <div class="clockpicker">
                            <input class="form-control" type="text" placeholder="توقيت الوصول" value=""><img src="images/time.svg" alt="" title="">
                        </div>
                    </div>
                    <div class="col-sm-6 field">
                        <label>غرفة/طاولة </label>
                        <select class="form-control">
                            <option>إختر غرفة/طاولة</option>
                            <option>مصر</option>
                        </select>
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M3.78049 6.06472L0.0864105 2.37063C-0.0316992 2.24834 -0.0283081 2.05346 0.0939863 1.93535C0.213286 1.82013 0.40241 1.82013 0.521692 1.93535L3.99814 5.41179L7.47458 1.93535C7.59478 1.81517 7.78966 1.81517 7.90986 1.93535C8.03005 2.05557 8.03005 2.25043 7.90986 2.37063L4.21578 6.06472C4.09556 6.1849 3.9007 6.1849 3.78049 6.06472Z" fill="#252525"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="col-sm-6 field">
                        <label>رقم غرفة/طاولة</label>
                        <input class="form-control" type="text" placeholder="رقم غرفة/طاولة" value="">
                    </div>
                    <div class="col-sm-12 field">
                        <label>ملاحظات أخري</label>
                        <textarea class="form-control" name="" placeholder="ملاحظات أخري"> </textarea>
                    </div>
                    <div class="col-sm-12 field">
                        <button class="bottom" type="submit">إرسال الأن</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        function activeLinkById(id)
        {
            $(".list-branches").removeClass('active')
            $("#branch-" + id).addClass('active')
        }
    </script>
@endpush
@endsection
