<div class="modal fade" id="signup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content login">
            <div class="headtitle">
                <h3 class="title">إنشاء حساب جديد</h3>
                <button class="close" type="button" data-dismiss="modal">
                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>
                    </svg>
                </button>
            </div>
            <form action="{{route('auth.register')}}" method="post">
                @csrf

{{--                <div class="alert alert-success">--}}
{{--                    <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path d="M39.2853 18.2363V20.0106C39.2829 24.1694 37.9363 28.2161 35.4461 31.547C32.956 34.8779 29.4559 37.3147 25.4678 38.4939C21.4796 39.673 17.2172 39.5314 13.3161 38.0902C9.41497 36.6489 6.08427 33.9852 3.82072 30.4964C1.55717 27.0075 0.482036 22.8805 0.755672 18.7307C1.02931 14.5809 2.63705 10.6307 5.33912 7.46926C8.04119 4.30784 11.6928 2.10457 15.7494 1.18804C19.8059 0.271518 24.0501 0.690841 27.8489 2.38348M39.2853 4.58207L19.9996 23.8871L14.2139 18.1014" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>--}}
{{--                    </svg>--}}
{{--                    <div class="contant">--}}
{{--                        <p>تم التسجيل بنجاح</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="alert alert-danger" id="errorContainer">
                    <svg width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="contant">
                        <p>هناك خطأ ما , يرجى إعاده المحاولة</p>
                        <div class="" id="registerErrors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 field">
                        <input class="form-control" name="name" type="text" placeholder="الإسم" value="">
                    </div>
{{--                    <div class="col-sm-6 field">--}}
{{--                        <input class="form-control" type="text" placeholder="الإسم الأخير" value="">--}}
{{--                    </div>--}}
                    <div class="col-sm-12 field">
                        <input class="form-control" name="registerEmail" type="text" placeholder="البريد الإلكتروني" value="">
                    </div>
                    <div class="col-sm-12 field">
                        <div class="row">
                            <div class="col-sm-4 item">
                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.20711 0.5C0.761655 0.5 0.538571 1.03857 0.853554 1.35355L4.64647 5.14647C4.84173 5.34173 5.15832 5.34173 5.35358 5.14646L9.14645 1.35355C9.46144 1.03857 9.23835 0.5 8.7929 0.5H1.20711Z" fill="#888888"></path>
                                </svg>
                                <select class="form-control dr-left">
                                    <option>+996 KSA </option>
                                </select>
                            </div>
                            <div class="col-sm-8 item">
                                <input class="form-control" name="phone_number" type="number" placeholder="رقم الجوال" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 field">
                        <input class="form-control" name="registerPassword" type="password" placeholder="الرقم السري" value="">
                    </div>
                    <div class="col-sm-12 field">
                        <input class="form-control" name="password_confirmation" type="password" placeholder="تأكيد الرقم السري" value="">
                    </div>
                    <div class="col-sm-12 field">
                        <button class="bottom" type="button" id="signupButton">إنشاء حساب  </button>
                    </div>
                    <div class="col-sm-12 field">
                        <p class="textsign">   لديك حساب ؟<a href="#login" data-toggle="modal" data-dismiss="modal">تسجيل الدخول  </a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $("#errorContainer").hide()
        $("#signupButton").click(function (event){
            event.preventDefault();
            let name = $("input[name=name]").val();
            let mobile = $("input[name=phone_number]").val();
            let email = $("input[name=registerEmail]").val();
            let password = $("input[name=registerPassword]").val();
            let password_confirmation = $("input[name=password_confirmation]").val();
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{!! route('auth.register') !!}",
                type:"POST",
                data:{
                    name:name,
                    mobile:mobile,
                    email:email,
                    password:password,
                    password_confirmation:password_confirmation,
                    _token:_token
                },
                success:function(response){
                    window.location.href = response
                },
                error:function (response){
                    $("#registerErrors").empty();
                    $("#errorContainer").show();
                    $.each(response.responseJSON.errors, function (key, item)
                    {
                        console.log(item)
                        $("#registerErrors").append("<li class='text-light m-2 font-weight-bold'>"+item+"</li>")
                    });
                }
            });
        })
    </script>
@endpush
