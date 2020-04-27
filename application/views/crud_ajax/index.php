<h2 class="text-center">Tabel Siswa</h2>
<div id="body" class="card-body">
    <div class=" ">
        <button class="btn btn-primary btn-sm mb-2" id="btn_add" type="submit">Add Data</button>
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>nis</th>
                    <th>nama</th>
                    <th>tanggal lahir</th>
                    <th>alamat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="list">



            </tbody>
        </table>
    </div>




    <!-- Modal -->

    <div id="model" title="Add Data">
        <form method="post" id="user_form">
            <div class="form-group">
                <label for="">NIS</label>
                <input type="text" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" class="form-control" name="nis" id="nis" aria-describedby="helpId" placeholder="">
                <span id="error_nis" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" aria-describedby="helpId" placeholder="">
                <span id="error_nama" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">tgl_lahir</label>
                <input type="date" class="form-control" name="tgl" id="tgl" aria-describedby="helpId" placeholder="">
                <span id="error_tgl" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" aria-describedby="helpId" placeholder="">
                <span id="error_alamat" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="">
                <span id="error_pasword" class="text-danger"></span>
            </div>

            <div class="form-group">
                <input type="hidden" name="action" id="action" value="insert" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
            </div>
        </form>
    </div>

    <div id="delete_confirmation" title="Confirmation">
        <input type="hidden" name="id_delete">
        <p>Are you sure you want to Delete this data?</p>
    </div>



    <script>
        $(document).ready(function() {

            ambilData();


            $('#table').DataTable();
            //load_data();

            $("#model").dialog({
                autoOpen: false,

            });

            function ambilData() {
                $.ajax({
                    type: 'get',
                    url: 'http://localhost/sekolah/api/coba',
                    dataType: 'json',

                    success: function(data) {
                        var baris = '';
                        for (var i = 0; i < data.data.length; i++) {
                            baris += '<tr>' +
                                '<td scope="row">' + data.data[i].nis + '</td>' +
                                '<td scope="row">' + data.data[i].nama + '</td>' +
                                '<td scope="row">' + data.data[i].alamat + '</td>' +
                                '<td scope="row">' + data.data[i].tgl_lahir + '</td>' +
                                '<td><button type="button" name="edit" class="btn btn-primary btn-xs edit" id="' + data.data[i].id_siswa + ' ">Edit</button>' +
                                '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' + data.data[i].id_siswa + '">Delete</button></td>' +
                                '</tr>';
                        };
                        $('#list').html(baris);
                    }
                });
            }

            $('#btn_add').click(function() {
                $('#model').attr('title', 'Add Data');
                $('#action').val('insert');
                $('#form_action').val('Insert');
                $('#user_form')[0].reset();
                $('#form_action').attr('disabled', false);
                $("#model").dialog('open');
            });

            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                var action = 'fetch_single';
                $.ajax({
                    url: 'http://localhost/sekolah/api/coba',
                    type: "get",
                    data: {
                        id: id,
                        action: action

                    },
                    dataType: "json",
                    success: function(data) {

                        $('#nama').val(data.data[0].nama);
                        $('#alamat').val(data.data[0].alamat);
                        $('#tgl').val(data.data[0].tgl_lahir);
                        $('#nis').val(data.data[0].nis);
                        $('#password').val(data.data[0].password);
                        $('#model').attr('title', 'Edit Data');
                        $('#action').val('update');
                        $('#hidden_id').val(id);
                        $('#form_action').val('Update');
                        $('#model').dialog('open');


                        if (data.data.status == true) {
                            $('#model').dialog('close');
                            window.location.assign(data.data.lokasi);
                        } else {
                            $("#infolog").html(data.data.msg);
                        }
                    }
                });
            });

            $('#user_form').on('submit', function(event) {
                event.preventDefault();
                var error_nama = '';
                var error_alamat = '';
                var error_tgl = '';
                var error_nis = '';
                var error_password = '';
                if ($('#nama').val() == '') {
                    error_nama = 'Name is required';
                    $('#error_nama').text(error_nama);
                    $('#nama').css('border-color', '#cc0000');
                } else {
                    error_nama = '';
                    $('#error_nama').text(error_nama);
                    $('#nama').css('border-color', '');
                }
                if ($('#alamat').val() == '') {
                    error_alamat = 'Alamat is required';
                    $('#error_alamat').text(error_alamat);
                    $('#alamat').css('border-color', '#cc0000');
                } else {
                    error_alamat = '';
                    $('#error_alamat').text(error_alamat);
                    $('#alamat').css('border-color', '');
                }
                if ($('#tgl').val() == '') {
                    error_tgl = 'Tanggal lahir is required';
                    $('#error_tgl').text(error_tgl);
                    $('#tgl').css('border-color', '#cc0000');
                } else {
                    error_tgl = '';
                    $('#error_tgl').text(error_tgl);
                    $('#tgl').css('border-color', '');
                }
                if ($('#nis').val() == '') {
                    error_nis = 'NIS is required';
                    $('#error_nis').text(error_nis);
                    $('#nis').css('border-color', '#cc0000');
                } else {
                    error_nis = '';
                    $('#error_nis').text(error_nis);
                    $('#nis').css('border-color', '');
                }
                if ($('#password').val() == '') {
                    error_password = 'Password is required';
                    $('#error_password').text(error_password);
                    $('#password').css('border-color', '#cc0000');
                } else {
                    error_password = '';
                    $('#error_password').text(error_nis);
                    $('#password').css('border-color', '');
                }

                if (error_nama != '' || error_alamat != '' || error_tgl != '' || error_nis != '' || error_password != '') {
                    return false;
                } else {

                    var form_data = $(this).serialize();
                    var fa = $('#form_action').val();
                    if (fa == 'Insert') {
                        var af = 'http://localhost/sekolah/api/coba';
                    } else {
                        var af = 'http://localhost/sekolah/api/coba/update';
                    }
                    $.ajax({
                        url: af,
                        dataType: 'json',
                        method: "POST",
                        data: form_data,
                        success: function(data) {
                            if (data.status == true) {
                                $('#model').dialog('close');
                                window.location.assign(data.lokasi);
                            } else {
                                $("#infolog").html(data.msg);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('controller Error');
                        }
                    });
                }

            });


            $(document).on('click', '.delete', function() {
                var id = $(this).attr("id");
                $('[name="id_delete"]').val(id);
                $('#delete_confirmation').data('id_siswa', id).dialog('open');
            });


            $('#delete_confirmation').dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function() {
                        var id = $('[name="id_delete"]').val();

                        var action = 'delete';
                        $.ajax({
                            url: "http://localhost/sekolah/api/coba/delete",
                            method: "post",
                            dataType: 'json',
                            data: {
                                id: id,
                                action: action
                            },
                            success: function(data) {

                                if (data.status == true) {
                                    $('#delete_confirmation').dialog('close');
                                    window.location.assign(data.lokasi);
                                }

                            }
                        });
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                    }
                }
            });

        });
    </script>