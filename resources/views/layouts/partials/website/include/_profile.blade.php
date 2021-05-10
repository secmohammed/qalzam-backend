<div class="dropdown show mx-3">
    <a class="fa fa-user-alt" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user-alt"></i>
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="#">صفحتي</a>
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <button class="dropdown-item" type="submit">تسجيل خروج</button>
        </form>
    </div>
</div>
