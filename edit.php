<?php include 'koneksi.php' ?>
<?php
if (isset($_GET['id_user'])) {
    $idToUpdate = $_GET['id_user'];
    $sqlGetData = "SELECT * FROM users WHERE id_user = '$idToUpdate'";
    $resultGetData = mysqli_query($conn, $sqlGetData);

    if ($resultGetData) {
        $rowData = mysqli_fetch_assoc($resultGetData);
        $username = $rowData['username'];
        $password = $rowData['password'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body"> Insert Data</div>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <label for="username">Username :</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="password">password :</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo $password ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"> Simpan</button>
            </form>
        </div>

        <table class="table table-hover" id="table_perbaikan">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = "SELECT * FROM users";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id_user = $row['id_user'];
                        $username = $row['username'];
                        $password = $row['password'];
                ?>
                        <tr class="text-center">
                            <td><?php echo $no; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $password; ?></td>
                            <td><a class="btn btn-warning" href="edit.php?id_user=<?php echo $id_user; ?>"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-danger" href="#" onclick="confirmDelete(<?php echo $id_user; ?>)"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                <?php
                        $no++;
                    }
                } else {
                    echo '<tr><td colspan="3">Data User tidak ada.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "UPDATE users set username='$username', password='$password' WHERE id_user='$idToUpdate' ";

        if (mysqli_query($conn, $sql)) {
            echo '<script>
                    swal.fire({
                        title: "Sukses",
                        text: "Data berhasil di Edit!",
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then(function() {
                        window.location.href = "index.php";
                    });
                </script>';
        } else {
            echo '<script>
                    swal.fire({
                        title: "Error",
                        text: "Error: ' . mysqli_error($conn) . '",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                </script>';
        }
    }
    ?>

    <script>
        function confirmDelete(id_mekanik) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'hapus.php?id_user=' + id_user;
                }
            });
        }
    </script>

</body>

</html>