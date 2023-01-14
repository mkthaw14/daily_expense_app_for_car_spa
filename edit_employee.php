<?php 
    require "includes/nav.php";
    require "query/Query.php";

    ini_set("display_errors", "1");
    ini_set("display_startup_errors", "1");
    error_reporting(E_ALL);

    $query = new Query();
    $employee_id = $_GET['employee_id'];
    $employees = $query->select('employees','*',null, 'id = '.$employee_id);
    // var_dump($employees);

   // var_dump($employee_id);
   $post_method = $_SERVER["REQUEST_METHOD"] == "POST";
   echo "<br>";
   var_dump($post_method);

    if($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $name = $_POST['employee_name'];
        $nrc = $_POST['employee_nrc'];
        $salary = $_POST['employee_salary'];
        $birthday = $_POST['employee_birthday'];
        $description = $_POST['employee_description'];
        $address = $_POST['employee_address'];
    
        var_dump($employee_id);
        
        try{
            if(isset($name) && isset($nrc) && isset($salary) && isset($birthday) && isset($description) && isset($address)) {
                $employees = [
                    'name' => $name,
                    'nrc' => $nrc,
                    'salary' => $salary,
                    'dob' => $birthday,
                    'description' => $description,
                    'address' => $address
                ];
                $query->update('employees', $employees, 'id = '.$employee_id);
            }

           
           
        }catch(PDOException $e){
            echo $e->getMessage();
        }
      
        
        
        header("location:employee.php");
    }

?>
    <div class="container my-4">
        <div class="row col-lg-6 col-md-8 col-12 offset-lg-3 offset-md-2">
            <h3 class=" mb-5">Edit Employee</h3>
            <form action="" method="post" >
           
                <?php 
                    foreach ($employees as $employee) {
                ?>
                
        
                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <label class="col" for="exampleInputPassword1" class="form-label">Name</label>
                        <label class="col text-end add-expand-imcome" for="">NRC</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-12 mb-3">
                            <input type="text" class="form-control" name="employee_name" required placeholder="Name" value="<?php echo $employee['name'] ?>" id="">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <input type="text" class="form-control" name="employee_nrc" required placeholder="NRC" value="<?php echo $employee['nrc'] ?>">
                        </div>
                    </div>
                </div>

                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <label class="col" for="exampleInputPassword1" class="form-label">Salary</label>
                        <label class="col text-end add-expand-imcome" for="">Birth Day</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-12 mb-3">
                            <input type="numver" class="form-control" name="employee_salary" required placeholder="Salary"  value="<?php echo $employee['salary'] ?>" >
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <input type="date" class="form-control" name="employee_birthday" required placeholder="Birth Day" value="<?php echo $employee['dob'] ?>">
                        </div>
                    </div>
                </div>

                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <label class="col" for="exampleInputPassword1" class="form-label">Description</label>
                        <label class="col text-end add-expand-imcome" for="">Address</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-12 mb-3">
                            <input type="text" class="form-control" name="employee_description" required placeholder="Description" value="<?php echo $employee['description'] ?>">
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <input type="text" class="form-control" name="employee_address" required placeholder="Address" value="<?php echo $employee['address'] ?>" >
                        </div>
                    </div>
                    <?php }?>
                
                <button type="submit" class="btn border border-dark col-12">Update</button>
            </form>
        </div>
    </div>

   
<?php 

    require "includes/footer.php";

?>