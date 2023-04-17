<?php

require_once('scheme/core.php');

//create object of database/Model class
$db = new Model();

//session user validation
if (empty($_SESSION['username'])) {
    redirect('login');
}


?>

<?php
 require_once("includes/header.php");
?>

<!-- topbar -->
<?php
 require_once("includes/topbar.php");
?>
<!-- end topbar -->

<!-- Container - Fluid -->
<div class="container-fluid pt-5">
    <!-- Row -->
    <div class="row">

        <!-- sidebar -->
        <?php
        require_once("includes/sidebar.php");
        ?>
        <!-- end side bar -->

        <!-- Main -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-2 bg-white maincontent">

            <!-- BreadCrumb -->
            <nav aria-label="breadcrumb" class="pt-3 mb-2 bg-white border-bottom mx-2">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" class="breadcrumb-link"><i class="fa fa-dashboard"></i>
                            Dashboard</a></li>
                    <li class="breadcrumb-item"> add capital </li>
                </ul>
            </nav>
            <!-- End BreadCrumb -->

            <!-- title -->
            <div class="justify-content-between align-items-center pt-1 pb-2 mb-3 border-bottom mx-2">
                <h5 class="h5 mt-3 mb-0 color-darkgray"> Add Capital <small></small></h5>
            </div>
            <!-- end title -->




            <!-- container-fluid -->
            <div class="container-fluid-xxl pb-2">
                <!-- COL 12 -->
                <div class="col-md-12 float-sm-start">

                    <div class="col-md-12 float-sm-start p-2">
                        <!-- Alert -->

                        <?php

                            if(isset($_POST['submit'])){

                                // check CSRF before save - for security purposes
                                if(CSRFProtect($_POST['token']))
                                {
                                    // apply security to your data using our cleanData() function (or use directly the trim() & stripslashes() php built-in functions)
                                    $pig_id = cleanData($_POST['pig_id']);
                                    $exp_description = cleanData($_POST['exp_description']);
                                    $exp_remarks = cleanData($_POST['exp_remarks']);
                                    $exp_item_amount = cleanData($_POST['exp_item_amount']);
                                    $exp_item_count = cleanData($_POST['exp_item_count']);
                                    $date_purchaised = cleanData($_POST['date_purchaised']);
                                    $fare_per_item = cleanData($_POST['fare_per_item']);
                                    
                                    // save
                                    if($db->add_expenses($pig_id, $exp_description, $exp_remarks, $exp_item_amount, $exp_item_count, $date_purchaised, $fare_per_item)){
                                        // redirect function - from scheme/setting_functions.php
                                        redirect('expensesList_view');
                                    }else{
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <h4 class="alert-heading">Something went wrong!</h4>
                                            <p></p>
                                            <hr>
                                            <p class="mb-0"> There was an error in your transaction! </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
                                    }
                                }
                            }
                            
                        ?>


                    </div>

                    <!-- Form -->
                    <form action="" method="post" class="outer-form" autocomplete="off" id="validate">


                        <!-- col -->
                        <div class="col-md-12 float-sm-start">

                            <div class="col-md-6 p-2 float-sm-start">
                                <div class="card">
                                    <div class="card-header" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSchoolInfo" aria-expanded="true"
                                        aria-controls="collapseSchoolInfo">
                                        <span class="card-icon"><i class="fa fa-users"></i></span>
                                        Pig Information<i class="fa fa-caret-down pull-right"></i>
                                    </div>
                                    <div class="card-body accordion-collapse collapse show"
                                        id="collapseSchoolInfo-disable">

                                        <!-- HIDDEN input for CSRF Protection -->
                                        <input type="hidden" name="token" value="<?php echo CSRFToken(); ?>">

                                        <div class="col-md-12 mb-2">
                                            <label for="pig_id" class="form-label">Owner Pigs*</label>
                                            <select class="form-control form-control-sm" name="pig_id" id="pig_id"
                                                data-toggle="tooltip" data-placement="right" title="Owner Pigs"
                                                required>

                                                <!-- serve as placeholder -->
                                                <option value="" disabled selected>-- Choose Owner --</option>

                                                <?php 
                                                    // we can also reuse the function used in other page table or create new one (we will use it to display in combobox)
                                                    $pigs = $db->view_pigs_select('active'); 
                                                    foreach($pigs as $pig)
                                                    {
                                                        // use security for viewing records from your database using our Sanitize() methods
                                                        // or use directly the php built-in function htmlspecialchars($owner[full_name], ENT_QUOTES, 'UTF-8');
                                            
                                                ?>

                                                <option value="<?php echo $pig['pig_id']; ?>">
                                                    <?php echo Sanitize($pig['full_name']); ?> -
                                                    <?php echo Sanitize($pig['nurture_batch_name']); ?>
                                                    (<?php echo Sanitize($pig['no_of_pig']); ?>)</option>

                                                <?php } ?>

                                            </select>

                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="exp_item_amount" class="form-label">Expenses amount per item
                                                *</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="exp_item_amount" id="exp_item_amount" placeholder=""
                                                data-toggle="tooltip" data-placement="right"
                                                title="Expenses amount per item " required>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="exp_item_count" class="form-label">No. of items *</label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="exp_item_count" id="exp_item_count" placeholder=""
                                                data-toggle="tooltip" data-placement="right" title="No. of items"
                                                required>
                                        </div>


                                    </div>
                                    <!-- End Card Body -->
                                </div>
                                <!-- End card -->
                            </div>


                            <div class="col-md-6 p-2 float-sm-start">
                                <div class="card">
                                    <div class="card-header" data-bs-toggle="collapse" data-bs-target="#collapseSchool"
                                        aria-expanded="true" aria-controls="collapseSchool">
                                        <span class="card-icon"><i class="fa fa-plus"></i></span> Additional
                                        info.<i class="fa fa-caret-down pull-right"></i>
                                    </div>
                                    <div class="card-body accordion-collapse collapse show" id="collapseSchool-disable">



                                        <div class="col-md-12 mb-2">
                                            <label for="exp_description" class="form-label">Description *</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="exp_description" id="exp_description" placeholder=""
                                                data-toggle="tooltip" data-placement="right" title="Description"
                                                required>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="exp_remarks" class="form-label">Remarks</label>
                                            <input type="text" class="form-control form-control-sm" name="exp_remarks"
                                                id="exp_remarks" placeholder="" data-toggle="tooltip"
                                                data-placement="right" title="Remarks">
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="fare_per_item" class="form-label">Fare per items </label>
                                            <input type="text" class="form-control form-control-sm" name="fare_per_item"
                                                id="fare_per_item" placeholder="" data-toggle="tooltip"
                                                data-placement="right" title="Fare per items">
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="date_purchaised" class="form-label">Date Purchaised *</label>
                                            <input type="date" class="form-control form-control-sm"
                                                name="date_purchaised" id="date_purchaised" placeholder=""
                                                data-toggle="tooltip" data-placement="right" title="Date Purchaised"
                                                required>
                                        </div>



                                    </div>
                                    <!-- End Card Body -->
                                </div>
                                <!-- End card -->
                            </div>


                        </div>
                        <!-- end col- -->


                        <!-- Col- -->
                        <div class="col-md-12 p-2 float-sm-start pb-5">
                            <div class="card" style="border-bottom: none">
                                <div class="card-header" style="border: none">

                                    <input type="submit" id="submit" value="Submit" name="submit"
                                        class="btn btn-sm btn-success">

                                </div>
                                <!-- End Card Body -->
                            </div>
                            <!-- End card -->
                        </div>
                        <!-- end col- -->


                    </form>
                    <!-- End Form -->


                </div>
                <!-- END COL 12 -->
            </div>
            <!-- End container-fluid -->





            <!-- Footer -->
            <?php
            require_once("includes/footbar.php");
            ?>
            <!-- End Footer -->

        </main>
        <!-- End Main -->

    </div>
    <!-- End Row -->
</div>
<!-- End Container - Fluid -->

<?php
require_once("includes/footer.php");
?>