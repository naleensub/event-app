<!<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<title>Events Listing</title>
</head>
<body>
	<div class="container border border-secondary p-3">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page"><a href="{{route('events.index')}}">Home</a></li>
		  </ol>
		</nav>

		@php
		  if(!isset($eventFilter)) {
		  	$eventFilter = '';
		  }
		    
		@endphp
  	  <div class="row mt-4">
  	  	<div class="col">
  	  		<form method="POST" action="{{url('events/filter')}}">
			  @csrf
	  	  		<select name="eventfilter" id="eventfilter" class="form-select form-select-sm mb-3" style="width: 20%">
				  <option value="all" {{ ($eventFilter ==  'all') ? 'selected': ''}}>All</option>
				  <option value="finished" {{ ($eventFilter ==  'finished') ? 'selected': ''}}>Finished Events</option>
				  <option value="upcoming" {{ ($eventFilter ==  'upcoming') ? 'selected': ''}}>Upcoming Events</option>
				  <option value="events7" {{ ($eventFilter ==  'events7') ? 'selected': ''}}>Events within 7 days</option>
				  <option value="finished7" {{ ($eventFilter ==  'finished7') ? 'selected': ''}}>Finished events of the last 7 days</option>
				</select>
				@isset($events)
				@if(count($events) == 0 && count($finishedEvents) == 0 )
				  <button type="submit" name="search" id="search" class="btn btn-dark" disabled>Search</button>
				@else 
				  <button type="submit" name="search" id="search" class="btn btn-dark">Search</button>
				@endif
				@endisset
			</form>
			
  	  	</div>
  	  </div>

  	  <div class="row"><span><a href="{{url('events/create')}}" name="search" id="search" class="btn btn-primary">Add Event</a></span>
  	  </div>

  	  <div class="row mt-4 card">
  	  	  @if($eventFilter == 'all')
		    <div class="card-header">
		      All Events
		    </div>
	      @elseif($eventFilter == 'finished')
		    <div class="card-header">
		      Finished Events
		    </div>
	      @elseif($eventFilter == 'upcoming')
		    <div class="card-header">
		      Upcoming Events
		    </div>
	      @elseif($eventFilter == 'events7')
		    <div class="card-header">
		      Events within 7 days
		    </div>
	      @elseif($eventFilter == 'finished7')
		    <div class="card-header">
		     Finished events of the last 7 days
		    </div>
	      @else
	        <div class="card-header">
		     Ongoing Events
		    </div>
	      @endif
	  </div>

	  <div class="row mt-4 border border-info">
	    <div class="col text-primary">
	      Title
	    </div>
	    <div class="col text-primary">
	      Description
	    </div>
	    <div class="col text-primary">
	      Start Date
	    </div>
	    <div class="col text-primary">
	      End Date
	    </div>
	    <div class="col text-primary">
	      &nbsp;
	    </div>
	  </div>

	  @isset($events)
	  	  @if(count($events)==0)
		  	  <div class="row border border-info">
		  	  	<p>No Data</p>
		  	  </div>	  	  	
	  	  @endif
		  @foreach ($events as $event)
			  <div class="row pt-2 border border-light" id="del-{{ $event->id }}">
			    <div class="col">
			      {{ $event->title }}
			    </div>
			    <div class="col">
			      {{ $event->description }}
			    </div>
			    <div class="col">
			      {{ $event->start_date }}
			    </div>
			    <div class="col">
			      {{ $event->end_date }}
			    </div>
			    <div class="col">
			       <a href="{{ url('events/'.$event->id) }}" class="btn btn-success">view</a>
			      <a href="{{ url('events/'.$event->id.'/edit') }}" class="btn btn-info">Edit</a>
			      <form method="POST" class="deletefrmdata" action="{{url('events/'.$event->id)}}">
			      	<input type="hidden" id="csrftoken" name="_token" value="{{ csrf_token() }}" />
			  		@method('DELETE')
			     	<button type="submit" class="btn btn-danger delbutton mt-2" id="delevents{{ $event->id }}" value="{{ $event->id }}">Delete</button>
			 	</form>
			    </div>
			  </div>
		  @endforeach
	  @endisset

	  @isset($finishedEvents)
		  <div class="row mt-4 card">
		    <div class="card-header">
		      Finished Events
		    </div>
		  </div>
		  <div class="row mt-4 border border-info">
		    <div class="col text-primary">
		      Title
		    </div>
		    <div class="col text-primary">
		      Description
		    </div>
		    <div class="col text-primary">
		      Start Date
		    </div>
		    <div class="col text-primary">
		      End Date
		    </div>
		    <div class="col text-primary">
		      &nbsp;
		    </div>
		  </div>
	  @endisset

	  @isset($finishedEvents)
	  	  @if(count($finishedEvents) == 0 )
		  	  <div class="row border border-info">
		  	  	<p>No Data</p>
		  	  </div>	  	  	
	  	  @endif
		  @foreach ($finishedEvents as $finishedEvent)
			  <div class="row pt-2 border border-light" id="del-{{ $finishedEvent->id }}">
			    <div class="col">
			      {{ $finishedEvent->title }}
			    </div>
			    <div class="col">
			      {{ $finishedEvent->description }}
			    </div>
			    <div class="col">
			      {{ $finishedEvent->start_date }}
			    </div>
			    <div class="col">
			      {{ $finishedEvent->end_date }}
			    </div>
			    <div class="col">
			       <a href="{{ url('events/'.$finishedEvent->id) }}" class="btn btn-success">view</a>
			      <a href="{{ url('events/'.$finishedEvent->id.'/edit') }}" class="btn btn-info">Edit</a>
			      <form method="POST" class="deletefrmdata" action="{{url('events/'.$finishedEvent->id)}}">
			      	<input type="hidden" id="csrftoken" name="_token" value="{{ csrf_token() }}" />
			  		@method('DELETE')
			     	<button type="submit" class="btn btn-danger delbutton mt-2" id="delevents{{ $finishedEvent->id }}" value="{{ $finishedEvent->id }}">Delete</button>
			 	</form>
			    </div>
			  </div>
		  @endforeach
	  @endisset 
	</div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$('.deletefrmdata').submit(function(e){
		var csrf_token = $('#csrftoken').val();
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': csrf_token
	        }
	    });
		e.preventDefault();

		var id = $('.delbutton').val();
		var ajax_del_url = $(this).attr('action');

		$.ajax({
			type: 'DELETE',
			url: ajax_del_url,
			data: {'id': id},
			dataType: 'JSON',

			success: function(data) {
				if(data.success == true){
					var delId = data.id;
					$('#del-'+delId).remove();
				}
			}

		});
	});
</script>

