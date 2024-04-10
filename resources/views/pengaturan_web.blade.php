@extends('template')

@section('head')
    <title>Pengaturan Umum Website</title>
@endsection

@section('container')

    <h1>Pengaturan Web</h1>
    <p>digunakan untuk mengatur website secara umum</p>

    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="input-group justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="refresh">Refresh</button>
            </div>
        </div>
    </div>

    <form id="form">
        <input type="hidden" name="id" id="id">
        <h3>WEBSITE</h3>
        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label" >Nama</label>
            <div class="col-sm-6">
                <input type="text" class="form-control w-100" id="nama" name="nama" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="icon" class="col-sm-2 col-form-label">Icon</label>
            <div class="col-sm-5">
                <input type="file" class="form-control w-100" id="icon" name="file" accept=".png">
            </div>
            <div class="col-sm-2">
                <div id="preview-img"></div>
            </div>  
        </div>  
        <div class="row mb-3">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-8">
                <textarea class="form-control w-100" id="alamat" name="alamat" rows="3"  required></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <label for="helpdesk" class="col-sm-2 col-form-label">Nomor Helpdesk</label>
            <div class="col-sm-8">
                <textarea class="form-control w-100" id="helpdesk" name="helpdesk" rows="3" required></textarea>
            </div>
        </div>
        <hr>
        <h3>IDENTITAS</h3>
        <div class="row mb-3">
            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-8">
                <textarea class="form-control w-100" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <label for="keywords" class="col-sm-2 col-form-label">Kata Kunci</label>
            <div class="col-sm-6">
                <input type="text" class="form-control w-100" id="keywords" name="keywords" required>
            </div>
        </div>
        <hr>
        <h3>SOSIAL MEDIA</h3>
        <div class="row mb-3">
            <label for="fb" class="col-sm-2 col-form-label">Facebook</label>
            <div class="col-sm-5">
                <input type="text" class="form-control w-100" id="fb" name="fb">
            </div>
        </div>
        <div class="row mb-3">
            <label for="youtube" class="col-sm-2 col-form-label">Youtube</label>
            <div class="col-sm-5">
                <input type="text" class="form-control w-100" id="youtube" name="youtube">
            </div>
        </div>
        <div class="row mb-3">
            <label for="ig" class="col-sm-2 col-form-label">Instagram</label>
            <div class="col-sm-5">
                <input type="text" class="form-control w-100" id="ig" name="ig">
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-5">
                <input type="email" class="form-control w-100" id="email" name="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
            <div class="col-sm-5">
                <input type="text" class="form-control w-100" id="twitter" name="twitter">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>

@endsection

@section('script')
<script src="{{ asset('js/token.js') }}"></script>

<script>
    var vApiUrl='api/pengaturan-web';

    loadData();
    function loadData() {
        $.ajax({
            url: vApiUrl+'/1',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#id').val(response.id);
                $('#nama').val(response.nama);
                $('#deskripsi').val(response.deskripsi);
                $('#keywords').val(response.keywords);

                var imageUrl = response.icon;
                if(imageUrl===null){
                    imageUrl='images/logo.png'
                }
                console.log(imageUrl);
                $('#preview-img').html('<img src="' + imageUrl + '" height="45px" alt="Preview Image">');


                $('#fb').val(response.fb);
                $('#youtube').val(response.youtube);
                $('#ig').val(response.ig);
                $('#fb').val(response.fb);
                $('#email').val(response.email);
                $('#twitter').val(response.twitter);
                $('#alamat').val(response.alamat);
                $('#helpdesk').val(response.helpdesk);
            },
            error: function() {
                alert('operasi gagal dilakukan!');
                window.location.replace('{{ url("/") }}');
            }
        });                
    }
        
    $('#refresh').on('click', function(e) {
        loadData();
    });

    $('#icon').on('change', function(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            $('#preview-img').html('<img src="' + dataURL + '" height="45px" alt="Preview Image">');
        };
        reader.readAsDataURL(input.files[0]);
    });

    $("#form").validate({
        rules: {
            email: {
                required: true,
                email: true 
            },
            youtube: {
                url: true 
            },
            fb: {
                url: true 
            },
            ig: {
                url: true 
            },
            twitter: {
                url: true 
            },
            file: {
                accept: "image/png"
            }            
        },
        submitHandler: function(form) {
            var formData = new FormData($(form)[0]);
            formData.append("_method", "PUT")
            $.ajax({
                url: vApiUrl+'/1',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success('operasi berhasil dilakukan!', 'berhasil');
                    // loadData();
                },
                error: function() {
                    alert('operasi gagal dilakukan!');
                }
            });
        }
    });
</script>
@endsection
