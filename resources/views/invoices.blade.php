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
            <td style="width:45%">{{$test->board->location->hospital->name}} - {{$test->board->location->name}} - {{$test->board->name}} - {{$test->name}}</td>
            @if($test->invoice === null)
            <td>No Invoice added</td> 
            <td colspan="2"><button onClick="openForm('newInvoiceForm', {{$test->id}})">Add now</button></td>        
            @else 
            <td>Number: {{$test->invoice->invoiceNo}}</td>
            <td>Sent: {{date('d-M-Y', strtotime($test->invoice->sentDate))}}</td>
                @if($test->invoice->paid === 0)
                <td><button onClick="openForm('newPaidInvoiceForm', {{$test->invoice->id}})">Mark as Paid</button></td>
                @elseif($test->invoice->paid === 1)
                <td>Paid</td>
                @endif
            @endif
        </tr>
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

<div class="hiddenForm" id="newPaidInvoiceForm" style="display:none;">
    <h2>Are you sure you want to mark this invoice as paid?</h2>
    <i onClick="closeForm('newPaidInvoiceForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('paidInvoice') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <input type="text" name="invoice_id" id="invoice_id" class="foreign_id" style="display:none;">

        <input style="width:50%; margin-left:25%;" type="submit" value="Mark As Paid">
    </form>
</div>

@else
<section>
    <h1 style="text-align:center;">Sorry you do not have access to this page</h1>
</section>
@endif
@endsection