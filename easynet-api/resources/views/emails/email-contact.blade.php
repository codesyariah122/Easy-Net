<img src="{{env('FRONTEND')}}assets/images/logo/logo-blue.svg" alt="" style="width: 100px;">

<h5>{{$details['title']}}</h5>
	<blockquote class="blockquote-footer text-info">
		<strong>Halo, {{$details['roles']}} EasyNet<br> <strong><b><i>{{$details['fullname']}}</i></b> dengan email : {{$details['email']}}</strong>, baru saja mengirim pesan melalui website:
	</blockquote>

	<br><br><br>
	<p>Detail Message  :  </p>
	<ul>
		<li>Nama  : {{$details['fullname']}}</li>
		<li>Email : {{$details['email']}}</li>
		<li>Phone : {{$details['phone']}}</li>
		<li>Messagee : <br> 
			{{$details['message']}}
		</li>
	</ul>

	<br>

	<p>
		Respon pesan dari : {{ $details['fullname'] }} di sini <br>

		<br>
		<a href="{{ env('FRONTEND')}}dashboard/{{$details['roles']}}/{{$details['route']}}/contact" class="btn btn-info btn-block">Response Message</a>
	</p>
