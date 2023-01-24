@extends('layouts.app')

@section('title', 'Remedial Works Display')

@section('content')

<section>
    <a href="/Hospitals"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section>
    <h1>Remedial Works</h1>
</section>

<section id="remedialDetails">
    <h2>{{$remedial->test->board->location->hospital->name}} - {{$remedial->test->board->location->name}} - {{$remedial->test->board->name}}</h2>
    <p><b>Room:</b> {{$remedial->room}} <b style="margin-left:20px;">Circuit Number:</b> {{$remedial->circuitNo}}</p>
    <textarea style="height:auto;" id="contentTextarea" class="description" readonly>{{$remedial->description}}</textarea>
</section>

<section class="remedialImages">
    @foreach($remedialImages as $image)
    <img src="/remedialPhotos/{{$image->file}}" alt="">
    @endforeach
</section>

<script>
    var y = document.getElementById("remedialDetails");
    y.addEventListener("load", height());
    function height() {
        var x = document.getElementById("contentTextarea");
        x.style.height = x.scrollHeight + "px";
    }   
</script>
@endsection