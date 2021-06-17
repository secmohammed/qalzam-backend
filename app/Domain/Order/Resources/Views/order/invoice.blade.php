{{-- @dd($order->user->addresses()->activeAddress()->first()->location) --}}
{{-- @dd($order->user->addresses->where("default",true)->first()->location) --}}
{{-- @dd($order->user->addresses) --}}
{{-- @dd($order->deliverersWithFee()->first()); --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <!-- Styles -->
        <style>
              
.bill {
  position: relative;
  width: 100%;
  background: #fff;
  padding-bottom: 32px; }
  .bill .header-bill {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 32px 0px;
    border-bottom: 1px solid #e7eaec; }
    @media (max-width: 767px) {
      .bill .header-bill.headtow {
        display: block; }
        .bill .header-bill.headtow .logo {
          width: 100%;
          text-align: center; } }
    .bill .header-bill .logo {
      display: block; }
      .bill .header-bill .logo img {
        max-width: 106px; }
    .bill .header-bill .title {
      font-size: 24px;
      color: #3C3C3C;
      line-height: 35px;
      font-family: 'GESSTwoBold-Bold';
      position: relative;
      color: #D1362A; }
      @media (max-width: 991px) {
        .bill .header-bill .title {
          font-size: 20px; } }
      @media (max-width: 767px) {
        .bill .header-bill .title {
          width: 100%;
          text-align: center;
          margin-top: 12px; } }
    .bill .header-bill .link {
      display: block;
      color: #3C3C3C;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-weight: 600;
      -moz-transition: all 0.5s ease-in-out 0s;
      -o-transition: all 0.5s ease-in-out 0s;
      -webkit-transition: all 0.5s ease-in-out 0s;
      transition: all 0.5s ease-in-out 0s;
      margin-top: 8px; }
      .bill .header-bill .link:hover {
        color: #D1362A; }
    .bill .header-bill .text {
      display: block;
      color: #3C3C3C;
      font-size: 18px;
      font-weight: 600;
      margin-top: 8px; }
    .bill .header-bill .codenumber {
      width: 125px;
      height: 125px; }
      @media (max-width: 991px) {
        .bill .header-bill .codenumber {
          width: 85px;
          height: 85px; } }
      .bill .header-bill .codenumber img {
        width: 100%;
        max-height: 100%; }
  .bill .invoice-details {
    display: flex;
    justify-content: space-between; }
    @media (max-width: 550px) {
      .bill .invoice-details {
        display: block; } }
    .bill .invoice-details .textbox {
      margin-top: 32px; }
      .bill .invoice-details .textbox .title {
        font-size: 24px;
        color: #3C3C3C;
        line-height: 35px;
        font-family: 'GESSTwoBold-Bold';
        position: relative;
        font-size: 18px; }
        @media (max-width: 991px) {
          .bill .invoice-details .textbox .title {
            font-size: 20px; } }
        @media (max-width: 550px) {
          .bill .invoice-details .textbox .title {
            text-align: center; } }
      .bill .invoice-details .textbox .text {
        display: block;
        color: #3C3C3C;
        font-size: 18px;
        font-weight: 600;
        margin-top: 8px; }
        @media (max-width: 550px) {
          .bill .invoice-details .textbox .text {
            text-align: center; } }
    .bill .invoice-details .barcode {
      margin-top: 32px; }
      .bill .invoice-details .barcode .text {
        display: block;
        color: #3C3C3C;
        font-size: 18px;
        font-weight: 600;
        margin-top: 8px; }
        @media (max-width: 550px) {
          .bill .invoice-details .barcode .text {
            text-align: center; } }
      .bill .invoice-details .barcode .img {
        margin-top: 8px;
        width: 210px;
        height: 56px; }
        @media (max-width: 550px) {
          .bill .invoice-details .barcode .img {
            width: 100%; } }
        .bill .invoice-details .barcode .img img {
          width: 100%;
          max-height: 100%; }
  .bill .table-responsive {
    margin-top: 32px; }
    .bill .table-responsive .table td,
    .bill .table-responsive .table th {
      border-top: 2px solid #e7eaec;
      color: #3C3C3C;
      font-size: 18px;
      padding: 0.75rem 0px;
      white-space: nowrap; }
      .bill .table-responsive .table td.bold,
      .bill .table-responsive .table th.bold {
        font-weight: 700; }
    .bill .table-responsive .table th {
      font-weight: 700;
      border: 0px;
      border-bottom: 2px solid #e7eaec; }
  .bill .totalprice {
    display: flex;
    justify-content: space-between;
    margin-top: 32px; }
    @media (max-width: 767px) {
      .bill .totalprice {
        display: block; } }
    .bill .totalprice .last {
      min-width: 40%;
      max-width: 40%; }
      @media (max-width: 767px) {
        .bill .totalprice .last {
          min-width: 100%;
          max-width: 100%; } }
      .bill .totalprice .last li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px; }
        .bill .totalprice .last li:last-child {
          margin: 0px; }
          @media (max-width: 767px) {
            .bill .totalprice .last li:last-child {
              margin-bottom: 12px; } }
        .bill .totalprice .last li p {
          display: block;
          width: 50%;
          color: #3C3C3C;
          font-size: 18px;
          font-weight: 600; }
        .bill .totalprice .last li span {
          font-size: 18px;
          color: #3C3C3C; }
  .bill .text-done {
    display: block;
    color: #3C3C3C;
    font-size: 18px;
    font-weight: 600;
    margin-top: 32px; }
  .bill .details {
    margin-top: 32px; }
    .bill .details .title {
      font-size: 24px;
      color: #3C3C3C;
      line-height: 35px;
      /* font-family: 'GESSTwoBold-Bold'; */
      position: relative;
      color: #006fb8;
      font-size: 18px; }
      @media (max-width: 991px) {
        .bill .details .title {
          font-size: 20px; } }
    .bill .details ul {
      margin-top: 12px; }
      .bill .details ul li {
        color: #3C3C3C;
        font-size: 16px;
        font-weight: 600;
        line-height: 28px;
        margin-bottom: 12px; }
        body {
font-family: DejaVu Sans;
}
        
        .bill .details ul li:last-child {
          margin: 0px; }
    .bill .details .table-responsive .table {
      background: #eeeeee; }
      .bill .details .table-responsive .table th {
        background: #bdb9b9;
        border: 0px;
        border-bottom: 2px solid #fff;
        padding: .75rem;
        text-align: center; }
        .bill .details .table-responsive .table th.wit {
          width: 30%; }
      .bill .details .table-responsive .table td {
        border-top: 2px solid #fff;
        padding: .75rem; }
        .bill .details .table-responsive .table td.bg {
          background: #bdb9b9;
          width: 30%;
          text-align: center; }
    .bill .details .table-responsive .footer-price {
      background: #bdb9b9; }
      .bill .details .table-responsive .footer-price td {
        color: #3C3C3C;
        font-size: 18px;
        font-weight: 700; }
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{
              /* font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;\ */
              line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>


       
    </head>
  <body>
    <section class="bill"> 
      <div class="container">
        <div class="header-bill">
          <div class="order"><a class="logo" href="index.html"> <img src="assets/images/logo.svg" alt="" title=""></a><a class="link" href="#">/http:/order.alqalzam.com</a>
            <p class="text">الرقم الضريبي <span>300132186900003</span></p>
          </div>
          <div class="codenumber"><img src="assets/images/codenumber.png" alt="" title=""></div>
        </div>
        <div class="invoice-details">
          <div class="textbox">
            <h1 class="title">{{ __("main.pay-on-delivery") }}</h1>
            <p class="text">{{ __("main.request-date") }} <span>{{ $order->created_at  }}</span></p>
            <p class="text">{{ __("main.invoice-print-date") }}<span>{{ \Carbon\Carbon::now()->format('Y-m-d h:m:s')  }} </span></p>
          </div>
          <div class="barcode">
            <p class="text text-left">{{ __("main.order-number") }} <span>#{{ $order->id }}</span></p>
            <div class="img"><img src="assets/images/barcode.png" alt="" title=""></div>
            <p class="text text-center"> #{{ $order->id }}</p>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table">
            <tr> 
              <td class="bold"> {{ __("main.to") }}</td>
              <td>{{ $order->user->name }}</td>
              <td class="bold"> {{ __("main.mobile") }}</td>
              <td> {{ $order->user->mobile }}</td>
            </tr>
            <tr> 
              <td class="bold"> {{ __("main.zone") }}</td>
              <td>{{ optional($locations->where('type', 'zone')->first())->name }}</td>
              <td class="bold">{{ __("main.street") }}</td>
              <td> {{ optional($locations->where('type', 'district')->first())->name }}       </td>
            </tr>
            <tr> 
              <td class="bold"> {{ __("main.city") }}</td>
              <td>{{ optional($locations->where('type', 'city')->first())->name }}</td>
              <td class="bold">{{ __("main.country") }}</td>
              <td>{{ optional($locations->where('type', 'country')->first())->name }} </td>
            </tr>
          </table>
        </div>
        <div class="table-responsive">
          <table class="table">
            <tr> 
              <th >{{ __("main.product-code") }}</th>
              <th >{{ __("main.products") }}</th>
              <th >{{ __("main.quantity") }}</th>
              <th >{{ __("main.price") }}</th>
              <th >{{ __("main.subtotal") }}</th>
            </tr>
            @foreach ($order->products as $product)
            <tr>
              <td >{{ $product->id }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->pivot->quantity }}</td>
              <td>{{$product->formatted_price  }}</td>
              <td>{{ $product->formatted_price}}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="totalprice">
          <ul class="last"> 
            <li>
              <p>{{ __("main.shipping-method") }}</p> <span>  delivery</span>
            </li>
            <li>
              <p>{{ __("main.expected-time-deliver-service") }}</p> <span>30 minutes - 45 minutes</span>
            </li>
          </ul>
          <ul class="last"> 
            <li>
              <p>{{ __("main.value-product-without-tax") }}</p> <span>{{ (new App\Common\Transformers\Money ( $order->amount() - $order->amount() * .15   ))->formatted() }}</span>
            </li>
            <li>
              <p>{{ __("main.tax-additive") }}</p> <span>{{ (new App\Common\Transformers\Money ($order->amount() * .15))->formatted()}} </span>
            </li>
            <li>
              <p>{{ __("main.subtotal-inclusive-tax") }}</p> <span>{{  $order->total()->formatted()   }}</span>
            </li>
            <li>
              <p>{{ __("main.delivery") }}</p> <span>{{(new App\Common\Transformers\Money ( $order->deliverersWithFee()->first()->delivery_fee))->formatted() }}</span>
            </li>
            {{-- <li>
              <p>دفع عند التوصيل</p> <span>SAR 34.78</span>
            </li> --}}
            <li>
              <p> {{ __("main.subtotal") }}</p> <span>{{(new App\Common\Transformers\Money( (new App\Common\Transformers\Money ( $order->deliverersWithFee()->first()->delivery_fee))->amount() + $order->amount()))->formatted() }}</span>
            </li>
          </ul>
        </div>
      </div>
    </section>
</body>
</html>


