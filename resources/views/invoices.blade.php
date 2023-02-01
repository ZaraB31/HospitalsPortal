@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
@if($user->type_id === 1)

<section>
    <a href="/Hospitals/Admin"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<button class="createButton" onClick="openForm('newInvoiceForm', '0')"><i class="fa-solid fa-plus"></i></button>

<section>
    <h1>Invoices</h1>
</section>

<section class="invoiceDetails">
    @foreach($invoices as $invoice)
        <div>
            <p><b>Invoice Number:</b> {{$invoice->invoiceNo}}</p>
            <p><b>Sent Date:</b> {{date('j F Y, g:i a', strtotime($invoice->sentDate))}}</p>
            @if($invoice->paid === 0)
            <p style="margin-bottom:0;"><b>Paid:</b> Not Paid</p>
            <button style="width:100%; margin:10px 0; color:white;" onClick="openForm('newPaidInvoiceForm', {{$invoice->id}})">Mark as Paid</button>
            @elseif($invoice->paid === 1)
            <p><b>Paid:</b> Paid</p>
            @endif
            <p>{{$invoice->details}}</p>
        </div>
    @endforeach
</section>

<div class="hiddenForm" id="newInvoiceForm" style="display:none;">
    <h2>New Invoice</h2>
    <i onClick="closeForm('newInvoiceForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeInvoice') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <label for="invoiceNo">Invoice Number:</label>
        <input type="text" name="invoiceNo" id="invoiceNo">

        <label for="sentDate">Date Sent:</label>
        <input type="datetime-local" name="sentDate" id="sentDate">

        <label for="details">Details:</label>
        <textarea name="details" id="details"></textarea>

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