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

    <title>Add New Contact - Phone Book</title>
</head>

<body>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="container">
        <!-- Main content -->
        <div class="main-content">
            <div class="add-contact-form p-3">
                <div class="heading mb-2">
                    <a href="index.php"><i class="fa fa-arrow-left"></i></a> &nbsp;&nbsp;
                    Add New Contact
                </div>
                <span class="message"></span>
                <form id="add-form">
                    <!-- Name -->
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control" placeholder="Name"  oninput="this.value = this.value.replace(/[^a-zA-Z.]/g, '').replace(/(\..*)\./g, '$1');" name="name" required>
                    </div>

                    <!-- DOB -->
                    <div class="form-group">
                        <label for="inputDOB">DOB</label>
                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" id="dob" name="dob">
                    </div>

                    <!-- Mobile Numbers -->
                    <label for="inputNumber">Mobile Number</label>
                    <div class="mobile-numbers">
                        <div class="form-row">
                            <div class="col-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="+91 XXXXXXXXXX" maxlength="10"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="number[]" required>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <button class="btn btn-add" id="add-numbers-input"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Emails -->
                    <label for="inputEmail">Email Address</label>
                    <div class="emails">
                        <div class="form-row">
                            <div class="col-10">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="abc@gmail.com"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9@.]/g, '').replace(/(\..*)\./g, '$1');" name="emails[]" required>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <button class="btn btn-add" id="add-email-input"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="btn btn-success text-right btn-save" name="save">Save</button>
                </form>
                <br><br>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add more mobile number input fields
            $('#add-numbers-input').click(function(e) {
                e.preventDefault();
                $('.mobile-numbers').append(`<div class="form-row" id="new-numbers-input">
                        <div class="col-10">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="+91 XXXXXXXXXX" id="number" name="number[]">
                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <button class="btn btn-add" id="remove-mobile"><i class="fa fa-times"></i></button>
                        </div>
                    </div>`);
            });

            // Delete Newly Added Number Input box
            $(document).on('click', '#remove-mobile', function(e) { //user click on remove text links
                e.preventDefault();
                $(this).closest('#new-numbers-input').remove();

            });

            // Add more emails input fields

            $('#add-email-input').click(function(e) {
                e.preventDefault();
                $('.emails').append(`<div class="form-row" id="new-emails-input">
                            <div class="col-10">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="abc@gmail.com" id="email" name="emails[]">
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <button class="btn btn-add" id="remove-email"><i class="fa fa-times"></i></button>
                            </div>
                        </div>`);
            });

            // Delete Newly Added Email Input box
            $(document).on('click', '#remove-email', function(e) { //user click on remove text links
                e.preventDefault();
                $(this).closest('#new-emails-input').remove();

            });

            // Get Form data entered by user
            $('#add-form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: 'insertContact.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#add-form')[0].reset();
                        $('.message').html(response);
                    }
                });
            });
        });
    </script>


    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    
</body>

</html>