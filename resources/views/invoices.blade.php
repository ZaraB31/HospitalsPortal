@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
@if($user->type_id === 1)

<section>
    <h1>Invoices</h1>
</section>

<section>
    <table>
        @foreach($hospitals as $hospital)
        <tr>
            <th colspan="5">{{$hospital->name}}</th>
        </tr>
            @foreach($locations as $location)
            @if($location->hospital_id === $hospital->id)
            <tr style="background-color:#ACB2BA;">
                <td colspan="5">{{$location->name}}</td>
            </tr>
                @foreach($tests as $test)
                @if($test->board->location->id === $location->id)
                <tr>
                    <td>{{$test->name}}</td>
                    <td>{{$test->board->name}}</td>
                        @foreach($invoices as $invoice)
                        @if($invoice->test_id === $test->id)
                        <td>{{$invoice->invoiceNo}}</td>
                        <td>{{date('d-M-Y, g:ia', strtotime($invoice->sentDate))}}</td>
                            @if($invoice->paid === 0)
                            <td>Not Paid <button>Mark as Paid</button></td>
                            @elseif($invoice->paid === 1)
                            <td>Paid</td>
                            @endif
                        @else 
                        <td colspan="3">No Invoice added <button>Add now</button></td>
                        @endif
                        @endforeach
                </tr>
                @endif
                @endforeach
            @endif
            @endforeach
        @endforeach
    </table>
</section>


@else
<section>
    <h1 style="text-align:center;">Sorry you do not have access to this page</h1>
</section>
@endif
@endsection