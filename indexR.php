<?php
//connect of course
$conn = mysqli_connect("localhost","root","","cedova");

//biar nggak error
$pesan = "<br>";

//jika tombol upload ditekan
if(isset($_POST["upload"])){
    //mengambil nama, size, dan path sementara dari file
    $fileName = $_FILES["jigma"]["name"];
    $fileSize = $_FILES["jigma"]["size"];
    $fileTmp = $_FILES["jigma"]["tmp_name"];

    //format yang diperbolehkan
    $allowedFormat = array('jpg','png','jpeg');

    //mengambil format file yg diupload
    $divider = explode('.', $fileName);
    $fileFormat = strtolower(end($divider));

    //check format
    if(in_array($fileFormat, $allowedFormat)){
        //max ukuran 2mb
        if($fileSize < 2097152){
            //pindahkan file dari temporary foldernya ke tempat yang diinginkan
            move_uploaded_file($fileTmp, "image/".$fileName);
            //masukkan nama file ke database
            mysqli_query($conn, "INSERT INTO imagetb(id,nama) VALUES(null,'$fileName')");

            $pesan = "Upload complete!";
        }
        else{$pesan = "Max file size 2mb";}
    }
    else{$pesan = "Only jpg, png, and jpeg allowed";}

}
//query untuk mengambil nama file di tabel
$selectImage = mysqli_query($conn, "SELECT * FROM imagetb ORDER BY id DESC");

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <title>Upload</title>
    </head>

    <body>
    <style>img[alt="www.000webhost.com"]{display:none;}</style>
        <div class="container">
            <!--*penting: sertakan enctype=multipart/form-data-->
            <form method="post" enctype="multipart/form-data">
                <div class="btn-group col-md-6">
                    <input class="btn btn-info" type="file" name="jigma">
                    <button class="btn btn-primary" type="submit" name="upload" style="display: block;">Upload</button>
                </div>
                <p>
                    <?=$pesan;?>
                </p>
            </form>

            <div class="card-coloumns">
                <!--selama ada file yang bisa diambil maka...-->
                <?php while($fetch = mysqli_fetch_assoc($selectImage)):?>

                <div class="card">
                    <div class="card-body">
                        <!--hapus-->
                        <a href="hapus.php?id=<?=$fetch['id'];?>">hapus</a>
                        <!--panggil file/gambar-->
                        <img src="image/<?=$fetch['nama'];?>">
                    </div>
                </div>
                <?php endwhile;?>
            </div>
        </div>
    </body>

    </html>
