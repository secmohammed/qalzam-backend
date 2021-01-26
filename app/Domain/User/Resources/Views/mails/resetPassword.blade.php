@component('mail::message')
# {{ config('app.name')}} | Password Reset
Hello {{ $user->name }},
Click at the link below to reset your password
@component('mail::button', ['url' => sprintf('%s/%s/%s/%s', env('APP_URL','http://localhost:8000'), 'password', 'reset',  $token)])
Reset Your Password.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
