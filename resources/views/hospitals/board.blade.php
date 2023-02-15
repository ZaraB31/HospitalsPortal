@extends('layouts.app')

@section('title', 'Board')

@section('content')

<section>
    @if($board->location->type === 'main')
        <a href="/Hospitals/{{$board->location->hospital->id}}/Main"><i class="fa-solid fa-arrow-left"></i> Back</a>
    @elseif($board->location->type === 'community')
        <a href="/Hospitals/{{$board->location->hospital->id}}/Community"><i class="fa-solid fa-arrow-left"></i> Back</a>
    @endif
</section>

<section>
    <h1>{{$board->name}}</h1>
    <p>{{$board->location->name}} - {{$board->location->hospital->name}}</p>
</section>

<section class="splitSection">
    <article class="halfSection">
        <table>
            <tr><th>Test Details</th></tr>
            @if($board->test === null)
            <tr><td>No test uploaded yet</td></tr>
            @else
            <tr><td>Test uploaded: {{date('j F Y, g:i a', strtotime($board->test->created_at))}}</td></tr>
            <tr><td>Number of circuits: {{$board->test->circuits}}</td></tr>
            <tr><td>Test Result: {{$board->test->result}}</td></tr>
            <tr><td>Download file: <a href="/Hospitals/DownloadTest/{{$board->test->id}}">{{$board->test->file}} <i class="fa-solid fa-download"></i></a></td></tr>
            @endif
        </table>
        <table>
            <tr><th>Previous Tests</th></tr>
            @if($board->oldTests === 0)
            <tr><td>No previous tests uploaded</td></tr>
            @else
            @foreach($oldTests as $oldTest)
            <tr><td><a href="/Hospitals/DownloadOldTest/{{$oldTest->id}}">{{$oldTest->file}} <i class="fa-solid fa-download"></i></a></td></tr>
            @endforeach
            @endif
        </table>
    </article>
    <article class="halfSection">
        <table>
            <tr><th>Downloads</th></tr>
            @if($downloads->count() > 0)
            @foreach($downloads as $download)
            @if($download->test_id === $board->test->id)
            <tr><td>Downloaded by {{$download->user->name}} at {{date('j F Y, g:i a', strtotime($download->created_at))}}</td></tr>
            @endif
            @endforeach
            @else 
            <tr><td>The file has not been downloaded</td></tr>
            @endif
        </table>
    </article>
</section>
@endsection