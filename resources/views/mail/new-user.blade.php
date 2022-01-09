@component('mail::message')
    # Hello {{ $user->first_name }},

    Your account has been created.
    Below are your login details.

    Email: {{ $user->email }}
    Password: {{ $password }}


    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
