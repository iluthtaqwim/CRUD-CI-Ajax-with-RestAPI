<h2 class="text-center">Tabel Kelas</h2>
<div id="body" class="card-body">
    <div class="container ">
        <button class="btn btn-primary btn-sm mb-2" id="btnAddKls" type="submit">Add Data</button>
        <table id="tbl_kelas" class="table table-bordered table-hover">
            <thead>
                <tr>

                    <th>Tingkat</>
                    <th>Ruang</th>
                    <th>Jumlah Siswa</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="list">

            </tbody>
        </table>

    </div>


    <div id="delete_confirmation_kls" title="Confirmation">
        <input type="hidden" name="id_delete">
        <p>Are you sure you want to Delete this data?</p>
    </div>

    <!-- Modal -->

    <div id="modelKls" title="Add Data">
        <form method="post" id="kls_form">
            <div class="form-group">
                <label for="">Tingkat</label>
                <input type="number" class="form-control" name="tingkat" id="tingkat" aria-describedby="helpId" placeholder="">
                <span id="error_tingkat" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Ruang</label>
                <input type="text" class="form-control" name="ruang" id="ruang" aria-describedby="helpId" placeholder="">
                <span id="error_ruang" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Jumlah Siswa</label>
                <input type="number" class="form-control" name="jml" id="jml" aria-describedby="helpId" placeholder="">
                <span id="error_jml" class="text-danger"></span>
            </div>

            <div class="form-group">
                <input type="hidden" name="action_kls" id="action_kls" value="insert" />
                <input type="hidden" name="hidden_id_kls" id="hidden_id_kls" />
                <input type="submit" name="form_action_kls" id="form_action_kls" class="btn btn-info" value="Insert" />
            </div>
        </form>
    </div>


    <!-- Script Kelas -->

    <script>
        $(document).ready(function() {

            $('#tbl_kelas').DataTable();

            $('#modelKls').dialog({

                autoOpen: false

            });
            getData();

            function getData() {
                $.ajax({
                    type: 'get',
                    url: 'http://localhost/sekolah/api/kelas',
                    dataType: 'json',

                    success: function(data) {
                        var baris = '';
                        for (var i = 0; i < data.data.length; i++) {
                            baris += '<tr>' +
                                '<td scope="row">' + data.data[i].tingkat + '</td>' +
                                '<td scope="row">' + data.data[i].ruang + '</td>' +
                                '<td scope="row">' + data.data[i].jumlah_siswa + '</td>' +

                                '<td><button type="button" name="edit_kls" class="btn btn-primary btn-xs edit_kls" id="' + data.data[i].id_kelas + ' ">Edit</button>' +
                                '<button type="button" name="delete_kls" class="btn btn-danger btn-xs delete_kls" id="' + data.data[i].id_kelas + '">Delete</button></td>' +
                                '</tr>';
                        };
                        $('#list').html(baris);
                    }
                });
            }


            $('#btnAddKls').click(function() {
                $('#modelKls').attr('title', 'Add Data');
                $('#action').val('insert');
                $('#form_action').val('Insert');
                $('#kls_form')[0].reset();
                $('#form_action_kls').attr('disabled', false);
                $("#modelKls").dialog('open');
            });

            $('#kls_form').on('submit', function(event) {
                event.preventDefault();
                var error_tingkat = '';
                var error_ruang = '';
                var error_jml = '';

                if ($('#tingkat').val() == '') {
                    error_tingkat = 'Tingkat is required';
                    $('#error_tingkat').text(error_tingkat);
                    $('#tingkat').css('border-color', '#cc0000');
                } else {
                    error_tingkat = '';
                    $('#error_tingkat').text(error_tingkat);
                    $('#tingkat').css('border-color', '');
                }
                if ($('#ruang').val() == '') {
                    error_ruang = 'Ruang is required';
                    $('#error_ruang').text(error_ruang);
                    $('#ruang').css('border-color', '#cc0000');
                } else {
                    error_ruang = '';
                    $('#error_ruang').text(error_ruang);
                    $('#ruang').css('border-color', '');
                }
                if ($('#jml').val() == '') {
                    error_jml = 'Jumlah Siswa is required';
                    $('#error_jml').text(error_jml);
                    $('#jml').css('border-color', '#cc0000');
                } else {
                    error_jml = '';
                    $('#error_jml').text(error_jml);
                    $('#jml').css('border-color', '');
                }

                if (error_tingkat != '' || error_ruang != '' || error_jml != '') {
                    return false;
                } else {

                    var form_data = $(this).serialize();
                    var fa = $('#form_action_kls').val();
                    if (fa == 'Insert') {
                        var af = 'http://localhost/sekolah/api/kelas';
                    } else {
                        var af = 'http://localhost/sekolah/api/kelas/update';
                    }
                    $.ajax({
                        url: af,
                        dataType: 'json',
                        method: "POST",
                        data: form_data,
                        success: function(data) {
                            if (data.status == true) {
                                $('#modelKls').dialog('close');
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

            $(document).on('click', '.edit_kls', function() {
                var id_kls = $(this).attr('id');
                var action_kls = 'fetch';
                $.ajax({
                    url: "http://localhost/sekolah/api/kelas/",
                    method: "get",
                    data: {
                        id: id_kls,
                        action: action_kls,
                    },
                    dataType: "json",
                    success: function(data) {

                        $('#tingkat').val(data.data[0].tingkat);
                        $('#ruang').val(data.data[0].ruang);
                        $('#jml').val(data.data[0].jumlah_siswa);

                        $('#modelKls').attr('title', 'Edit Data');
                        $('#action_kls').val('update');
                        $('#hidden_id_kls').val(id_kls);
                        $('#form_action_kls').val('Update');
                        $('#modelKls').dialog('open');


                        if (data.data.status == true) {
                            $('#modelKls').dialog('close');
                            window.location.assign(data.data.lokasi);
                        } else {
                            $("#infolog").html(data.data.msg);
                        }
                    }
                });
            });


            $(document).on('click', '.delete_kls', function() {
                var id = $(this).attr("id");
                $('[name="id_delete"]').val(id);
                $('#delete_confirmation_kls').data('id_kelas', id).dialog('open');
            });


            $('#delete_confirmation_kls').dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function() {
                        var id = $('[name="id_delete"]').val();

                        var action = 'delete';

                        $.ajax({
                            url: "http://localhost/sekolah/api/kelas/delete",
                            method: "POST",
                            dataType: 'json',
                            data: {
                                id: id,
                                action: action
                            },
                            success: function(data) {
                                console.log(data);
                                if (data.data.status == true) {
                                    $('#delete_confirmation').dialog('close');
                                    window.location.assign(data.data.lokasi);
                                } else {
                                    $("#infolog").html(data.data.msg);
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