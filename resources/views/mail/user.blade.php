@component('mail::message')
    # Registration success

    You have been successfully registered with  {{ config('app.name') }}

    Use this pass to login {{$user['password']}}

    @component('mail::button', ['url' => $user['name']])
        Login
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
