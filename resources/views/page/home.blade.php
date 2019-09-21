@extends('layouts.master.home')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>No.</th>
            <th>Abbreviation</th>
            <th>Project name</th>
            <th>Donor</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ url($project->route) }}" class="text-bold text-brave">{{ str_replace("_"," ",strtoupper($project->project_short_name)) }}</a></td>
                <td>{{ str_replace("_"," ",ucfirst($project->project_name)) }}</td>
                <td>
                    <ol class="list-group">
                        @php
                            $doners = json_decode($project->donor, true);
                            foreach($doners as $doner){
                               echo '<option class="list-group-item">' .ucwords(str_replace("_"," ",$doner)). '</option>';
                            }
                        @endphp
                    </ol>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
