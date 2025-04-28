@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Activity Log</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Subject</th>
                <th>Causer</th>
                <th>Event</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->id }}</td>
                <td>{{ $activity->description }}</td>
                <td>
                    @if($activity->subject)
                    {{ class_basename($activity->subject) }} #{{ $activity->subject->id }}
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    @if($activity->causer)
                    {{ class_basename($activity->causer) }} #{{ $activity->causer->id }}
                    @else
                    N/A
                    @endif
                </td>
                <td>{{ $activity->event }}</td>
                <td>{{ $activity->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection