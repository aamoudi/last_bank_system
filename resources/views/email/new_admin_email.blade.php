@component('mail::message')
# Welcome In BankSystem

We are happy {{ $fullName }} to see you with us.

@component('mail::panel')
Your password is: Pass123$
@endcomponent

@component('mail::button', ['url' => 'http://127.0.0.1:8000/cms/admin/login'])
Login to CMS Admin
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
