@extends('layouts.app')

@section('title', 'Location')

@section('content')
<section class="buttonsSection">
    @if($location->type == 'main') 
        <a href="/Hospitals/{{$location->hospital->id}}/Main"><i class="fa-solid fa-arrow-left"></i> Back</a>
    @elseif($location->type === 'community')
        <a href="/Hospitals/{{$location->hospital->id}}/Community"><i class="fa-solid fa-arrow-left"></i> Back</a>
    @endif

    <div>
        @if($user->type_id === 4)
            <button onClick="openForm('editLocationForm', '{{$location->id}}')">Edit</button>
            <button onClick="openDeleteForm('deleteLocationForm', {{$location->id}}, 'DeleteLocation')" class="delete">Delete</button>
        @elseif($user->type_id === 1)
            <button onClick="openForm('editLocationForm', '{{$location->id}}')">Edit</button>
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

@if (\Session::has('delete'))
    <div class="noAccess">
        <ul>
            <li>{!! \Session::get('delete') !!}</li>
        </ul>
    </div>
@endif

<section>
    <h1>{{$location->name}}</h1>
    <h2>{{$location->hospital->name}} - {{$location->type}}</h2>
</section>

@if($location->hospital->name === 'Ysbyty Gwynedd')
<section class="splitSection">
    <article class="halfSection">
        <table>
            <tr>
                <th>Boards</th>
                <th style="text-align:right;"><button onClick="openForm('newBoardForm', {{$location->id}})">Add New</button></th>
            </tr>
            @if($boards->count() > 0)
                @foreach($boards as $board)
                <tr>
                    <td><a href="/Hospitals/Boards/{{$board->id}}">{{$board->name}}  <i class="fa-solid fa-arrow-right"></i></a></td>
                    @if($board->test === null)
                        <td>
                            No Test Uploaded
                        </td>
                    @else
                        @if($board->test->result === "Satisfactory")
                            <td colspan="2" style="background-color: #1FC01D;">{{$board->test->result}}</td>
                        @elseif($board->test->result === "Unsatisfactory")
                            <td style="background-color: #C01D1F; color:white;">{{$board->test->result}}</td>
                        @endif
                    @endif
                </tr>
                @endforeach
            @else 
            <tr><td colspan="2">No Boards added yet</td></tr>
            @endif
        </table>

        <table>
            <tr>
                <th colspan="2">Scheduled Visits</th>
            </tr>
            @if($events->count() === 0)
            <tr>
                <td colspan="2">No visits currently scheduled</td>
                <td colspan="2"><a href="/Schedule">View the schedule to arrange a visit</a></td>
            </tr>
            @else
            @foreach($events as $event) 
            <tr>
                <td>{{date('j F Y', strtotime($event->start))}} - {{date('j F Y', strtotime($event->end))}}</td>
                <td>{{$event->hours}}</td>
            </tr>
            @endforeach
            @endif
        </table>
    </article>

    <article class="halfSection">
        <table>
            <tr>
                <th>Old CAD Drawings</th>
                <th style="text-align:right;"><button onClick="openForm('newDrawingForm', {{$location->id}})">Add New</button></th>
            </tr>
            @if($drawings->count() > 0)
                @foreach($drawings as $drawing)
                @if($drawing->version === 'Old')
                <tr>
                    <td colspan="2">
                        <a href="/Hospitals/DownloadDrawing/{{$drawing->id}}">{{$drawing->name}} <i class="fa-solid fa-download"></i></a>
                        @if($user->type_id === 4)
                        <i onClick="openDeleteForm('deleteDrawingForm', {{$drawing->id}}, 'DeleteDrawing')" style="float:right;" class="fa-solid fa-trash-can"></i>
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            @else
                <tr>
                    <td colspan="2">No Drawings Added</td>
                </tr>
            @endif
        </table>

        <table>
            <tr>
                <th>New CAD Drawings</th>
                <th style="text-align:right;"><button onClick="openForm('newDrawingForm', {{$location->id}})">Add New</button></th>
            </tr>

            @if($drawings->count() > 0)
                @foreach($drawings as $drawing)
                @if($drawing->version === 'New')
                <tr>
                    <td colspan="2">
                        <a href="/Hospitals/DownloadDrawing/{{$drawing->id}}">{{$drawing->name}} <i class="fa-solid fa-download"></i></a>
                        @if($user->type_id === 4)
                        <i onClick="openDeleteForm('deleteDrawingForm', {{$drawing->id}}, 'DeleteDrawing')" style="float:right;" class="fa-solid fa-trash-can"></i>
                        @endif
                    </td>                
                </tr>
                @endif
                @endforeach
            @else
                <tr>
                    <td colspan="2">No Drawings Added</td>
                </tr>
            @endif
        </table>
    </article>
