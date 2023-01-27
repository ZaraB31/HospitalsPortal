@extends('layouts.app')

@section('title', 'Remedial Works Display')

@section('content')

<section>
    <a href="/Hospitals/Board/Remedials"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section id="remedialDetails">
    <article>
        <h2>{{$remedial->board->location->hospital->name}} - {{$remedial->board->location->name}} - {{$remedial->board->name}}</h2>
        <p><b>Room:</b> {{$remedial->room}} <b style="margin-left:20px;">Circuit Number:</b> {{$remedial->circuitNo}}</p> 
        <p><b>Estimated Completion Date:</b> {{date('j F Y, g:i a', strtotime($remedial->created_at))}}</p>
        <p><b>Defect(s):</b> @foreach($remedialPrices as $defect) {{$defect->price->defect}},@endforeach</p>
        <textarea style="height:auto;" id="contentTextarea" class="description" readonly>{{$remedial->description}}</textarea>
    </article>

    <aside>
        <h2>Marked as Approved?</h2>
        @if($remedial->approved === 0)
            <p>Not Approved</p>
            <button>Approve</button>
        @elseif($remedial->approved === 1)
            <p>Works Approved</p>
        @endif
    </aside>
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