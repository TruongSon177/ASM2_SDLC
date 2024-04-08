<?php
include "db_conn.php";

if (isset($_POST['btnAdd'])) {
    $Rollno = $_POST['Rollno'];
    $Sname = $_POST['Sname'];
    $Address = $_POST['Address'];
    $Email = $_POST['Email'];

    if ($Rollno == "" || $Sname == "" || $Address == "" || $Email == "") {
        echo " is not empty";
    } else {
        if ($_POST['btnAdd'] == "Add") {
            $sql = "SELECT Rollno FROM students WHERE Rollno='$Rollno'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO students VALUES ('$Rollno', '$Sname', '$Address', '$Email')";
                mysqli_query($conn, $sql);
                header("Location: StudentList.php");
                exit();
            } else {
                echo "Existed student in list";
            }
        } elseif ($_POST['btnAdd'] == "Update") {
            $sql = "UPDATE students SET Sname='$Sname', Address='$Address', Email='$Email' WHERE Rollno='$Rollno'";
            mysqli_query($conn, $sql);
            header("Location: StudentList.php");
            exit();
        }
    }
}

if (isset($_GET['delete'])) {
    $rollnoToDelete = $_GET['delete'];
    $sql = "DELETE FROM students WHERE Rollno='$rollnoToDelete'";
    mysqli_query($conn, $sql);
    header("Location: StudentList.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include "db_conn.php";
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);
    ?>
    <div class="container">


        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Rollno</th>
                    <th scope="col">Student Fullname</th>
                    <th scope="col">Address</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                    <tr>
                        <td class="table-primary"><?php echo $row['Rollno']; ?></td>
                        <td class="table-secondary edit"><?php echo $row['Sname']; ?></td>
                        <td class="table-success edit"><?php echo $row['Address']; ?></td>
                        <td class="table-danger edit"><?php echo $row['Email']; ?></td>
                        <td class="table-warning">
                            <button class="editBtn btn btn-outline-warning" data-id="<?php echo $row['Rollno']; ?>">Edit</button>
                            <a class="btn btn-danger" href="StudentList.php?delete=<?php echo $row['Rollno']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>

        </table>

        

        <div class="card">
            <div class="card-body">
                <form method="post" id="AddStudent">
                    <div>
                        <caption align="center"><b>Adding Student</b></caption>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label class="mt-3" for="">Rollno</label>
                                <input style="border: 1px solid #c5bdbd;" type="text" name="Rollno" class="form-control" />
                            </div>

                            <div class="col-12 mt-3">
                                <label class="mt-3" for="">StudentName</label>
                                <input  style="border: 1px solid #c5bdbd;" type="text" name="Sname" class="form-control" />
                            </div>

                            <div class="col-12 mt-3">
                                <label class="mt-3">Student Address</label>
                                <input style="border: 1px solid #c5bdbd;" type="text" name="Address" class="form-control" />
                            </div>
                            <div>
                                <label class="mt-3">Student Email</label>
                                <input style="border: 1px solid #c5bdbd;" type="text" name="Email" class="form-control" />
                            </div>
                            <div class="col-12 mt-3">

                                <input class="btn btn-outline-success" type="submit" value="Add" name="btnAdd" />
                                <input class="btn btn-outline-secondary" type="reset" value="cancel" name="btnCancel" />
                                <a class="btn btn-outline-dark" href="student.php" class="exit-btn">Exit</a> <!-- Moved the exit button here -->

                            </div>
                        </div>









                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Script for handling edit functionality -->
    <script>
        document.querySelectorAll('.editBtn').forEach(item => {
            item.addEventListener('click', event => {
                const rollno = item.getAttribute('data-id');
                const cells = item.parentElement.parentElement.querySelectorAll('.edit');
                const data = Array.from(cells).map(cell => cell.textContent.trim());

                document.querySelector('input[name="Rollno"]').value = rollno;
                document.querySelector('input[name="Sname"]').value = data[0];
                document.querySelector('input[name="Address"]').value = data[1];
                document.querySelector('input[name="Email"]').value = data[2];

                document.querySelector('input[name="btnAdd"]').value = "Update";

                document.getElementById('AddStudent').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const rollno = document.querySelector('input[name="Rollno"]').value;
                    const sname = document.querySelector('input[name="Sname"]').value;
                    const address = document.querySelector('input[name="Address"]').value;
                    const email = document.querySelector('input[name="Email"]').value;

                    const formData = new FormData();
                    formData.append('Rollno', rollno);
                    formData.append('Sname', sname);
                    formData.append('Address', address);
                    formData.append('Email', email);
                    formData.append('btnAdd', 'Update');

                    fetch('StudentList.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (response.ok) {
                                location.reload();
                            } else {
                                console.error('Update failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>