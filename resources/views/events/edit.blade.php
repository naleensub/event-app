<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	<style type="text/css">
		label.error {
		  color: #a94442;
		  border-color: #ebccd1;
		}
	</style>
	<title>Edit Event</title>
</head>
<body>
	<div class="container">
		@if($successmsg = Session::get('success'))
			<div class="alert alert-success">
				{{ $successmsg }}
			</div>
		@endif

		<form method="POST" action="{{url('events/'.$event->id)}}" id="eventedit">
			  @csrf
			  @method('PUT')
			<div class="row mt-4">
				 <label for="title" class="form-label">Title</label>
				<div><input type="text" class="form-control" name="title" id="title" value="{{ $event->title }}" required></div>
				@error('title')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			</div>

			<div class="row mt-4">
				<label for="description" class="form-label">Description</label>
				<div><input type="text" class="form-control" name="description" id="description" value="{{ $event->description }}" required></div>
				@error('description')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			</div>


			<div class="row mt-4">
				<label for="start_date" class="form-label">Start Date</label>
				<div><input type="text" class="form-control" name="start_date" id="start_date" value="{{ $event->start_date }}" required></div>
				@error('start_date')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			</div>

			<div class="row mt-4">
				<label for="end_date" class="form-label">End Date</label>
				<div><input type="text" class="form-control" name="end_date" id="end_date" value="{{ $event->end_date }}" required></div>
				@error('end_date')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			</div>

			<div class="row mt-4">
				<div>
					<button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
					<a href="{{route('events.index')}}" name="back" id="back" class="btn btn-danger">Back</a>
				</div>
			</div>
		</form>
		
	</div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
	 	$("#start_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	 	$("#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	});

	$("#eventedit").validate({
		rules: {
			title: {
			  required: true,
			  maxlength: 255,
			},
			description: {
			  required: true,
			},
			start_date: {
			  required: true,
			  date: true,
			},
			end_date: {
			  required: true,
			  date: true,
			},
		},
		messages: {
			title: {
			  required: "Title is required",
			  maxlength: "Title could not be more than 255 characters",
			},
			description: {
			  required: "Description is required",
			},
			start_date: {
			  required: "Start Date is required",
			  date: "Please enter valid date",
			},
			end_date: {
			  required: "End Date is required",
			  date: "Please enter valid date",
			},
		},
	})
</script>