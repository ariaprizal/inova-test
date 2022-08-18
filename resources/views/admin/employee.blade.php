@extends('layouts.sidebar')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@section('title', 'Pegawai')

@section('content')


<div class="lg:w-auto lg:h-auto h-full w-full  my-6 mx-8 ">
    <div class="lg:h-auto lg:w-auto w-full h-full">
        <h1 class="text-center my-5">Daftar Pegawai</h1>
        <form action="{{route('employee')}}" method="post" class="lg:h-auto lg:w-auto h-full w-full" id="form-tambah">
            @csrf
            <div class="flex lg:flex-wrap">
                <input type="hidden" name="id" id="id">
                <div class="form-group">    
                    <div class='px-2'>
                        <input type="text" name="name" id="name" placeholder="Nama Pegawai" class="pl-2 h-10 w-52 bg-transparent shadow-lg rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none my-2"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class='px-2'>
                        <input type="text" name="address" id="address" placeholder="Alamat" class="pl-2 h-10 w-52 bg-transparent shadow-lg rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none my-2" /> 
                    </div>
                </div>
                <div class="form-group">
                    <div class='px-2'>
                        <input type="text" name="jabatan" id="jabatan" placeholder="Jabatan" class="pl-2 h-10 w-52 bg-transparent shadow-lg rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none my-2" /> 
                    </div>
                </div>
                <div class="form-group mt-2 ml-4">
                    <div class='px-2'>
                        <button type="button" name="simpan" id="simpan-data" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="w-full pb-10">
            <table class="table table-bordered table-action ">
                <thead class="text-center">
                    <tr>
                        <th>Id</th>
                        <th>Nama Pegawai</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>














<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


<script type="text/javascript">
    $(function () {    
        let table = $('.table-action').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ]
        });

        $('#simpan-data').on('click', () =>
        {
            if ($('#simpan-data').text() === 'Simpan') 
            {
                $.ajax({
                    url : "{{route('save.employee')}}",
                    type : "post",
                    dataType : 'json',
                    data : {
                        name : $('#name').val(),
                        address : $('#address').val(),
                        jabatan : $('#jabatan').val(),
                        "_token" : "{{csrf_token()}}"
                    },
                    success : function (res){
                        if ($.isEmptyObject(res.error)) 
                        {
                            alert(res.text);
                            $('.table-action').DataTable().ajax.reload();
                            $('#form-tambah')[0].reset();  
                        }
                        else
                        {
                            $.each(res.error, function(prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                            });
                        }
                    },
                    error : function (xhr){
                        alert(xhr.text);
                    }
        
                });
            }
            else if (($('#simpan-data').text() === 'Update')) 
            {
                $.ajax({
                    url : "{{route('update.employee')}}",
                    type : "put",
                    data : {
                        id : $('#id').val(),
                        name : $('#name').val(),
                        address : $('#address').val(),
                        jabatan : $('#jabatan').val(),
                        "_token" : "{{csrf_token()}}"
                    },
                    success : function (res){
                        alert(res.text);
                        $('.table-action').DataTable().ajax.reload();
                        $('#form-tambah')[0].reset();
                        $('#simpan-data').text("Simpan")
                    },
                    error : function (xhr){
                        alert(xhr.text);
                    }
        
                });
            }
        });

        $(document).on('click', '.edit', function ()
        {
            let id = $(this ).attr('id');
            $('#simpan-data').text('Update');

            $.ajax({
                url : "{{route('edit.employee')}}",
                type : 'get',
                data : {
                    id : id,
                    _token : "{{csrf_token()}}"
                },
                success : function(res){    
                    $('#id').val(res.data.id)
                    $('#name').val(res.data.name)
                    $('#address').val(res.data.address)
                    $('#jabatan').val(res.data.jabatan)
                }
            })
        });

        $(document).on('click', '.delete', function ()
        {
            let id = $(this).attr('id');
            if (confirm("Apakah Anda Yakin Ingin Mengapus Data Tersebut?")) 
            {
                $.ajax({
                    url : "{{route('delete.employee')}}",
                    type : "delete",
                    data : {
                        id : id,
                        _token : "{{csrf_token()}}"
                    },
                    success : function (res){
                        alert(res.text);
                        $('.table-action').DataTable().ajax.reload();
                    },
                    error : function (xhr){
                        alert(xhr.text);
                    }
                });
            }
        });

    });
</script>

@endsection