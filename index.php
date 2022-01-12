<?php

$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "inotes";
$file_path = '/'.$database.'.sql';


$connect = mysqli_connect($servername, $username, $password, $database);
$sqlScript = file('crud.sql');


if (!$connect) {
    die("sorry we are failed to connect: " . mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sr.no` = $sno";
    $result = mysqli_query($connect, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    if(isset($_POST["srnedit"])){
        $srno = $_POST["srnedit"];
        $title = $_POST["titleedit"];
        $description = $_POST["descriptionedit"];
    
        $sql = "UPDATE `notes` SET `title`= '$title' , `description` = '$description' WHERE `notes`.`sr.no` = '$srno';";
        $sqlquery = mysqli_query($connect, $sql);
        if ($sqlquery) {
            $update = true;
        } else {
            echo "the record not inserted ---" . mysqli_error($connect);
        }
    }
    else {
        $title = $_POST["title"];
        $description = $_POST["description"];
    
        $sql = "insert into `notes` (`title`, `description`) values ('$title','$description')";
        $sqlquery = mysqli_query($connect, $sql);
    
        if ($sqlquery) {
            $insert = true;
        } else {
            echo "the record not inserted ---" . mysqli_error($connect);
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <title>PHP-CRUD</title>
</head>

<body>
    <!--Edit Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editmodalabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/crud/index.php" method="post">
                    <input type="hidden" id="srnedit" name="srnedit" >
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleedit" name="titleedit">
                        </div>
                        <div class="mb-3">
                            <label for="textarea" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- delete Modal
    <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="deletemodalabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletemodalabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    delete
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div> -->


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>

                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php

    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Your Notes has been added successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    ?>

    <?php

    if($update){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Your Notes has been Updated successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php

        if($delete){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Your Notes has been Updated successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>

    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/crud/index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="textarea" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sr.no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($connect, $sql);
                $srn = 1;
                while ($row =  mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <th scope="row">' . $srn . '</th>
                            <td>' . $row["title"] . '</td>    
                            <td>' . $row["description"] . '</td>
                            <td>
                            <button type="button" class="btn btn-sm btn-dark edit" data-bs-toggle="modal" data-bs-target="#editmodal" id = "'. $row["sr.no"] .'">
                            Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete" data-bs-toggle="modal" data-bs-target="#deletemodal" id = "delete_'. $row["sr.no"] .'">
                            Delete
                            </button></td>
                        </tr>';
                    $srn++;
                }
                ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

            $(document).on("click", ".edit", function() {
                title = $(this).closest('td').prev('td').prev('td').text();
                desc = $(this).closest('td').prev('td').text();
                $("#titleedit").val(title)
                $("#descriptionedit").val(desc)
                srno_db=$(this).attr("id")
                $("#srnedit").val(srno_db)
            })

            $(document).on("click", ".delete", function() {
                srno_db=$(this).attr("id").split("_").pop()

                if(confirm("Are you sure you want to delete this note!")){
                    window.location = `/crud/index.php?delete=${srno_db}`;
                }else {
                    console.log("no");
                }
            })

        });
    </script>

</body>

</html>