{{-- @dd($reservation) --}}
{{-- @dd($reservation) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="asstes/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&amp;display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Styles -->


   
</head>
   
  <body>
    <section class="bill"> 
      <div class="container">
        <div class="header-bill headtow"><a class="logo" href="index.html"> <img src="assets/images/logo.svg" alt="" title=""></a>
          <h1 class="title"> اتفاقية شروط استخدام غرف منتجع القلزم</h1>
        </div>
        <p class="text-done">عميلنا العزيز .. نتشرف بتقديم أرق الخدمات واعل معايير الجودة بالمأكولات، لذا لضمان استمراريتها نأمل الاطلاع عل البنود التالية والتوقيع ادناه عل موافقتم</p>
        <div class="details">
          <h3 class="title">أولا: الشروط والالتزامات</h3>
          <ul> 
            <li>*يمنع اصطحاب المأكولات والمشروبات من خارج المنتجع</li>
            <li>*تم تخصيص موقف سيارة واحدة فقط لل غرفة، وف حال وجود أكثر من سيارة فتوجد مواقف خارجية</li>
            <li>*أولوية الدخول لمن لديه حجز مسبق من خلال الاتصال بخدمة الحجوزات عل الرقم الموحد 920001515 </li>
            <li>*تم تخصيص مفتاح الترون لل غرفة، يتم استلامه من الاستقبال ببوابة الدخول، واعادته مرة أخرى لمتب الإستقبال عند المغادرة، وبمنع تسليمه لأي عميل آخر أو لأحد موظف المنتجع</li>
            <li>*حفاظاً عل راحة العملاء وسلامة اطفالم يمنع استخدام جميع أنواع العجلات الهربائية وغير الهربائية مثل (الدراجة، الإسوتر، الإسيت، سيارات الأطفال بجميع أنواعها) ويسمح فقط بإستخدام عربات نقل الأطفال</li>
          </ul>
        </div>
        <div class="details">
          <h3 class="title">ثانياً: موجودات الغرفة</h3>
          <ul> 
            <li>*رغبة ف قضاء أجمل الأوقات وأمتعها لعملاءنا بالغرف الخاصة حرصنا عل توفير الأجهزة ذات الخصائص والبرامج التقنية العالية لذا نأمل التفضل بالاعتناء بها وه كالتال شاشة تلفزيون ذات مواصفات خاصة + ريموت |ريموت ميف ماركة جري | جهاز تليفون</li>
          </ul>
        </div>
        <div class="details">
          <h3 class="title">ثالثا : إخلاء مسؤولية المنتجع ‐ المنتجع غير مسؤول عن أي مفقودات</h3>
          <ul> 
            <li>عميلنا العزيز نأمل عند الخروج من الغرفة عدم ترك أياً من متعلقاتم الشخصية <br/> كما نرجوا عند المغادرة وتسليم الغرفة التأكد من عدم نسيان أياً من متعلقاتم الشخصية      </li>
          </ul>
        </div>
        <div class="details">
          <h3 class="title">رابعا: قيمة الخدمات</h3>
          <div class="table-responsive">
            <table class="table">

              <tr> 
                <th class="bg">{{ __("main.id") }}</th>
                <th>{{ __("main.description") }}</th>
                <th>{{ __("main.price") }}</th>
                <th> {{ __("main.quantity") }}</th>
                <th> {{ __("main.subtotal") }}</th>
              </tr>
              @foreach ($products as $product)
          <tr class="my-5   h-9 text-center border-separate " >
            <th class="bg-gray-400 text-center ">{{ $product->id }}</th>
            <td >{{ $product->name }}</td>
            <td>{{ $product->pivot->price->formatted() }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>{{( new App\Common\Transformers\Money($product->pivot->price->amount() * $product->pivot->quantity ))->formatted()  }}</td>
            
          </tr>
          @endforeach
             
              <tr class="footer-price"> 
                <td colspan="3">* ({{ __("main.all-price-tax") }} )</td>
                <td>{{ __("main.subtotal") }}</td>
                <td>  {{$reservation->formatted_price}}</td>
              </tr>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table">
              <tr> 
                <th> {{ __("main.client-name") }}</th>
                <th>{{ __("main.mobile") }}</th>
                <th>{{ __("main.room-number") }}</th>
                <th>{{ __("main.date") }}</th>
                <th>{{ __("main.entry-time") }}</th>
                <th>{{ __("main.contract-number") }}</th>
                <th>{{ __("main.reservation-number") }}</th>
                <th>{{ __("main.employee-name") }}</th>
              </tr>
              <tr> 
                <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->user->mobile }}</td>
            <td>{{ $reservation->accommodation->code }}</td>
            <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format("Y-m-d")}}</td>
            <td>{{ $reservation->start_date }}</td>
            <td>{{ $reservation->accommodation->contract->id }}</td>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->creator->name }}</td>
              </tr>
              <tr class="footer-price"> 
                <td colspan="5"> {{ __("main.signature") }}</td>
                <td colspan="3"> </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>

