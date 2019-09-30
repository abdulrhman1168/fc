@extends('layouts.main.index')

@section('page')
<div class="row">
	<div class="col-md-3">
		<a class="services_categor hvr-bounce-to-bottom cat_5" href="{{route('cms.index')}}" title="">
			<img src="{{asset('assets/img/Administrative_communications2.png')}}">
			<br>الإتصالات الإدارية</a>
	</div>

	<div class="col-md-3">
		<a class="services_categor hvr-bounce-to-bottom cat_5" href="{{route('hr.index')}}" title="">
			<img src="{{asset('assets/img/Administrative_communications2.png')}}">
			<br>الموارد البشرية</a>
	</div>







	

</div>







@endsection