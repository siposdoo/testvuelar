@component('mail::message')
#Pozdrav {{$subscriber->email}},


<p>Imate dnevni citat:</p>

 
<p><strong>{{ $citat->naziv }}</strong></p>
<p>{{ $citat->text }}</p>
<small>Kreiran <strong>{{ \Carbon\Carbon::parse($citat->created_at)->diffForHumans() }}</strong></small>
 
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent