@component('mail::message')
# Introduction

Hi! {{ $user->first_name }}

Please use this account to login: <br>
<b>Email: </b> {{ $user->email }} <br>
<b>Password: </b> {{ $user->raw_password }}

@component('mail::button', ['url' => ''])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
