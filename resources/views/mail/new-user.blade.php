@component('mail::message')
# Login Details

Hello {{ $user->first_name }},

Your account has been created.
Below are your login details.

Email: {{ $user->email }}

Password: {{ $password }}

@component('mail::button', ['url' => env('FRONTEND_APP_URL')])
    Login
@endcomponent

Thanks,

{{ config('app.name') }}
@endcomponent
