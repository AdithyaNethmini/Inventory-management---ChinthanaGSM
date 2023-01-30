<?php
    #Headers for accept requests from remote origin
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    session_start();

    require_once('./db_connect.php');
    $conn = getConnection ();

    #This will output supplier details with all html components needed to front-end - That's why the echo is too long
    $sql = "SELECT * FROM `supplier`";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <li class='list-group-item'>
                <div class='row'>
                    <div class='col-xl-1 col-lg-1'>
                        ".$row["sup_id"]."
                    </div>
                    <div class='col-xl-2 col-lg-2'>
                        ".$row["sup_name"]."
                    </div>
                    <div class='col-xl-3 col-lg-3'>
                        ".$row["sup_address"]."
                    </div>
                    <div class='col-xl-2 col-lg-2'>
                        ".$row["sup_tele"]."
                    </div>
                    <div class='col-xl-3 col-lg-3'>
                        ".$row["sup_email"]."
                    </div>
                    <div class='col-xl-1 col-lg-1'>
                        <button type='button' class='btn btn-circle btn-primary btn-sm' data-toggle='modal' data-target='#edit_supplier' onclick='setEditsupid".$row["sup_id"]."()'><i class='fas fa-edit'></i></button>
                        <button type='button' class='btn btn-circle btn-danger btn-sm' data-toggle='modal' data-target='#delete_confirm' onclick='setsupid".$row["sup_id"]."()'><i class='fas fa-trash' id='trashicon'></i></button>
                        <script>
                        function setsupid".$row["sup_id"]."() {
                            document.getElementById('selectedToDel').innerHTML = ".$row["sup_id"].";
                        }
                        function setEditsupid".$row["sup_id"]."() {
                            document.getElementById('selectedToEdit').innerHTML = ".$row["sup_id"].";
                            document.getElementById('comname').value = '".$row["sup_name"]."';
                            document.getElementById('supaddress').value = '".$row["sup_address"]."';
                            document.getElementById('suptp').value = '".$row["sup_tele"]."';
                            document.getElementById('supemail').value = '".$row["sup_email"]."';
                        }
                        </script>
                    </div>
                    <div class='modal' id='edit_supplier'>
                        <div class='modal-dialog modal-dialog-scrollable modal-dialog-centered'>
                            <div class='modal-content'>                                      
                                <!-- Modal body -->
                                <div class='modal-body'>
                                    <!-- Nested Row within Card Body -->
                                    <div class='row'>
                                        <div class='col-lg-12'>
                                            <div class='p-5'>
                                                <div class='text-center'>
                                                    <h1 class='h4 text-gray-900 mb-4'>Modify Supplier Details</h1>
                                                </div>
                                                <form class='user'>
                                                    <div class='form-group'>
                                                        <input type='text' class='form-control form-control-user' id='comname' placeholder='Company Name' name='companyName'>
                                                    </div>
                                                    <div class='form-group'>
                                                        <input type='text' class='form-control form-control-user' id='supaddress' placeholder='Address' name='address'>
                                                    </div>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-6 mb-3 mb-sm-0'>
                                                            <input type='text' class='form-control form-control-user' id='suptp' placeholder='Telephone' name='tp'>  
                                                        </div>
                                                        <div class='col-sm-6'>
                                                            <input type='text' class='form-control form-control-user' id='supemail' placeholder='E-mail' name='email'>
                                                        </div>
                                                    </div>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-6 mb-3 mb-sm-0'>
                                                            <button type='button' class='btn btn-primary btn-user btn-block mb-3' onclick='callEdit()' data-dismiss='modal'>
                                                                <i class='fas fa-file-import fa-fw'></i> Submit<span id='save-btn-spinner' class='spinner-border-sm'></span>
                                                            </button>
                                                        </div>
                                                        <div class='col-sm-6'>
                                                            <button type='reset' class='btn btn-danger btn-user btn-block mb-3' data-dismiss='modal'>
                                                                <i class='fas fa-backspace fa-fw'></i> Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal' id='delete_confirm'>
                        <div class='modal-dialog modal-dialog-scrollable modal-dialog-centered'>
                            <div class='modal-content'>                                      
                                <!-- Modal body -->
                                <div class='modal-body'>
                                    <!-- Nested Row within Card Body -->
                                    <div class='row'>       
                                        <div class='col-lg-12'>
                                            <div class='p-5'>
                                                <div class='text-center'>
                                                    <h1 class='h4 text-gray-900 mb-4'>Are you sure?</h1>
                                                    <p>You are about to permanantly delete a record..!</p>
                                                </div>
                                                <form class='user'>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-6 mb-3 mb-sm-0'>
                                                            <button type='button' class='btn btn-secondary btn-user btn-block mb-3' data-dismiss='modal'>
                                                                <i class='fas fa-file-import fa-fw'></i> Cancel
                                                            </button>
                                                        </div>
                                                        <div class='col-sm-6'>
                                                            <button type='button' class='btn btn-danger btn-user btn-block mb-3' data-dismiss='modal' onclick='callDelete()'>
                                                                <i class='fas fa-backspace fa-fw'></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ");
        }
    } else {
        echo "0 results";
    }
?>