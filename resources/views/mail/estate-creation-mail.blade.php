@component('mail::message')
    # Welcome Mail

    Hello {{ $user->name }},

    Thank you for registering with us.

    You should find your account details mail in your inbox.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
