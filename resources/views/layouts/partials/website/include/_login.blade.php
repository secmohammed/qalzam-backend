<div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content login">
            <div class="headtitle">
                <h3 class="title">تسجيل دخول</h3>
                <button class="close" type="button" data-dismiss="modal">
                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>
                    </svg>
                </button>
            </div>
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="alert alert-danger" id="errorContainerLogin">
                    <svg width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="contant">
                        <p>هناك خطأ ما , يرجى إعاده المحاولة</p>
                        <div class="" id="loginErrors"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 field">
                        <input class="form-control" name="email" type="text" placeholder="البريد الإلكتروني أو الجوال" value="">
                    </div>
                    <div class="col-sm-12 field">
                        <input class="form-control" name="password" type="password" placeholder="الرقم السري" value="">
                    </div>
                    <div class="col-sm-12 field flex"><a class="forgetlink" href="#forgot" data-toggle="modal" data-dismiss="modal">نسيت كلمة السر؟</a></div>
                    <div class="col-sm-12 field">
{{--                        <button class="bottom" href="#code" data-toggle="modal" data-dismiss="modal">تسجيل الدخول</button>--}}
                        <button class="bottom" href="#" id="loginButton">تسجيل الدخول</button>
                    </div>
                    <div class="col-sm-12 field">
                        <p class="textsign"> ليس لديك حساب ؟<a href="#signup" data-toggle="modal" data-dismiss="modal"> إنشاء حساب جديد</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    @if(session()->get('shouldLogin'))
        <script>
            $("#login").modal('show');
        </script>
    @endif
    <script>
        $("#errorContainerLogin").hide()
        $("#loginButton").click(function (event){
            event.preventDefault();
            let email = $("input[name=email]").val();
            let password = $("input[name=password]").val();
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{!! url('login') !!}",
                type:"POST",
                data:{
                    email:email,
                    password:password,
                    _token:_token
                },
                success:function(response){
                    window.location.href = response
                },
                error:function (response){
                    $("#loginErrors").empty();
                    $("#errorContainerLogin").show();
                    $.each(response.responseJSON.errors, function (key, item)
                    {
                        console.log(item)
                        $("#loginErrors").append("<li class='text-light m-2 font-weight-bold'>"+item+"</li>")
                    });
                }
            });
        })
    </script>
@endpush
