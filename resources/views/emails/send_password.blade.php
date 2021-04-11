@component('mail::message')

hello :{{ $user->name }}

your  password is : {{ $password }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
