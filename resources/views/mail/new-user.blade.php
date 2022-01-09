@component('mail::message')
    # Login Details

    Hello {{ $user->first_name }},

    Your account has been created.
    Below are your login details.

    Email: {{ $user->email }}
    Password: {{ $password }}


    Thanks,
    {{ config('app.name') }}
@endcomponent
