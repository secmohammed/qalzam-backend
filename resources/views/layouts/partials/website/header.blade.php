
<header class="header {{$headerClass ?? ''}}">
    <div class="container">
        <div class="logo"><a href="{{route('website.home')}}"> <img src="{{asset('assets/images/logo.svg')}}" alt="" title=""></a></div>
        <div id="cssmenu">
            <ul>
                <li><a class="{{$activeRoute === 'home' ? 'active' : ''}}" href="{{route('website.home')}}">الرئيسية</a></li>
                <li><a class="{{$activeRoute === 'branches' ? 'active' : ''}}" href="{{route('website.branches')}}">القائمة</a></li>
                <li><a class="{{$activeRoute === 'gallery' ? 'active' : ''}}" href="{{route('website.galleries')}}">معرض الصور</a></li>
                <li><a class="{{$activeRoute === 'reservation' ? 'active' : ''}}" href="{{route('website.reservation')}}">حجوزات الفروع</a></li>
            </ul>
        </div>
        <div class="icons">
            <div class="language">  <a href="en/index.html">En</a></div>

            @guest
            <a href="#login" data-toggle="modal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.829 11.5609C13.4172 11.5609 14.7924 10.9913 15.9163 9.86737C17.0398 8.74365 17.6096 7.36871 17.6096 5.78027C17.6096 4.19238 17.04 2.81726 15.9161 1.69318C14.7922 0.569641 13.4171 0 11.829 0C10.2405 0 8.8656 0.569641 7.74188 1.69336C6.61816 2.81708 6.04834 4.1922 6.04834 5.78027C6.04834 7.36871 6.61816 8.74384 7.74188 9.86755C8.86597 10.9911 10.2411 11.5609 11.829 11.5609ZM8.73651 2.68781C9.59875 1.82556 10.6102 1.40643 11.829 1.40643C13.0475 1.40643 14.0592 1.82556 14.9216 2.68781C15.7839 3.55023 16.2032 4.56189 16.2032 5.78027C16.2032 6.99902 15.7839 8.0105 14.9216 8.87292C14.0592 9.73535 13.0475 10.1545 11.829 10.1545C10.6106 10.1545 9.59912 9.73517 8.73651 8.87292C7.87408 8.01068 7.45477 6.99902 7.45477 5.78027C7.45477 4.56189 7.87408 3.55023 8.73651 2.68781Z" fill="#D1362A"></path>
                    <path d="M21.9435 18.4228C21.9111 17.9551 21.8456 17.445 21.7491 16.9063C21.6517 16.3636 21.5262 15.8505 21.3761 15.3816C21.2208 14.8969 21.0101 14.4183 20.7491 13.9596C20.4787 13.4835 20.1608 13.069 19.8041 12.7278C19.4312 12.371 18.9745 12.084 18.4464 11.8748C17.9202 11.6666 17.337 11.5611 16.7131 11.5611C16.4681 11.5611 16.2312 11.6616 15.7736 11.9595C15.492 12.1432 15.1626 12.3556 14.7949 12.5905C14.4805 12.7908 14.0546 12.9785 13.5286 13.1484C13.0153 13.3145 12.4942 13.3987 11.9797 13.3987C11.4655 13.3987 10.9444 13.3145 10.4308 13.1484C9.90527 12.9787 9.47919 12.791 9.16534 12.5907C8.80115 12.358 8.47156 12.1456 8.18573 11.9594C7.72852 11.6614 7.49158 11.5609 7.24658 11.5609C6.62256 11.5609 6.03955 11.6666 5.51349 11.8749C4.98578 12.0839 4.52893 12.3708 4.15558 12.728C3.79889 13.0693 3.48102 13.4837 3.21075 13.9596C2.9502 14.4183 2.73926 14.8967 2.58398 15.3818C2.43402 15.8507 2.30859 16.3636 2.21118 16.9063C2.1145 17.4443 2.04913 17.9546 2.01672 18.4233C1.98486 18.8817 1.96875 19.3586 1.96875 19.8406C1.96875 21.0934 2.367 22.1076 3.15234 22.8556C3.92798 23.5937 4.9541 23.968 6.20233 23.968H17.7585C19.0063 23.968 20.0325 23.5937 20.8083 22.8556C21.5938 22.1082 21.9921 21.0936 21.9921 19.8404C21.9919 19.3568 21.9756 18.8798 21.9435 18.4228ZM19.8386 21.8366C19.326 22.3244 18.6456 22.5615 17.7583 22.5615H6.20233C5.31482 22.5615 4.6344 22.3244 4.12207 21.8368C3.61945 21.3583 3.37518 20.7052 3.37518 19.8406C3.37518 19.3909 3.39001 18.9468 3.41968 18.5206C3.44861 18.1024 3.50775 17.6429 3.59546 17.1548C3.68207 16.6727 3.7923 16.2202 3.9234 15.8106C4.04919 15.4178 4.22076 15.0289 4.43353 14.6543C4.6366 14.2972 4.87024 13.9909 5.12805 13.7441C5.3692 13.5132 5.67316 13.3242 6.03131 13.1825C6.36255 13.0514 6.7348 12.9796 7.13892 12.9688C7.18817 12.995 7.27588 13.045 7.41797 13.1376C7.70709 13.326 8.04034 13.541 8.40875 13.7763C8.82404 14.0411 9.35907 14.2802 9.99829 14.4866C10.6518 14.6979 11.3183 14.8052 11.9799 14.8052C12.6414 14.8052 13.3081 14.6979 13.9612 14.4868C14.601 14.28 15.1359 14.0411 15.5517 13.7759C15.9287 13.535 16.2526 13.3262 16.5417 13.1376C16.6838 13.0452 16.7715 12.995 16.8208 12.9688C17.2251 12.9796 17.5974 13.0514 17.9288 13.1825C18.2867 13.3242 18.5907 13.5134 18.8318 13.7441C19.0897 13.9907 19.3233 14.2971 19.5264 14.6545C19.7393 15.0289 19.9111 15.418 20.0367 15.8104C20.168 16.2206 20.2784 16.6729 20.3648 17.1546C20.4523 17.6437 20.5117 18.1033 20.5406 18.5208V18.5211C20.5704 18.9457 20.5854 19.3896 20.5856 19.8406C20.5854 20.7054 20.3412 21.3583 19.8386 21.8366Z" fill="#D1362A"></path>
                </svg>
            </a>
            @else
                    @include('layouts.partials.website.include._profile')
            @endguest
                <a class="onshow" href="#">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                            <path d="M23.6437 8.67485C23.3268 8.27726 22.8513 8.04917 22.3392 8.04917H17.7171L15.2108 2.31012C15.0554 1.95429 14.6409 1.79168 14.285 1.94717C13.9291 2.10256 13.7666 2.51707 13.9221 2.87295L16.1826 8.04921H7.81739L10.0779 2.87295C10.2333 2.51707 10.0709 2.1026 9.71499 1.94717C9.35916 1.79168 8.94464 1.9542 8.78925 2.31012L6.28289 8.04921H1.66083C1.14867 8.04921 0.673222 8.27726 0.3563 8.6749C0.0451904 9.06528 -0.0696064 9.56712 0.0413467 10.0519L2.50964 20.8331C2.682 21.586 3.34796 22.1117 4.12913 22.1117H19.8709C20.6521 22.1117 21.318 21.586 21.4904 20.8331L23.9587 10.0519C24.0696 9.56707 23.9548 9.06523 23.6437 8.67485ZM19.8709 20.7054H4.12913C4.00974 20.7054 3.90516 20.6271 3.88046 20.5192L1.41216 9.73807C1.3928 9.65346 1.42528 9.58981 1.45603 9.55132C1.48453 9.51551 1.54908 9.45546 1.66083 9.45546H5.66878L5.48461 9.8772C5.32922 10.2331 5.49169 10.6475 5.84757 10.803C5.93916 10.843 6.0346 10.8619 6.12858 10.8619C6.39961 10.8619 6.65789 10.7043 6.7733 10.4401L7.20328 9.45556H16.7968L17.2268 10.4401C17.3422 10.7044 17.6005 10.8619 17.8715 10.8619C17.9655 10.8619 18.0609 10.843 18.1525 10.803C18.5084 10.6476 18.6709 10.2331 18.5155 9.8772L18.3313 9.45546H22.3393C22.451 9.45546 22.5156 9.51551 22.5441 9.55132C22.5748 9.58985 22.6073 9.65351 22.5879 9.73803L20.1196 20.5193C20.0949 20.6271 19.9903 20.7054 19.8709 20.7054Z" fill="white"></path>
                            <path d="M7.78125 12.5023C7.39294 12.5023 7.07812 12.8171 7.07812 13.2054V18.3617C7.07812 18.75 7.39294 19.0648 7.78125 19.0648C8.16956 19.0648 8.48438 18.75 8.48438 18.3617V13.2054C8.48438 12.8171 8.16961 12.5023 7.78125 12.5023Z" fill="white"></path>
                            <path d="M12 12.5023C11.6117 12.5023 11.2969 12.8171 11.2969 13.2054V18.3617C11.2969 18.75 11.6117 19.0648 12 19.0648C12.3883 19.0648 12.7031 18.75 12.7031 18.3617V13.2054C12.7031 12.8171 12.3883 12.5023 12 12.5023Z" fill="white"></path>
                            <path d="M16.2188 12.5023C15.8304 12.5023 15.5156 12.8171 15.5156 13.2054V18.3617C15.5156 18.75 15.8304 19.0648 16.2188 19.0648C16.6071 19.0648 16.9219 18.75 16.9219 18.3617V13.2054C16.9218 12.8171 16.6071 12.5023 16.2188 12.5023Z" fill="white"></path>
                        </g>
                    </svg>
                </a>
        </div>
    </div>
