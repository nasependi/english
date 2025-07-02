@extends('layout.app')

@section('title', 'Assignment')

@section('content')
<main class="px-6 py-10">
    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-xl font-bold mb-4">Assignment List for: {{ $chapter->title }}</h2>

        @if($assignments->count())
        <ul class="space-y-4">
            @foreach($assignments as $assignment)
            <li class="p-4 bg-gray-100 rounded-md shadow">
                <div class="font-semibold">{!! $assignment->title !!}</div>
                <div class="text-sm text-gray-600">{!! $assignment->description !!}</div>
                <div class="text-sm text-gray-500">Deadline: {!! \Carbon\Carbon::parse($assignment->deadline)->format('d M Y H:i') !!}</div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="text-gray-500 italic">No assignments found for this chapter.</div>
        @endif
    </div>
</main>
@endsection