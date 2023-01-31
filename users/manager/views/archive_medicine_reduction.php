<?php
    //title of the pge
    $title = "Medicine Inventory - Reductions";

    include("../../includes/header.php");

    //database connection, located in the config directory
    include('../../../config/database_connection.php');

    //connect to the database
    include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    
    //statement to select the specific schedule to update
    $sql = "SELECT * FROM medicinereduction WHERE reduction_ID = '$id'";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $reduction_ID = $row['reduction_ID'];
                $medicine_ID = $row['medicine_ID'];
                $medicineName = $row['medicineName'];
                $quantity = $row['quantity'];
                $reductionType = $row['reductionType'];
                $dateReduced = $row['dateReduced'];
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    unset($pdo);

    try{
        
        //processing the data from the form submitted
        if(isset($_POST['archiveRecord'])){
            $id = $_POST['id'];
                $archived = 'archived';

            // Prepare an insert statement
            $sql = "UPDATE medicinereduction SET archive=:archived WHERE reduction_ID = '$id'";
            
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Medicine Reduction Data is Successfully Archived.";
                    header("Location: medicine_reduction.php");
                } 
                else
                {
                echo "Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
            
        
        }
        

    }catch(PDOException $e){
        echo ("Error: " . $e->getMessage());
    }
?>

<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicine_reduction.php" style="text-decoration: none">Medicine Inventory</a>
        </li>
        <li class="breadcrumb-item active">Medicine ReductionDetails</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57">
                    <div class="text-center">ARCHIVE THIS RECORD</div>
                </div>
                        <div class="card-body p-4">
                            <!-- egg batch id -->
                            <div class="mb-3">
                                <p class="fw-bold">Reduction ID: <span class="fw-normal ps-2"><?php echo $reduction_ID; ?></span></p>
                            </div>

                            <!-- egg Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine ID: <span class="fw-normal ps-2"><?php echo $medicine_ID; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Medicine Name: <span class="fw-normal ps-2"><?php echo $medicineName; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Quantity: <span class="fw-normal ps-2"><?php echo $quantity; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Reduction Type: <span class="fw-normal ps-2"><?php echo $reductionType; ?></span></p>
                            </div>
                               
                            <!-- Note -->
                            <div class="mb-3">
                                <p class="fw-bold">Date Reduced: <span class="fw-normal ps-2"><?php echo $dateReduced; ?></span></p>
                            </div>

                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-danger w-100 fw-bold" href="./medicine_reduction.php">
                                    Cancel
                                </a>                                 
                            </div>
                            <div class="m-1 w-100">
                                <button type="submit" name="archiveRecord" class="btn btn-outline-success w-100 fw-bold">
                                    Yes
                                </button>                                   
                            </div>
                        </div>
                    </form>
                    
            </div>
        </div>
    </div>
</div>

<!-- content --> 
<!-- <div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./medicine_reduction.php" style="text-decoration: none">Medicines Reduction</a>
        </li>
        <li class="breadcrumb-item active">Update Medicine Reduction</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold p-3" style="background-color: #f37e57">Archive Record</div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-end">
                            <div class="m-1 w-100">
                                <a class="small btn btn-outline-danger w-100 fw-bold" href="./medicine_reduction.php">
                                    Cancel
                                </a>                                 
                            </div>
                            <div class="m-1 w-100">
                                <button type="submit" name="archiveRecord" class="btn btn-outline-success w-100 fw-bold">
                                    Yes
                                </button>                                   
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div> -->
<!-- end of content -->

<?php
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>