</section>
@else 
<section class="splitSection">
    <article class="halfSection">
        <table>
            <tr>
                <th>Boards</th>
                <th style="text-align:right;"><button onClick="openForm('newBoardForm', {{$location->id}})">Add New</button></th>
            </tr>
            @foreach($boards as $board)
            <tr>
                <td><a href="/Hospitals/Boards/{{$board->id}}">{{$board->name}}  <i class="fa-solid fa-arrow-right"></i></a></td>
                @if($board->test === null)
                    <td>
                        No Test Uploaded
                        @if($user->type_id === 1 OR $user->type_id === 4 OR $user->type_id === 2)
                            <button onClick="openForm('newTestForm', '{{$board->id}}')">Upload Test</button>
                        @endif
                    </td>
                @else
                    @if($board->test->result === "Satisfactory")
                        <td colspan="2" style="background-color: #1FC01D;">{{$board->test->result}}</td>
                    @elseif($board->test->result === "Unsatisfactory")
                        <td style="background-color: #C01D1F; color:white;">{{$board->test->result}}</td>
                    @endif
                @endif
            </tr>
            @endforeach
        </table>
    </article>

    <article class="halfSection">
        <table>
            <tr>
                <th colspan="2">Scheduled Visits</th>
            </tr>
            @if($events->count() === 0)
            <tr>
                <td colspan="2">No visits currently scheduled</td>
            </tr>
            <tr>
                <td colspan="2"><a href="/Schedule">View the schedule to arrange a visit <i class="fa-solid fa-arrow-right"></i></a></td>
            </tr>
            
            @else
            @foreach($events as $event) 
            <tr>
                <td>{{date('j F Y', strtotime($event->start))}} - {{date('j F Y', strtotime($event->end))}}</td>
                <td>{{$event->hours}}</td>
            </tr>
            @endforeach
            @endif
        </table>
    </article>
</section>
@endif



<div class="hiddenForm" id="newBoardForm" style="display:none;">
    <h2>Add New Board</h2>
    <i onClick="closeForm('newBoardForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeBoard') }}" method="post">
        @include('includes.error', ['form' => 'newBoard'])
        <input type="text" name="location_id" id="location_id" class="foreign_id"  style="display:none;">

        <label for="name">Board Name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="newDrawingForm" style="display:none;">
    <h2>Upload New Drawing</h2>
    <i onClick="closeForm('newDrawingForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeDrawing') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'newDrawing'])

        <input type="text" name="location_id" id="location_id" class="foreign_id" style="display:none;">
        
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <input type="text" name="version" id="version" value="New" style="display:none;">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="oldDrawingForm" style="display:none;">
    <h2>Upload Old Drawing</h2>
    <i onClick="closeForm('oldDrawingForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeDrawing') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'newDrawing'])

        <input type="text" name="location_id" id="location_id" class="foreign_id" style="display:none;">
        
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <input type="text" name="version" id="version" value="Old" style="display:none;">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="editLocationForm" style="display:none;">
    <h2>Edit Location - {{$location->name}}</h2>
    <i onClick="closeForm('editLocationForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('editLocation') }}" method="post">
        @include('includes.error', ['form' => 'editLocation'])

        <input type="number" name="location_id" id="location_id" class="foreign_id" style="display:none;">

        <label for="name">Location Name:</label>
        <input type="text" name="name" id="name" value="{{$location->name}}">

        <label for="type">Location Type:</label>

        <select name="type" id="type">
            @if($location->type === 'main')
                <option value="main">Main</option>
                <option value="community">Community</option>
            @elseif($location->type === 'community')
                <option value="community">Community</option>
                <option value="main">Main</option>
            @endif
        </select>

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="deleteDrawingForm" style="display:none;">
    <h2>Delete Drawing</h2>
    <i onClick="closeForm('deleteDrawingForm')" class="fa-regular fa-circle-xmark"></i>

    <p>Are you sure you want to delete this drawing? Once it has been deleted, it can not be restored.</p>

    <form action="" method="post">
        @csrf
        @method('DELETE')
        <input class="delete" type="submit" value="Delete">
    </form>
    
</div>

<div class="hiddenForm" id="deleteLocationForm" style="display:none;">
    <h2>Delete Location</h2>
    <i onClick="closeForm('deleteLocationForm')" class="fa-regular fa-circle-xmark"></i>

    <p>Are you sure you want to delete this Location? By deleteing the location, you will also delete any data associated with it. Once it has been deleted, it can not be restored.</p>

    <form action="" method="post">
        @csrf
        @method('DELETE')
        <input class="delete" type="submit" value="Delete">
    </form>
    
</div>

@endsection