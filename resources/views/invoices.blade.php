@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
@if($user->type_id === 1)

<section>
    <a href="/Hospitals/Admin"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section>
    <h1>Invoices</h1>
</section>

<section>
    <table class="invoices">
        @foreach($tests as $test)
        <tr>
            <td>{{$test->name}}</td>
            <td>{{$test->board->name}}</td>
            <td>{{$test->board->location->name}}</td>
            <td>{{$test->board->location->hospital->name}}</td>
        </tr>
        @if($test->invoice === null)
        <tr>
            <td colspan="4">No Invoice added <button onClick="openForm('newInvoiceForm', {{$test->id}})">Add now</button></td>
        </tr>        
        @else 
        <tr>
            <td>Number: {{$test->invoice->invoiceNo}}</td>
            <td>{{date('d-M-Y g:ia', strtotime($test->invoice->sentDate))}}</td>
                @if($test->invoice->paid === 0)
                <td>Not Paid</td>
                <td><button>Mark as Paid</button></td>
                @elseif($test->invoice->paid === 1)
                <td>Paid</td>
                @endif
        </tr>
        @endif
        @endforeach
    </table>
</section>

<div class="hiddenForm" id="newInvoiceForm" style="display:none;">
    <h2>New Invoice</h2>
    <i onClick="closeForm('newInvoiceForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeInvoice') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <input type="text" name="test_id" id="test_id" class="foreign_id" style="display:none;">

        <label for="invoiceNo">Invoice Number:</label>
        <input type="text" name="invoiceNo" id="invoiceNo">

        <label for="sentDate">Date Sent:</label>
        <input type="datetime-local" name="sentDate" id="sentDate">

        <input type="submit" value="Save">
    </form>
</div>

@else
<section>
    <h1 style="text-align:center;">Sorry you do not have access to this page</h1>
</section>
@endif
@endsection