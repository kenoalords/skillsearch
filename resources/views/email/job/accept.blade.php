@component('mail::message')
# Congrats {{ $fullname }}

Your application for **{{ $title }}** was accepted by **{{ $owner_name }}**.

## Your Application
*{{$application}}*<br>
**Budget**: {{$budget}}


## {{ $owner_name }} Message to you
*{{ $message }}*


### NOTE: For your own safety when dealing with people, please ensure you meet in an open place during the day. DO NOT meet with strangers at night.

Congrats once again,<br>
**{{ config('app.name') }}**
@endcomponent
