<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['user_name'])) {
        header("Location: index.php");
        exit();
    }

    // Xử lý đăng xuất
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
    ?>

    <div class="container">
        <h1 class="text-center">Student List</h1>
        <table class="table" >
            <theadv class="table-dark">
                <tr>
                    <th scope="col">Rollno</th>
                    <th scope="col">Student Fullname</th>
                    <th scope="col">Address</th>
                    <th scope="col">Email</th>
                </tr>
            </theadv>
            <tbody>
                <?php
                include "db_conn.php";
                $sql = "SELECT * FROM students";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    ?>
                    <tr>
                        <td class="table-primary" ><?php echo $row['Rollno']; ?></td>
                        <td class="table-secondary"><?php echo $row['Sname']; ?></td>
                        <td class="table-success"><?php echo $row['Address']; ?></td>
                        <td class="table-danger"><?php echo $row['Email']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="row d-flex justify-content-center">
            
            <div class="col-12">
              <button class="btn btn-outline-dark" type="submit" name="logout">Log out</button>
              <a class="btn btn-outline-success" style="margin: 10px;" href="StudentList.php">Add New</a>
            </div>
          
               
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="pic1.svg" alt="">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>