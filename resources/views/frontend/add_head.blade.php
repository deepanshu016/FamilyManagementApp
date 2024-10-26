@extends('layout.master')
@section('title','Datagrid Test Solution | List Page')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('family.list.view') }}" class="btn btn-primary">Back</a>
    </div>
    <h2>Family Head Information</h2>
    <form id="familyHeadForm" action="{{ route('family.head.save') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                <span id="name_error" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname">
                <span id="surname_error" class="text-danger"></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="dob" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="dob" name="dob" placeholder="Birthdate">
                <span id="dob_error" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="mobile" class="form-label">Mobile No</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile No">
                <span id="mobile_error" class="text-danger"></span>
            </div>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Address"></textarea>
            <span id="address_error" class="text-danger"></span>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="state" class="form-label">State</label>
                <select class="form-select" id="state" name="state">
                    <option value="">Choose...</option>
                    <option value="IN">India</option>
                </select>
                <span id="state_error" class="text-danger"></span>
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City</label>
                <select class="form-select" id="city" name="city">
                    <option value="">Choose...</option>
                    <option value="1">City 1</option>
                    <option value="2">City 2</option>
                </select>
                <span id="city_error" class="text-danger"></span>
            </div>
            <div class="col-md-4">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" class="form-control" id="pincode" name="pincode">
                <span id="pincode_error" class="text-danger"></span>
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
            <label class="form-label">Hobbies</label>
            <div id="hobbies_wrapper">
                <div class="input-group mb-2 hobby-input">
                    <input type="text" class="form-control" name="hobbies[]" placeholder="Enter a hobby">
                </div>
            </div>
            <button type="button" id="add_new_hobby" class="btn btn-secondary mt-2">Add Hobby</button>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            <span id="photo_error" class="text-danger"></span>
        </div>

        <button type="submit" class="btn btn-primary">
            Save
            <div class="spinner-border" role="status" style="height: 19px;width: 20px;;display:none;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </button>
    </form>
</div>
@endsection
@section('page_script')

<script>
    $(document).ready(function() {
        $('body').on('click','#add_new_hobby',function() {
            $('#hobbies_wrapper').append(`
                <div class="input-group mb-2 hobby-input">
                    <input type="text" class="form-control" name="hobbies[]" placeholder="Enter a hobby">
                    <button type="button" class="btn btn-danger remove-hobby">Remove</button>
                </div>
            `);
        });

        $('#hobbies_wrapper').on('click', '.remove-hobby', function() {
            $(this).closest('.hobby-input').remove();
        });

        $('body').on('change','#dob', function() {
            const birthDate = new Date($(this).val());
            const isOldEnough = checkAge(birthDate, 21);
            $(this).toggleClass('is-invalid', !isOldEnough);
            if (!isOldEnough) $('#dob_error').html('Must be at least 21 years old.');
        });
        function checkAge(birthDate, minAge) {
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            return age > minAge || (age === minAge && today >= new Date(birthDate.setFullYear(birthDate.getFullYear() + minAge)));
        }
        $("body").on('submit','#familyHeadForm',function(e){
            e.preventDefault();
            if (!clientSideValidation()) return;
            const formData = new FormData(this);
            const url = $(this).attr('action');
            const method = $(this).attr('method');
            CommonLib.ajaxForm(formData, method, url).then(d => {
                CommonLib.notification[d.status === 200 ? 'success' : 'error'](d.msg);
                if (d.status === 200) setTimeout(() => window.location = d.url, 1000);
            }).catch(e => handleErrors(e.responseJSON));
        });
        function clientSideValidation() {
            let isValid = true;
            const fields = {
                name: {
                    value: $('#name').val().trim(),
                    error: '#name_error',
                    message: 'Name is required.'
                },
                surname: {
                    value: $('#surname').val().trim(),
                    error: '#surname_error',
                    message: 'Surname is required.'
                },
                dob: {
                    value: $('#dob').val(),
                    error: '#dob_error',
                    message: 'Must be at least 21 years old.', validate: val => checkAge(new Date(val), 21)
                },
                mobile: {
                    value: $('#mobile').val().trim(),
                    error: '#mobile_error',
                    message: 'Enter a valid 10-digit mobile number.',
                    pattern: /^\d{10}$/ },
                address: {
                    value: $('#address').val().trim(),
                    error: '#address_error',
                    message: 'Address is required.'
                },
                state: {
                    value: $('#state').val(),
                    error: '#state_error',
                    message: 'Please select a state.'
                },
                city: {
                    value: $('#city').val(),
                    error: '#city_error',
                    message: 'Please select a city.'
                },
                pincode: {
                    value: $('#pincode').val().trim(),
                    error: '#pincode_error',
                    message: 'Enter a valid 6-digit pincode.',
                    pattern: /^\d{6}$/ },
                marital_status: {
                    value: $('input[name="marital_status"]:checked').val(),
                    error: '#marital_status_error',
                    message: 'Please select your marital status.'
                }
            };
            $('.text-danger').html('');
            // Validate Name
            $.each(fields, (key, field) => {
                if (!field.value || (field.pattern && !field.pattern.test(field.value)) || (field.validate && !field.validate(field.value))) {
                    $(field.error).html(field.message);
                    isValid = false;
                }
            });
            if (fields.marital_status.value === 'married' && !$('#wedding_date').val()) {
                $('#wedding_date_error').html('Please provide your wedding date.');
                isValid = false;
            }
            return isValid;
        }
        function handleErrors(responseJSON) {
            if (responseJSON && responseJSON.errors) {
                $.each(responseJSON.errors, (key, messages) => $(`#${key}_error`).html(messages));
            } else {
                CommonLib.notification.error('An unexpected error occurred.');
            }
        }

        // Age checker function
        function checkAge(birthDate, minAge) {
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            return age > minAge || (age === minAge && today >= new Date(birthDate.setFullYear(birthDate.getFullYear() + minAge)));
        }
    });
</script>
@endsection
