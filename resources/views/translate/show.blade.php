@extends('layouts.app')
@section('content')
    <div id="content">
        <table id='pouetbox_userlist' class='boxtable pagedtable'>
            <thead>
            <th>group</th>
            <th>item</th>
            <th>basis ({{$loc1}})</th>
            <th>ziel ({{$loc2}})</th>
            </thead>
            @foreach($list as $l)
                <tr>
                    <td>{{ $l->group }}</td>
                    <td>{{ $l->item }}</td>
                    <td>{{ $l->text }}</td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection