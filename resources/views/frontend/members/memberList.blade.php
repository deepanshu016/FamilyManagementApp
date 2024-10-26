@extends('layout.master')
@section('title','Datagrid Test Solution | List Page')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="container mt-5">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('family.list.view') }}" class="btn btn-primary">Back</a>
            </div>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Marital Status</th>
                        <th scope="col">DOB</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($familyMemberList as $key=>$member)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $member->name }}</td>
                            <td><img class="img-rounded" height="50" width="50" src="{{ ($member->medias && !file_exists(asset('uploads').$member->medias)) ? asset('uploads').$member->medias : asset('img/avatar.jpg') }}" /></td>

                            <td>{{ $member->marital_status }}</td>
                            <td>{{ date('j F Y',strtotime($member->dob)) }}</td>
                        </tr>
                    @empty
                        <td>No Data Found</td>
                    @endforelse
                </tbody>
            </table>
            <ul class="pagination">
                {{ $familyMemberList->links('pagination::bootstrap-4') }}
            </ul>
        </div>
    </div>
</div>
@endsection
@section('page_script')
@endsection
