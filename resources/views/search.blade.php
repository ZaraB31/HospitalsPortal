@extends('layouts.app')

@section('title', 'Search')

@section('content')
<section>
    <h1>Search for a location</h1>
</section>

<section>
    <form action="" method="POST">
        @csrf

        <input type="text" name="search" id="search" placeholder='Search...'>
    </form>
</section>

<section>
    <table>
        <thead>
            <tr>
                <th>Location</th>
                <th>Hospital</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</section>

<script>
    $('#search').on('keyup', function() {
        search();
    });

    function search() {
        var keyword = $('#search').val();
        $.ajax({
            type: "POST",
            url: '/Search',
            data: { keyword: keyword, _token: '{{csrf_token()}}' },
            success: function(data) {
                table_post_row(data);
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);

            },
        });
    }

    function table_post_row(res) {
        let htmlView = '';

        if(res.locations.length <= 0) {
            htmlView+= '<tr> <td colspan="2">No Results Found</td> </tr>'
        }

        for (let i = 0; i < res.locations.length; i++) {
            htmlView+= '<tr> <td><a href="/Hospitals/Location/' +res.locations[i].locationID+ '">' +res.locations[i].name+ '<i class="fa-solid fa-arrow-right"></i></a></td> <td>' +res.locations[i].hospital+ '</td> </tr>'
        }

        $('tbody').html(htmlView);
    }
</script>
@endsection