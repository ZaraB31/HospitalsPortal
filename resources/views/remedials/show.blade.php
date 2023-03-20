@extends('layouts.app')

@section('title', 'Remedial Works Display')

@section('content')

<section class="buttonsSection">
    <a href="/Hospitals/Board/Remedials"><i class="fa-solid fa-arrow-left"></i> Back</a>

    <div>
        @if($user->type_id === 4)
            <button onClick="openForm('editRemedialForm', {{$remedial->id}})">Edit</button>
            <button onClick="openDeleteForm('deleteRemedialForm', {{$remedial->id}}, 'DeleteRemedial')" class="delete">Delete</button>
        @elseif($user->type_id === 1)
            <button onClick="">Edit</button>
        @endif
    </div>
</section>

<section id="remedialDetails">
    <article>
        <h2>{{$remedial->board->location->hospital->name}} - {{$remedial->board->location->name}} - {{$remedial->board->name}}</h2>
        <p><b>Room:</b> {{$remedial->room}} <b style="margin-left:20px;">Circuit Number:</b> {{$remedial->circuitNo}}</p> 
        <p><b>Estimated Completion Date:</b> {{date('j F Y, g:i a', strtotime($remedial->created_at))}}</p>
        <p><b>Defect(s):</b> @foreach($remedialPrices as $defect) {{$defect->price->defect}},@endforeach</p>
        @if($user->type_id === 1 OR $user->type_id === 4 OR $user->type_id === 3)
        <p><b>Esitmated Price:</b> £{{$total}}</p>
        @endif
        <textarea style="height:auto;" id="contentTextarea" class="description" readonly>{{$remedial->description}}</textarea>
    </article>

    <aside>
        <div>
            <h2>Marked as Approved?</h2>
            @if($remedial->approved === 0)
                <p>Not Approved</p>
                <button  onClick="openForm('approveRemedialForm', {{$remedial->id}})">Approve</button>
            @elseif($remedial->approved === 1)
                <p>Works Approved on {{date('j F Y, g:i a', strtotime($remedial->updated_at))}}</p>
                <p>Please consult the schedule for when the works are to be completed</p>
            @endif
        </div>

        <div>
            <h2>Marked as Completed?</h2>
            @if($remedial->completed === 0)
                <p>Not Completed</p>
                <button onClick="openForm('completeRemedialForm', {{$remedial->id}})">Complete</button>
            @elseif($remedial->completed === 1)
                <p>Works completed on {{date('j F Y, g:i a', strtotime($remedial->updated_at))}}</p>
            @endif
        </div>
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
        @csrf

        <input type="text" name="remedial_id" id="remedial_id" class="foreign_id" style="display:none;">

        <input style="width:70%; margin-left:15%;" type="submit" value="Approve">
    </form>
</div>

<div class="hiddenForm" id="completeRemedialForm" style="display:none;">
    <h2>Complete Remedial</h2>
    <i onClick="closeForm('completeRemedialForm')" class="fa-regular fa-circle-xmark"></i>
    <p>Are you sure you want to complete this work? Once completed, it can not be changed.</p>

    <form action="{{ route('completeRemedial') }}" method="post" enctype="multipart/form-data">
        @csrf

        <input type="text" name="remedial_id" id="remedial_id" class="foreign_id" style="display:none;">

        <input style="width:70%; margin-left:15%;" type="submit" value="Complete">
    </form>
</div>

<div class="hiddenForm" id="editRemedialForm" style="display:none;">
    <h2>Edit Remedial</h2>
    <i onClick="closeForm('editRemedialForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('editRemedial') }}" method="post">
        @include('includes.error', ['form' => 'editRemedial'])

        <input type="text" name="remedial_id" id="remedial_id" class="foreign_id" style="display:none;">

        <label for="circuitNo">Circuit Number:</label>
        <input type="number" name="circuitNo" id="circuitNo" value="{{$remedial->circuitNo}}">

        <label for="room">Room:</label>
        <input type="text" name="room" id="room" value="{{$remedial->room}}">

        <label for="description">Description:</label>
        <textarea name="description" id="description">{{$remedial->description}}</textarea>

        <label for="estimatedCompletion">Estimated Completion Date:</label>
        <input type="date" name="estimatedCompletion" id="estimatedCompletion" value="{{date('Y-m-d', strtotime($remedial->estimatedCompletion))}}">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="deleteRemedialForm" style="display:none;">
    <h2>Delete Remedial</h2>
    <i onClick="closeForm('deleteRemedialForm')" class="fa-regular fa-circle-xmark"></i>

    <p>Are you sure you want to delete this remedial? By deleteing the remedial, you will also delete any data associated with it. Once it has been deleted, it can not be restored.</p>

    <form action="" method="post">
        @csrf
        @method('DELETE')
        <input class="delete" type="submit" value="Delete">
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