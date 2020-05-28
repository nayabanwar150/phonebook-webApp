<?php
    include('includes/connection.php');
    if(isset($_POST['search'])){
        // Get search query entered by user
        $searchQuery = $_POST['search'];

        // Set startIndex and limit to fetch 4 contact/page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $startIndex = ($page - 1) * 4;
        $limit_per_page = 4;

        // Query to Database
        $stmt = "SELECT * FROM phonebook WHERE name LIKE '%$searchQuery%' UNION ";
        $stmt .= "SELECT * FROM phonebook WHERE mobiles LIKE '%$searchQuery%' UNION ";
        $stmt .= "SELECT * FROM phonebook WHERE emails LIKE '%$searchQuery%'ORDER BY name LIMIT $startIndex, $limit_per_page";
        $query = mysqli_query($connection, $stmt);


        // For making card collapisble
        $collapse = 1;

        // Fetching queries from Database
        while($result = mysqli_fetch_array($query)){
            // Return fetched details in cards
            echo '
            <div class="card">
            <!-- User Name -->
            <div class="card-header" id="heading<?php echo $collapse; ?>">
                <h5>';

                    if ($collapse == 1) {
                        $expand = 'true';
                    } else {
                        $expand = 'false';
                    }
                    echo '
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$collapse.'" aria-expanded="'.$expand.'" aria-controls="collapse'.$collapse.'">
                        '.$result['name'].'
                    </button>
                    <span class="btn-link text-right" data-toggle="collapse" data-target="#collapse'.$collapse.'" aria-expanded="'.$expand.'" aria-controls="collapse'.$collapse.'"><i class="fa fa-caret-down"></i></span>
                </h5>
            </div>
            <!-- Contacts -->
                            <div id="collapse'.$collapse.'" class="collapse show" aria-labelledby="heading'.$collapse.'" data-parent="#accordion">
                                <div class="card-body">
                                    <!-- Contacts Name -->
                                    <div class="name">
                                        <h5>
                                            '.$result['name'].'
                                            <span class="btn-link text-right" data-toggle="collapse" data-target="#collapse'.$collapse.'" aria-expanded="'.$expand.'" aria-controls="collapse'.$collapse.'"><i class="fa fa-caret-up"></i></span>
                                        </h5>
                                    </div>
                                    <!-- Contacts DOB -->
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <p class="DOB">'.$result['dob'].'</p>
                                        </div>
                                        <div class="col-sm-8 text-right operations">
                                            <button class="btn btn-info mr-2"><a href="updateContact.php?id='.$result['id'].'">Edit</a></button>
                                            <button class="btn btn-danger"><a href="deleteContact.php?id='.$result['id'].'">Remove</a></button>
                                        </div>
                                    </div>
                                    <!-- Contacts Details -->
                                    <div class="contact-details p-3">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <!-- Phone Numbers -->
                                                <div class="phone-numbers">';
                                                    $mobiles = explode(',', $result['mobiles']);
                                                    for ($i = 0; $i < count($mobiles); $i++) {
                                                ;
                                                echo '
                                                        <h5 class="number"><i class="fa fa-phone-square"></i>+91 '.$mobiles[$i].'</h5>';
                                                };
                                                echo '
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <!-- Email Address -->
                                                <div class="emails">';
                                                    $emails = explode(',', $result['emails']);
                                                    for ($i = 0; $i < count($emails); $i++) {
                                                    ;
                                                    echo '
                                                        <h5 class="email"><a href="mailto:'.$emails[$i].'"><i class="fa fa-envelope"></i> &nbsp; '.$emails[$i].'</a></h5>';
                                                    };
                                                echo '
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        $collapse++;
                        echo '
                </div>
            </div>';   
        }
        // Pagination here
        echo '
        <div class="Pagination justify-content-center mb-5 mt-3">';

                // Query to Database
                $stmt2 = "SELECT * FROM phonebook WHERE name LIKE '%$searchQuery%' UNION ";
                $stmt2 .= "SELECT * FROM phonebook WHERE mobiles LIKE '%$searchQuery%' UNION ";
                $stmt2 .= "SELECT * FROM phonebook WHERE emails LIKE '%$searchQuery%'";
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
                    $next = $number_of_pages;
                    $displayNext = "disabled";
                } else {
                    $next = $page + 1;
                    $displayNext = "";
                };
            echo '
            <nav aria-label="...">
                <ul class="pagination justify-content-center">
                    <li class="page-item '.$displayPrev.'">
                        <a class="page-link" href="index.php?page='.$previous.'"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                    </li>';
                    for ($i = 1; $i <= $number_of_pages; $i++) {
                        $i == $page ? $active = "active": $active="";
                    echo '
                    <li class="page-item '.$active.'"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                    };
                    echo '
                    <li class="page-item '.$displayNext.'">
                        <a class="page-link" href="index.php?page='.$next.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>';
    }
