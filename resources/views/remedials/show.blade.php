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
        @if($user->type_id === 1 OR $user->type_id === 3)
        <p><b>Esitmated Price:</b> £{{$total}}</p>
        @endif
        <textarea style="height:auto;" id="contentTextarea" class="description" readonly>{{$remedial->description}}</textarea>
    </article>

    <aside>
        <h2>Marked as Approved?</h2>
        @if($remedial->approved === 0)
            <p>Not Approved</p>
            <button  onClick="openForm('approveRemedialForm', {{$remedial->id}})">Approve</button>
        @elseif($remedial->approved === 1)
            <p>Works Approved on {{date('j F Y, g:i a', strtotime($remedial->updated_at))}}</p>
            <p>Please consult the schedule for when the works are to be completed</p>
        @endif
    </aside>
</section>

<section class="remedialImages">
    @foreach($remedialImages as $image)
    <img src="/remedialPhotos/{{$image->file}}" alt="">
    @endforeach
</section>

<div class="hiddenForm" id="approveRemedialForm" style="display:none;">
    <h2>Approve Remedial</h2>
    <i onClick="closeForm('approveRemedialForm')" class="fa-regular fa-circle-xmark"></i>
    <p>Are you sure you want to approve this work? Once approved, it can not be changed.</p>

    <form action="{{ route('approveRemedial') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <input type="text" name="remedial_id" id="remedial_id" class="foreign_id" style="display:none;">

        <input style="width:70%; margin-left:15%;" type="submit" value="Approve">
    </form>
</div>

<script>
    var y = document.getElementById("remedialDetails");
    y.addEventListener("load", height());
    function height() {
        var x = document.getElementById("contentTextarea");
        x.style.height = x.scrollHeight + "px";
    }   
</script>
@endsection