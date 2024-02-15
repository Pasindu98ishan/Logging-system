@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="message"></div>
            <div class="card">
                <p style="margin-left: 10px;">
                    <a href="{{ route('home') }}"> Home</a> / Users
                </p>
                <div class="card-body">
                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table id="user-table" class="table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th><a href="#" onclick="sortUsers('user_name')">User Name</a></th>
                                    <th><a href="#" onclick="sortUsers('name')">Name</a></th>
                                    <th><a href="#" onclick="sortUsers('email')">Email</a></th>
                                    <th>User Type</th>
                                    <th>User Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">User Preview</h5>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function fetchDataToTable(response) {
        $('#user-table tbody').empty();
        for (let user of response) {
            var buttonLabel = user.status === 'inactive' ? 'Activate' : 'Deactivate';
            var row = `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.user_name}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.user_type}</td>
                    <td>${user.status}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="User Actions">
                            <style>
                                .fixed-size-button {
                                    width: 100px; 
                                    height: 40px; 
                                }
                            </style>
                            <button type="button" class="btn btn-primary" onclick="openModal(${user.id})">Preview</button>
                            <button type="button" class="btn btn-danger fixed-size-button"  onclick="deactivate(${user.id}, this)">${buttonLabel}</button>
                        </div>
                    </td>
                </tr>`;
            $('#user-table tbody').append(row);
        }
    }

    function fetchUserData() {
        $.ajax({
            url: '/api/user',
            type: 'GET',
            success: function(response) {
                fetchDataToTable(response);
            },
            error: function(error) {
                console.error('Error fetching user data:', error);
            }
        });
    }

    fetchUserData();

    function deactivate(id) {
        var messageElement = document.getElementById('message');
        $.ajax({
            url: '/api/users/deactivate/' + id,
            type: 'PUT',
            success: function(response, status, xhr) {
                fetchUserData();
                if (xhr.status == 200) {
                    messageElement.innerText = "User successfully deactivated!";
                } else if (xhr.status == 201) {
                    messageElement.innerText = "User successfully activated!";
                }
                setTimeout(function() {
                    messageElement.innerHTML = "";
                }, 5000);
            },
            error: function(xhr, status, error) {
                console.error('Error deactivating user:', error);
            }
        });
    }

    let sortDirection = 'asc';

    function sortUsers(column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
        $.ajax({
            url: '/api/users/sort/' + column,
            data: { direction: sortDirection },
            type: 'GET',
            success: function(response) {
                fetchDataToTable(response);
            }
        });
    }

    function submitForm() {
            var messagesElement = document.getElementById('messages');
            const id = $('input[name="id"]').val();
            const userName = $('input[name="user_name"]').val();
            const name = $('input[name="name"]').val();
            const email = $('input[name="email"]').val();
            const userType = $('select[name="user_type"]').val();
            const status = $('select[name="status"]').val();
            const updatedUser = {
                id: id,
                user_name: userName,
                name: name,
                email: email,
                user_type: userType,
                status: status
            };
            $.ajax({
                url: '/api/users/update/' + id,
                type: 'PATCH',
                data: JSON.stringify(updatedUser),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success == true) {
                        fetchUserData();
                        $('#previewModal').modal('hide');
                    } else {
                        for (let key in response.response) {
                            if (response.response.hasOwnProperty(key)) {
                                messagesElement.innerHTML = response.response[key];
                                console.log(response.response[key]);
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    messagesElement.innerText = error;
                    console.log(error);
                }
            });
        }

    function openModal(id) {
        $.ajax({
            url: '/api/users/preview/' + id,
            type: 'GET',
            success: function(user) {
                $('#previewModal .modal-body').html(`
                    <div class="card p-4">
                        <div class="card-header">Preview ${user.name}</div>
                        <br>
                        <div id="messages"></div>
                        <div class="card-body">
                            <form id="update-form">
                                <input type="hidden" name="id" value="${user.id}" />
                                <label>User Name:</label><br>
                                <input type="text" name="user_name" value="${user.user_name}" class="form-control"><br>
                                <label>Name:</label><br>
                                <input type="text" name="name" value="${user.name}" class="form-control"><br>
                                <label>Email:</label><br>
                                <input type="text" name="email" value="${user.email}" class="form-control"><br>
                                <label>User Type:</label><br>
                                <select name="user_type" class="form-control">
                                    <option value="super_admin" ${user.user_type === 'super_admin' ? 'selected' : ''}>Super Admin</option>
                                    <option value="admin" ${user.user_type === 'admin' ? 'selected' : ''}>Admin</option>
                                    <option value="guest" ${user.user_type === 'guest' ? 'selected' : ''}>Guest</option>
                                </select><br>
                                <label>User Status:</label><br>
                                <select name="status" class="form-control">
                                    <option value="active" ${user.status === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="inactive" ${user.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                </select>
                                <br>
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-primary" onclick="submitForm()">Update</button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-secondary" id="closeModalBtn">Close</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                `);

                $('#previewModal').modal('show');
                $('#closeModalBtn').click(function() {
                    $('#previewModal').modal('hide');
                })
            },
            error: function(error) {
                console.error('Error fetching data from the API:', error);
            }
        });
    }

    $(document).ready(function() {
        fetchUserData() 
    });
</script>