</header>
{{--<div class="modal fade" id="login" role="dialog">--}}
{{--    <div class="modal-dialog">--}}
{{--        <div class="modal-content login">--}}
{{--            <div class="headtitle">--}}
{{--                <h3 class="title">تسجيل دخول</h3>--}}
{{--                <button class="close" type="button" data-dismiss="modal">--}}
{{--                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <form action="#" method="post">--}}
{{--                <!--div.alert.alert-success--}}
{{--                svg(width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg")--}}
{{--                  path(d="M39.2853 18.2363V20.0106C39.2829 24.1694 37.9363 28.2161 35.4461 31.547C32.956 34.8779 29.4559 37.3147 25.4678 38.4939C21.4796 39.673 17.2172 39.5314 13.3161 38.0902C9.41497 36.6489 6.08427 33.9852 3.82072 30.4964C1.55717 27.0075 0.482036 22.8805 0.755672 18.7307C1.02931 14.5809 2.63705 10.6307 5.33912 7.46926C8.04119 4.30784 11.6928 2.10457 15.7494 1.18804C19.8059 0.271518 24.0501 0.690841 27.8489 2.38348M39.2853 4.58207L19.9996 23.8871L14.2139 18.1014" stroke="white" stroke-linecap="round" stroke-linejoin="round")--}}
{{--                div.contant--}}
{{--                  p تم التسجيل بنجاح--}}
{{--                -->--}}
{{--                <!--div.alert.alert-danger--}}
{{--                svg(width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg")--}}
{{--                  path(d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round")--}}
{{--                div.contant--}}
{{--                  p هناك خطأ ما , يرجى إعاده المحاولة--}}
{{--                -->--}}
{{--                <div class="row">--}}
{{--                    <div class="col-sm-12 field">--}}
{{--                        <input class="form-control" type="text" placeholder="البريد الإلكتروني أو الجوال" value="">--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-12 field">--}}
{{--                        <input class="form-control" type="password" placeholder="الرقم السري" value="">--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-12 field flex"><a class="forgetlink" href="#forgot" data-toggle="modal" data-dismiss="modal">نسيت كلمة السر؟</a></div>--}}
{{--                    <div class="col-sm-12 field">--}}
{{--                        <button class="bottom" href="#code" data-toggle="modal" data-dismiss="modal">تسجيل الدخول</button>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-12 field">--}}
{{--                        <p class="textsign"> ليس لديك حساب ؟<a href="#signup" data-toggle="modal" data-dismiss="modal"> إنشاء حساب جديد</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@guest
@include('layouts.partials.website.include._login')
@include('layouts.partials.website.include._signup')
@include('layouts.partials.website.include._forget')
@include('layouts.partials.website.include._code')
@endguest
<livewire:cart.slider-cart />
<div class="overlay"></div>
<!--End Header-->

@push('scripts')
@endpush
