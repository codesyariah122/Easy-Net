<img src="{{env('FRONTEND')}}assets/images/logo/logo-blue.svg" alt="" style="width: 100px;">

<h5>{{$details['title']}}</h5>

<blockquote class="blockquote-footer text-info">
	<strong>Halo, <br> <strong><b><i>{{$details['username']}}</i></b></strong> silahkan aktivasi akun kamu di link berikut ini :
</blockquote>

<br><br><br>
<p>
	Aktivasi  akun : {{ $details['username'] }} di sini <br>

	<br>
	<a href="{{ env('FRONTEND')}}activated/user/{{$details['id']}}" class="btn btn-info btn-block">Aktivasi Member</a>
</p>