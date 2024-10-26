@extends('layout.master')
@section('title','Datagrid Test Solution | List Page')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="container mt-5">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('family.head.add') }}" class="btn btn-primary">Add Family Head</a>
            </div>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Total Member</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($familyHeadList as $key=>$head)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $head->full_name }}</td>
                            <td><img class="img-rounded" height="50" width="50" src="{{ ($head->medias && !file_exists(asset('uploads').$head->medias)) ? asset('uploads').$head->medias : asset('img/avatar.jpg') }}" /></td>
                            <td>{{ $head->mobile }}</td>
                            <td>{{ $head->address }}</td>
                            <td>{{ $head->dob }}</td>
                            <td><a href="{{ route('family.member.list',['head_id'=>$head->id]) }}">{{ $head->members_count }}</a></td>
                            <td><a href="{{ route('family.member.add',['head_id'=>$head->id]) }}" class="btn btn-primary">Add Family Member</a></td>
                        </tr>
                    @empty
                        <td>No Data Found</td>
                    @endforelse
                </tbody>
            </table>
            <ul class="pagination">
                {{ $familyHeadList->links('pagination::bootstrap-4') }}
            </ul>

        </div>
    </div>
</div>
@endsection
@section('page_script')
@endsection
