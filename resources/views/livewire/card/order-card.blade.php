<div class="inner">

{{--    <div class="contant">--}}
{{--        <p class="red">أسماك، أطباق رئيسية</p><a class="title" href="#">كوزي القلزم المميز</a>--}}
{{--    </div>--}}
    <div class="contant">
        <p>{{__website('branch')}}</p>
        <h4 class="title">{{ $branchName }}</h4>
    </div>
    <div class="contant">
        <p>{{__website('date')}}</p>
        <h4 class="title"> {{ $createdAt }}</h4>
    </div>
    <div class="contant">
        <p>{{__website('order.type')}}</p>
        <h4 class="title">{{$orderType}}</h4>
    </div>
    <div class="contant">
        <p>{{__website('order.address')}}</p>
        <h4 class="title">{{$address}}</h4>
    </div>
    <div class="contant">
        <p>{{__website('order.status')}}</p>
        <h4 class="title">{{ $status }}</h4>
    </div>
    <div class="contant">
        <p>{{__website('order.total')}}</p>
        <h4 class="title red">{{ $price }}</h4>
    </div>
    <div class="contant"><a class="bottom" href="#evaluation" data-toggle="modal">{{__website('order.rate')}}</a></div>
</div>
