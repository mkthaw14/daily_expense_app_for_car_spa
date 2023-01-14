<?php 
    require "includes/nav.php";
    require "query/Query.php";

    $query = new Query();

    $get_income_date = $_GET['income_date'];
    //var_dump($get_income_date);
    echo "<br>";
    $income = $query->select('incomes','*', null, "DATE(created_at)='$get_income_date'",null, '1');
    var_dump($income);

    if($income == false)
    {
        header("location:404.php");
    }
    else
    {

    
        $incomeDate = date("d.m.Y", strtotime($income['created_at'])); 

        $expands = $query->select('expenses','*', null, "DATE(created_at)='$get_income_date'");
        //var_dump($expand);
        
        $expands_total = 0;
        foreach($expands as $expand) {
            $expands_total += $expand['amount'];
        
        }

        $employee_expands = $query->select('employee_expenses', 'employee_expenses.*, employees.name as e_name','employees ON employee_expenses.employee_id = employees.id', "DATE(employee_expenses.created_at)='$get_income_date'");
        //var_dump($employee_expands);
        $employee_expand_total = 0;
        foreach($employee_expands as $employee_expand) {
            $employee_expand_total += $employee_expand['amount'];
        }
    
        $All_empand =$expands_total + $employee_expand_total;


?>
    <div class="container my-4">
        <div class="row col-lg-6 col-md-8 col-12 offset-lg-3 offset-md-2">
            <p class="text-center m-0">Date <?php echo $incomeDate?> </p>
            <p class="mb-4 text-center">Income & Expenses</p>
            <form action="" method="post" >
           
                
                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <p class="col" for="exampleInputPassword1" class="form-label">Total Income</p>
                        <p class="col text-end add-expand-imcome" for=""><?php echo $income['total_income']?> Ks</p>
                    </div>
                    <div class="row mb-2">
                        <h6 class="col fw-bold" for="exampleInputPassword1" class="form-label">Expenses</h6>
                    </div>
                    <?php 
                        foreach($expands as $expand) {
                    ?>
                    <div class="row mb-2">
                        <p  class="col" for="exampleInputPassword1" class="form-label"><?php echo $expand['reason'];?></p>
                        <p class="col text-end " for=""><?php echo $expand['amount'];?> Ks</p >
                    </div>
                    <?php 
                        }
                    ?>
                    <div class="row mb-2">
                        <h6 class="col fw-bold" for="exampleInputPassword1" class="form-label">Employee Expenses</h6>
                    </div>
                    <?php 
                        foreach ($employee_expands as $employee_expand) {
                    ?>
                    <div class="row mb-2">
                        <p  class="col" for="exampleInputPassword1" class="form-label"><?php echo $employee_expand['e_name']?></p>
                        <p class="col text-end " for=""><?php echo $employee_expand['amount']?> Ks</p >
                    </div>
                    <?php 
                        }
                    ?>
                </div>
                <hr>
                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <p class="col" for="exampleInputPassword1" class="form-label">Total Income</p>
                        <p class="col text-end " for=""><?php echo $income['total_income']?>  Ks</p>
                    </div>
                    <div class="row mb-2">
                        <p class="col" for="exampleInputPassword1" class="form-label">Total Expenses</p>
                        <p class="col text-end" for=""><?php echo $All_empand?> Ks</p>
                    </div>

                </div>
                <hr>
                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <p class="col" for="exampleInputPassword1" class="form-label">Net Income</p>
                        <p class="col text-end fw-bold" for=""><?php echo $income['total_income'] - $All_empand?> Ks</p>
                    </div>
                </div>
            
             
                
                <a href="edit_expense_income.php?income_date=<?php echo $get_income_date; ?>" class="btn border border-dark col-12">Edit</a>
            </form>
        </div>
    </div>

   
<?php 
   
    }

    require "includes/footer.php";

?>