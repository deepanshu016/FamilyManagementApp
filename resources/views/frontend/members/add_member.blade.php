@extends('layout.master')
@section('title','Datagrid Test Solution | List Page')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('family.list.view') }}" class="btn btn-primary">Back</a>
    </div>
    <h2>Family Member Information</h2>
    <form id="familyMemberForm" action="{{ route('family.member.save') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                <input type="hidden" class="form-control" name="parent_id" value="{{ $headId }}">
                <span id="name_error" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="dob" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="dob" name="dob" placeholder="Birthdate">
                <span id="dob_error" class="text-danger"></span>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Marital Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="marital_status" id="married" value="married">
                    <label class="form-check-label" for="married">Married</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="marital_status" id="unmarried" value="unmarried">
                    <label class="form-check-label" for="unmarried">Unmarried</label>
                </div>
            </div>
            <span id="marital_status_error" class="text-danger"></span>
        </div>

        <div class="row mb-3" id="wedding_date_wrapper" style="display: none;">
            <div class="col-md-6">
                <label for="wedding_date" class="form-label">Wedding Date</label>
                <input type="date" class="form-control" id="wedding_date" name="wedding_date">
                <span id="wedding_date_error" class="text-danger"></span>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Education</label>
            <input type="text" class="form-control" name="education" id="education"  placeholder="Enter a Education">
            <span id="education_error" class="text-danger"></span>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            <span id="photo_error" class="text-danger"></span>
        </div>

        <button type="submit" class="btn btn-primary">
            Save
            <div class="spinner-border" role="status" style="height: 19px;width: 20px;display:none;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </button>
    </form>
</div>
@endsection
@section('page_script')

<script>
    $(document).ready(function() {

        $("body").on('submit','#familyMemberForm',function(e){
            e.preventDefault();
            if (!clientSideValidation()) return;
            formData = new FormData(this);
            const url = $(this).attr('action');
            const method = $(this).attr('method');
            CommonLib.ajaxForm(formData, method, url).then(d => {
                CommonLib.notification[d.status === 200 ? 'success' : 'error'](d.msg);
                if (d.status === 200) setTimeout(() => window.location = d.url, 1000);
            }).catch(e => handleErrors(e.responseJSON));

        });
        function handleErrors(responseJSON) {
            if (responseJSON && responseJSON.errors) {
                $.each(responseJSON.errors, (key, messages) => $(`#${key}_error`).html(messages));
            } else {
                CommonLib.notification.error('An unexpected error occurred.');
            }
        }
        function clientSideValidation() {
            let isValid = true;
            const fields = {
                name: {
                    value: $('#name').val().trim(),
                    error: '#name_error',
                    message: 'Name is required.'
                },
                dob: {
                    value: $('#dob').val(),
                    error: '#dob_error',
                    message: 'Birthday is required'
                },
                education: {
                    value: $('#education').val(),
                    error: '#education_error',
                    message: 'Education is required.'
                },
                maritalStatus: {
                    value: $('input[name="marital_status"]:checked').val(),
                    error: '#marital_status_error',
                    message: 'Please select your marital status.'
                }
            };
            $('.text-danger').html('');
            for (const field in fields) {
                if (!fields[field].value) {
                    $(fields[field].error).html(fields[field].message);
                    isValid = false;
                }
            }
            // Additional validation for wedding date if married
            if (fields.maritalStatus.value === 'married' && !$('#wedding_date').val()) {
                $('#wedding_date_error').html('Please provide your wedding date.');
                isValid = false;
            }
            return isValid;
        }
    });
</script>
@endsection
