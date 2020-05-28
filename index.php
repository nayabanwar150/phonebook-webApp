<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Includes Links -->
    <?php include('includes/links.php'); ?>

    <title>Phone Book | Add New Contact</title>
</head>

<body>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="container">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Search Bar -->
            <div class="search-bar mb-3">
                <form id="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search contacts...">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!--Contacts Display -->
            <div class="contacts-display mb-4">
                <div id="accordion">
                    <?php

                    include('includes/connection.php');
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $startIndex = ($page - 1) * 4;
                    $limit_per_page = 4;

                    // Fetching Details from Database
                    $stmt = "SELECT * FROM phonebook ORDER BY name LIMIT $startIndex, $limit_per_page";
                    $query = mysqli_query($connection, $stmt);

                    $collapse = 1;
                    while ($result = mysqli_fetch_array($query)) {

                    ?>
                        <div class="card">
                            <!-- User Name -->
                            <div class="card-header" id="heading<?php echo $collapse; ?>">
                                <h5>
                                    <?php

                                    if ($collapse == 1) {
                                        $expand = 'true';
                                    } else {
                                        $expand = 'false';
                                    }

                                    ?>
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $collapse; ?>" aria-expanded="<?php echo $expand; ?>" aria-controls="collapse<?php echo $collapse; ?>">
                                        <?php echo $result['name']; ?>
                                    </button>
                                    <span class="btn-link text-right" data-toggle="collapse" data-target="#collapse<?php echo $collapse; ?>" aria-expanded="<?php echo $expand; ?>" aria-controls="collapse<?php echo $collapse; ?>"><i class="fa fa-caret-down"></i></span>
                                </h5>
                            </div>

                            <!-- Contacts -->
                            <div id="collapse<?php echo $collapse; ?>" class="collapse show" aria-labelledby="heading<?php echo $collapse; ?>" data-parent="#accordion">
                                <?php  ?>
                                <div class="card-body">
                                    <!-- Contact's Name -->
                                    <div class="name">
                                        <h5>
                                            <?php echo $result['name']; ?>
                                            <span class="btn-link text-right" data-toggle="collapse" data-target="#collapse<?php echo $collapse; ?>" aria-expanded="<?php echo $expand; ?>" aria-controls="collapse<?php echo $collapse; ?>"><i class="fa fa-caret-up"></i></span>
                                        </h5>
                                    </div>
                                    <!-- Contact's DOB -->
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <p class="DOB text-white"><?php echo $result['dob']; ?></p>
                                        </div>
                                        <div class="col-sm-8 text-right operations">
                                            <button class="btn btn-info mr-2"><a href="updateContact.php?id=<?php echo $result['id']; ?>">Edit</a></button>
                                            <button class="btn btn-danger"><a href="deleteContact.php?id=<?php echo $result['id']; ?>">Remove</a></button>
                                        </div>
                                    </div>
                                    <!-- Contact's Details -->
                                    <div class="contact-details p-3">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <!-- Phone Numbers -->
                                                <div class="phone-numbers">
                                                    <?php
                                                    $mobiles = explode(',', $result['mobiles']);
                                                    for ($i = 0; $i < count($mobiles); $i++) {
                                                    ?>
                                                        <h5 class="number"><i class="fa fa-phone-square"></i>&nbsp;+91 <?php echo $mobiles[$i]; ?></h5>
                                                    <?php }; ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <!-- Email Address -->
                                                <div class="emails">
                                                    <?php
                                                    $emails = explode(',', $result['emails']);
                                                    for ($i = 0; $i < count($emails); $i++) {
                                                    ?>
                                                        <h5 class="email"><a href="mailto:<?php echo $emails[$i]; ?>"><i class="fa fa-envelope"></i> &nbsp; <?php echo $emails[$i]; ?></a></h5>
                                                    <?php }; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        $collapse++;
                    }; ?>
                </div>
            </div>

            <!-- Pagination -->
            <div class="Pagination justify-content-center mb-5 " id="Pagination">
                <?php
                // Fetching Details from Database
                $stmt2 = "SELECT * FROM phonebook";
                $query2 = mysqli_query($connection, $stmt2);


                $totalContacts = mysqli_num_rows($query2);
                $number_of_pages = ceil($totalContacts / $limit_per_page);

                if ($page <= 1) {
                    $previous = 1;
                    $displayPrev = "disabled";
                } else {
                    $previous = $page - 1;
                }

                if ($page >= $number_of_pages) {
                    $previous = $number_of_pages;
                    $displayNext = "disabled";
                } else {
                    $next = $page + 1;
                }
                ?>
                <nav aria-label="...">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $displayPrev; ?>">
                            <a class="page-link" href="index.php?page=<?php echo $previous; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                        </li>
                        <?php
                        for ($i = 1; $i <= $number_of_pages; $i++) {
                            $i == $page ? $active = "active" : $active = "";
                        ?>
                            <li class="page-item <?php echo $active; ?>"><a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php }; ?>
                        <li class="page-item <?php echo $displayNext; ?>">
                            <a class="page-link" href="index.php?page=<?php echo $next; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Add Contacts Button -->
    <button class="btn btn-default btn-add-contact"><a href="addNewContact.php"><i class="fa fa-plus"></i></a></button>

    <script>
        $(document).ready(function() {
            // Get Form data entered by user
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'searchResult.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#search-form')[0].reset();
                        $('#accordion').html(response);
                        $('#Pagination').hide();
                    }
                });
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>