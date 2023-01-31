<?php
    //page title
    $title = "Add Medicine";
    
    //header
    include('../../includes/header.php');

    //connect to the database
    include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    
    //statement to select the specific chicken to update
    $sql = "SELECT * FROM chickenproduction WHERE chickenBatch_ID = '$id'";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $coopNumber = $row['coopNumber'];
                $batchName = $row['batchName'];
                $breedType = $row['breedType'];
                $batchPurpose = $row['batchPurpose'];
                $startingQuantity = $row['startingQuantity'];
                $inStock = $row['inStock'];
                $dateAcquired = $row['dateAcquired'];
                $acquisitionType = $row['acquisitionType'];
                $note = $row['note'];
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
            // $sql = "UPDATE chickenproduction, schedules SET archive=:archived WHERE chickenBatch_ID = '$id'";
            // $sql = "UPDATE chickenproduction c, schedules s SET c.archive = :archived, s.archive = :archived WHERE c.chickenBatch_ID = s.chickenBatch_ID AND c.chickenBatch_ID = '$id'";
            $sql = "UPDATE chickenproduction c
            LEFT JOIN schedules s ON c.chickenBatch_ID = s.chickenBatch_ID
            SET c.archive = :archived, s.archive = :archived
            WHERE c.chickenBatch_ID = '$id'";

            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":archived", $param_archived, PDO::PARAM_STR);
                
                // Set parameters
                $param_archived = $archived;

                // Attempt to execute the prepared statement
                if($stmt->execute())
                {
                    $_SESSION['status'] = "Chicken Production Data is Successfully Archived.";
                    header("Location: chicken_production.php");
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

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Manager Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="./chicken_production.php" class="text-decoration-none">Chicken Production</a>
        </li>
        <li class="breadcrumb-item active">Update Chicken Production</li>
    </ol>

    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header fw-bold p-3" style="background-color: #f37e57;">
                <div class="text-center">ARCHIVE CHICKEN BATCH</div> <div>
                            <!-- <a class="small text-white" href="./chicken_production.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                            </a>  -->
                        </div>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <div class="card-body p-4">
                            <!-- egg batch id -->
                            <div class="mb-3">
                                <p class="fw-bold">Coop Number: <span class="fw-normal ps-2"><?php echo $coopNumber; ?></span></p>
                            </div>

                            <!-- egg Size -->
                            <div class="mb-3">
                                <p class="fw-bold">Batch Name: <span class="fw-normal ps-2"><?php echo $batchName; ?></span></p>
                            </div>
                    
                            <!-- Quantity -->
                            <div class="mb-3">
                                <p class="fw-bold">Breed Type: <span class="fw-normal ps-2"><?php echo $breedType; ?></span></p>
                            </div>

                            <!-- Collection Type -->
                            <div class="mb-3">
                                <p class="fw-bold">Starting Quantity: <span class="fw-normal ps-2"><?php echo $startingQuantity; ?></span></p>
                            </div>

                            
                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">In Stock: <span class="fw-normal ps-2"><?php echo $inStock; ?></span></p>
                            </div>

                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Date Acquired: <span class="fw-normal ps-2"><?php echo $dateAcquired; ?></span></p>
                            </div>

                            <!-- Collection Date -->
                            <div class="mb-3">
                                <p class="fw-bold">Acquisition Type: <span class="fw-normal ps-2"><?php echo $acquisitionType; ?></span></p>
                            </div>
                               
                            <!-- Note -->
                            <div class="mb-3">
                                <p class="fw-bold">Note: <span class="fw-normal ps-2"><?php echo $note; ?></span></p>
                            </div>

                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="card-footer w-100 border d-flex justify-content-between">
                            <div class="w-100 m-1">
                                <a class="small btn  btn-outline-danger fw-bold w-100" href="./chicken_production.php">
                                    Cancel
                                </a> 
                            </div>
                            <div class="w-100 m-1">
                                <button type="submit" name="archiveRecord" class="btn   btn-outline-success fw-bold w-100">
                                    Save
                                </button>                                    
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<!-- end of content -->

<?php
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>

