<!-- app/views/Home/search.blade.php -->

<!doctype html>
<html>
<head>
<title>Search</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Validate -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>
<style>
*{
	padding:0px;
	margin:0px;
}
.top_header{
	background: #4e4e4e;
	color:#fff;
	padding:5px;
}
.m-t-40{
	margin-top:40px;
}
.br-0{
	border-radius: 0px !important;
	background: transparent !important;
}
input{
	border-radius: 0px !important;
	box-shadow: none !important;
}
.custom_ul ul{
	list-style: none;

}
.custom_ul ul li{
	display: inline-block;
	margin-right: 10px;
	margin-top: 10px;
}
.control-label{
	text-align: left !important;
}
.m-b-20{
	margin-bottom:20px;
}
</style>

</head>
<body>
@if(!$status)
	<div>
	{{ Form::open(array('method'=>'post','url' => 'search', 'class' => '','data-parsley-validate'=>"")) }}
	

	<!-- if there are login errors, show them here -->

	<div class="">
		<div class="col-sm-offset-3 col-sm-5">
			<h3 class="top_header">Search GitHub Users</h3>
				
				<div class="form-group m-t-40">
				<label for="email">User Name</label>
				<!-- <input type="email" class="form-control" id="email"> -->
				{{ Form::text('username', '',array('placeholder' => 'User name', 'class' => 'form-control','data-parsley-required-message'=>'User name is required.','required'=>true)) }}
				</div>
				{{ Form::submit('Submit',array('class' => 'btn btn-default br-0')) }}
				
				<!-- <button type="submit" class="btn btn-default">Submit</button> -->
				@if($code!=1) <p>{{$message}}</p> @endif
		</div>
	</div>
	<!-- <p>
	    {{ $errors->first('username') }}
	</p>

	<p>
	    {{ Form::label('username', 'User name') }}
	    {{ Form::text('username', '',array('placeholder' => 'User name')) }}
	</p>
 -->
	<!-- <p>{{ Form::submit('Submit') }}</p> -->
	{{ Form::close() }}
	
	</div>

@else
	<div class="col-md-12">
		<h3 class="top_header">User Details</h3>
		<div class="col-md-12 m-b-20">
			<a href='{{ url("/") }}' id="reset" class="btn btn-default br-0" >Try Another Search</a>
		</div>
		
		@if($result['userList']!='')
			<div class="col-sm-12">
				<div class="">
					<form class="form-horizontal">
						<div class="form-group">
						<label class="control-label col-sm-2" for="email">Name:</label>
						<div class="col-sm-10">
							<label class="control-label">{{ ($result['userList']->name) ? $result['userList']->name:'NO NAME' }}</label>
						</div>
						</div>
						<div class="form-group">
						<label class="control-label col-sm-2" for="email">Profile Image:</label>
						<div class="col-sm-10">
							<label class="control-label"><img src="{{$result['userList']->avatar_url}}" width="50" height="50" /></label>
						</div>
						</div>
						<div class="form-group">
						<label class="control-label col-sm-2" for="email">Followers Count:</label>
						<div class="col-sm-10">
							<label class="control-label">{{$result['userList']->followers}}</label>
						</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-sm-12 custom_ul">
				<ul id="followers_list">
			@if($result['followers'])
			@foreach($result['followers'] as $key => $follower)
				<li><img src="{{$follower->avatar_url}}" height="30" width="30" /></li>
			@endforeach
			@else
			<div class="row">No Followers Found</div>
			@endif

			</ul>
			<p>@if($result['userList']->followers>10)
				<button id="load_more" class="btn btn-default br-0">Load More</button>
			@endif</p>

			</div>

			
		@else
			<div class="row">No User Details Found</div>
		@endif
	</div>

<script>
$(document).ready(function(){
	var nextpage = {{($result['userList']->nextpage) ? $result['userList']->nextpage : 1}};
	$('#load_more').on('click', function () {
		
		 $.ajax({
           url : '{{ url("loadmore") }}',
           method : "GET",
           data : {'nextpage':nextpage,'username':'{{$result["userList"]->login}}'},
           //data : {_token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (data)
           {
           		
           		var followersList = jQuery.parseJSON( data );
           		var followers = '';
           		$.each(followersList.followers, function( index, value ) {
           			
				  	followers = followers+'<li><img src="'+value.avatar_url+'" height="30" width="30" /></li>';
				});
           		$('#followers_list').append(followers);
             	
           		if((nextpage*10) >={{$result['userList']->followers}})
           			$('#load_more').hide();
           		else
             		nextpage++;
           }
       });
	});
});

</script>
@endif