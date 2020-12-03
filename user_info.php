<?php require_once('config.php'); ?>
<!--
Project Phase III
Group name: Husky Data Inc.
Group members: Elijah Freeman, Roy (Dongyeon) Joo, Xiuxiang Wu
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <!-- add a reference to the external stylesheet -->
    <!-- Uses the solar stylesheet from bootswatch -->
    <link rel="stylesheet" href="https://bootswatch.com/4/solar/bootstrap.min.css">
</head>
<body>
<!-- START Add HTML code for the top menu section (navigation bar) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Husky Data Health</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <!-- May need to modify the following line -->
                <a class="nav-link" href="index.php">Home
                    <span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="infection.php">Infection</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="covid_test_center.php">Covid Test Centers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="high_risk.php">High Risk Areas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="hospital.php">Find a Hospital</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="patient.php">Patients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="new_symptoms.php">New Symptom</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="user_info.php">Users</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="sick_patients.php">Sick Patients</a>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
<!-- END Add HTML code for the top menu section (navigation bar) -->

<div class="jumbotron">
    <p style="font-size: 50px" class="lead">User Information</p>
    <hr class="my-4">
    <form method="GET" action="user_info.php">

            <div class="grid-child2">
                <!-- div container for the drop down form select bar -->
                <div class="form-group">
                    <label style="font-size: 17px" for="county_control_form">Find Information about User
                    </label>
                    <select class = "form-control" name="user" onchange='this.form.submit()' id='county_control_form'>
                        <option selected>Find User Info</option>

                        <?php
                        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                        if ( mysqli_connect_errno() )
                        {
                            die( mysqli_connect_error() );
                        }
                        // Query that retrieves the first and last name and user_id from
                        // our USER_INFO table in our database.
                        $sql = "select first_name, last_name, user_id from USER_INFO ORDER BY last_name ASC";
                        if ($result = mysqli_query($connection, $sql))
                        {
                            // loop through the data
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo '<option value="' . $row['user_id'] . '">';
                                echo $row['last_name']. ', '. $row['first_name'];
                                echo "</option>";

                            } // release the memory used by the result set
                            mysqli_free_result($result);
                        }
                        ?>
                    </select>
                </div>

                <?php

                if ($_SERVER["REQUEST_METHOD"] == "GET")
                {
                if (isset($_GET['user']) )
                {
                ?>

                <p>&nbsp;</p>
                <table class="table table-hover">
                    <thead>
                    <tr class="table-success">
                        <th scope="col">Last Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">County</th>
                        <th scope="col">Contact Information</th>
                        <th scope="col">Sex</th>
                    </tr>
                    </thead>

                    <?php
                    if ( mysqli_connect_errno() )
                    {
                        die(mysqli_connect_error() );
                    }

                    // Selects patient information from database using
                    // their user_id.
                    $sql = " SELECT * FROM
                             USER_INFO
                             WHERE user_id = {$_GET['user']}";

                    if ($result = mysqli_query($connection, $sql))
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $row['last_name'] ?></td>
                                <td><?php echo $row['first_name'] ?></td>
                                <td><?php echo $row['age'] ?></td>
                                <td><?php echo $row['county'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['sex'] ?></td>
                            </tr>

                            <?php
                        } // release the memory used by the result set
                        mysqli_free_result($result);
                    }

                    } // end if (isset)
                    } // end if ($_SERVER)
                    ?>

                </table>

            </div> <!-- Grid Child-->

        </div> <!-- Grid container -->

    </form>
</div>
</body>
</html>
