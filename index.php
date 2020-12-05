<?php
//connect of course
$conn = mysqli_connect("localhost","root","","cedova");

//biar nggak error
$pesan = "<br>";

//jika tombol upload ditekan
if(isset($_POST["upload"])){
    //mengambil nama, size, dan path dari file
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
    <title>Upload</title>
</head>
<body>
<!--*penting: sertakan enctype=multipart/form-data-->
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="jigma">
        <button type="submit" name="upload" style="display: block;">Upload</button>
        <p><?=$pesan;?></p>
    </form>

<!--selama ada file yang bisa diambil maka...-->
    <?php while($fetch = mysqli_fetch_assoc($selectImage)):?>

        <!--panggil file/gambar-->
        <img src="image/<?=$fetch['nama'];?>">

    <?php endwhile;?>
</body>
</html>
