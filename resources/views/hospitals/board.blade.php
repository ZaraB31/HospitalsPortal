@extends('layouts.app')

@section('title', 'Board')

@section('content')

<section class="buttonsSection">
    <a href="/Hospitals/Location/{{$board->location_id}}"><i class="fa-solid fa-arrow-left"></i> Back</a>
    
    <div>
        @if($user->type_id === 4)
            <button onClick="openForm('editBoardForm', '{{$board->id}}')">Edit</button>
            <button onClick="openDeleteForm('deleteBoardForm', {{$board->id}}, 'DeleteBoard')" class="delete">Delete</button>
        @elseif($user->type_id === 1)
            <button onClick="openForm('editBoardForm', '{{$board->id}}')">Edit</button>
        @endif
    </div>
</section>

@if (\Session::has('success'))
    <div class="messageSent">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<section>
    <h1>{{$board->name}}</h1>
    <p>{{$board->location->name}} - {{$board->location->hospital->name}}</p>
</section>

<section class="splitSection">
    <article class="halfSection">
        <table>
            <tr><th colspan="2">Test Details</th></tr>
            @if($board->test === null)
            <tr><td>No test uploaded yet</td>
                @if($user->type_id === 1 OR $user->type_id === 4 OR $user->type_id === 2)
                    <td><button onClick="openForm('newTestForm', '{{$board->id}}')">Upload Test</button></td>
                @endif
            </tr>
            @else
            <tr><td colspan="2">Test uploaded: {{date('j F Y, g:i a', strtotime($board->test->created_at))}}</td></tr>
            <tr><td colspan="2">Number of circuits: {{$board->test->circuits}}</td></tr>
            <tr><td colspan="2">Test Result: {{$board->test->result}}</td></tr>
            <tr><td colspan="2">Download file: <a href="/Hospitals/DownloadTest/{{$board->test->id}}">{{$board->test->file}} <i class="fa-solid fa-download"></i></a></td></tr>
            @if($user->type_id === 4)
            <tr><td colspan="2">
                <button onClick="openDeleteForm('deleteTestForm', {{$board->test->id}}, 'DeleteTest')" class="delete">Delete</button>
            </td></tr>
            @endif
            @endif
        </table>
        <table>
            <tr><th>Previous Tests</th>
                <th style="text-align: right;"><button onClick="openForm('oldTestForm', '{{$board->id}}')">Upload</button></th></tr>
            @if($oldTests->count() > 0)
            @foreach($oldTests as $oldTest)
                <tr><td colspan="2"><a href="/Hospitals/DownloadOldTest/{{$oldTest->id}}">{{$oldTest->file}} <i class="fa-solid fa-download"></i></a></td></tr>
            @endforeach
            @else
                <tr><td colspan="2">No previous tests uploaded</td></tr>
            @endif
        </table>
    </article>
    <article class="halfSection">
        <table>
            <tr><th>Circuit Layout Diagram</th></tr>
            @if($board->file === null)
            <tr><td>No evidence that a new circuit layout diagram has been installed.</td></tr>
            <tr><td><a onClick="openForm('circuitDiagramForm', '{{$board->id}}')">Upload photo evidence of diagram installation <i class="fa-solid fa-upload"></i></a></td></tr>
            @else
            <tr><td><img src="/circuitDiagrams/{{$board->file}}" alt=""></td></tr>
            <tr><td>Evidence Uploaded on {{date('j F Y, g:i a', strtotime($board->circuitLayout))}}</td></tr>
            @endif
        </table>

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

<div class="hiddenForm" id="newTestForm" style="display:none;">
    <h2>Upload Test</h2>
    <i onClick="closeForm('newTestForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeTest') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'newTest'])

        <input type="text" name="board_id" id="board_id" class="foreign_id" style="display:none;">
        
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <label for="circuits">Number of Circuits:</label>
        <input type="number" name="circuits" id="circuits">

        <label for="result">Result:</label>
        <select name="result" id="result">
            <option value="">Select...</option>
            <option value="Satisfactory">Satisfactory</option>
            <option value="Unsatisfactory">Unsatisfactory</option>
        </select>

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="oldTestForm" style="display:none;">
    <h2>Upload Old Test</h2>
    <i onClick="closeForm('oldTestForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeOldTest') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'oldTest'])

        <input type="text" name="board_id" id="board_id" class="foreign_id" style="display:none;">
        
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="circuitDiagramForm" style="display:none;">
    <h2>Upload evidence of circuit layout diagram installtion</h2>
    <i onClick="closeForm('circuitDiagramForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeCircuitDiagram') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'circuitDiagram'])

        <input type="text" name="board_id" id="board_id" class="foreign_id" style="display:none;">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="editBoardForm" style="display:none;">
    <h2>Edit Board - {{$board->name}}</h2>
    <i onClick="closeForm('editBoardForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('editBoard') }}" method="post">
        @include('includes.error', ['form' => 'editBoard'])
        <input type="text" name="board_id" id="board_id" class="foreign_id"  style="display:none;">

        <label for="name">Board Name:</label>
        <input type="text" name="name" id="name" value="{{$board->name}}">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="deleteTestForm" style="display:none;">
    <h2>Delete Test</h2>
    <i onClick="closeForm('deleteTestForm')" class="fa-regular fa-circle-xmark"></i>

    <p>Are you sure you want to delete this test? Once it has been deleted, it can not be restored.</p>

    <form action="" method="post">
        @csrf
        @method('DELETE')
        <input class="delete" type="submit" value="Delete">
    </form>
    
</div>

<div class="hiddenForm" id="deleteBoardForm" style="display:none;">
    <h2>Delete Board</h2>
    <i onClick="closeForm('deleteBoardForm')" class="fa-regular fa-circle-xmark"></i>

    <p>Are you sure you want to delete this board? By deleteing the board, you will also delete any data associated with it. Once it has been deleted, it can not be restored.</p>

    <form action="" method="post">
        @csrf
        @method('DELETE')
        <input class="delete" type="submit" value="Delete">
    </form>
    
</div>
@endsection