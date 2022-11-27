<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<title>Edit Event</title>
</head>
<body>
	<div class="container">
			<div class="row mt-4">
				 <label for="title" class="form-label">Title</label>
				<div>{{ $event->title }}</div>
			</div>

			<div class="row mt-4">
				<label for="description" class="form-label">Description</label>
				<div>{{ $event->description }}</div>
			</div>


			<div class="row mt-4">
				<label for="start_date" class="form-label">Start Date</label>
				<div>{{ $event->start_date }}</div>
			</div>

			<div class="row mt-4">
				<label for="end_date" class="form-label">End Date</label>
				<div>{{ $event->end_date }}</div>
			</div>

			<div class="row mt-4">
				<div><a href="{{route('events.index')}}" name="back" id="back" class="btn btn-danger">Back</a></div>
			</div>
		
	</div>
</body>
</html>