<?php 

    require "includes/nav.php";
    require "query/Query.php";
    $query = new Query();
    
    date_default_timezone_set('Asia/Yangon');
    $today_date = date('Y-m-d');
    $month = date('m');
    echo $month."<br>";
    $incomes = $query->select('incomes','*', null, "MONTH(created_at)='$month'");
   

    $expands = $query->select('expands','*', null, "MONTH(created_at)='$month'");
    $employee_expands = $query->select('employee_expands', 'employee_expands.*, employees.name as e_name','employees ON employee_expands.employee_id = employees.id', "DATE(employee_expands.created_at)='$today_date'");

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $date = $_POST['find_date'];
        var_dump($date);


    }

?>

<div class="container my-4">
        <div class="row col-lg-6 col-md-8 col-12 offset-lg-3 offset-md-2">
            <!-- <h3 class=" mb-5">စုစုပေါင်းဝင်ငွေ</h3> -->
            <form action="" class="" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">စုစုပေါင်းဝင်ငွေ</label>
                    <input type="date" class="form-control" name="find_date" id="exampleInputEmail1" placeholder="စုစုပေါင်းဝင်ငွေ" aria-describedby="emailHelp">
                    
                </div>
               
                <a href="detail_income_expand.php?" class="btn border border-dark col-12">ကြည့်မယ်</a>
            </form>
            <hr class="mt-5">
            <p class="text-center">ဝင်ငွေနှင့်အသုံးများ</p>
            <div class="table-responsive">
             
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Income</th>
                            <th>Remain</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($incomes as $income) {
                        ?>
                        <tr>
                            <td><?php echo Date($income['created_at'])?></td>
                            <td><?php echo $income['total_income']?></td>
                            <td><?php echo $income['total_income']?></td>
                           
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php 

    require "includes/footer.php";

?>