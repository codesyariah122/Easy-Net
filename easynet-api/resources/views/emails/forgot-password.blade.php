<img src="{{env('FRONTEND')}}assets/images/logo/logo-blue.svg" alt="" style="width: 100px;">

<h5>{{$details['title']}}</h5>

<blockquote class="blockquote-footer text-info">
	<strong>Halo, <br> <strong><b><i>{{$details['username']}}</i></b></strong> silahkan reset passworrd kamu di link berikut ini :
</blockquote>

<br><br><br>
<p>
	Reset Password : {{ $details['username'] }} di sini <br>

	<br>
	<a href="{{ env('FRONTEND')}}auth/reset/{{$details['token']}}" class="btn btn-info btn-block">Reset Password</a>
</p>