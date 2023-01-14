<?php 
    require "includes/nav.php";
    require "query/Query.php";

    $query = new Query();

    date_default_timezone_set('Asia/Yangon');
    $today_date = date('Y-m-d');
    //echo $today_date;

    $income = $query->select('incomes','*', null, "DATE(created_at)='$today_date'",null, '1');
    echo "<br>";
    var_dump($income);
    echo "<br>";
    //var_dump($income["id"]);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $total_income = $_POST['total-income'];
        $expand_name = $_POST['expand_name'];
        $expand_amount = $_POST['expand_amount'];
        $employee_expand_name = $_POST['employee_expand_name'];
        $employee_expand_amount = $_POST['employee_expand_amount'];

        try{
            if (isset($total_income)) {
                $datas = [
                    'total_income' => $total_income,
                ];
                $query->store('incomes',$datas);
            }

            if (isset($expand_name) && isset($expand_amount)) {
                for ($i=0; $i < count($expand_name); $i++) {
                    $datas = [
                        'reason' => $expand_name[$i],
                        'amount' => $expand_amount[$i]
                    ];
                    $query->store('expenses',$datas);
                }
            }

            if(isset($employee_expand_name) && isset($employee_expand_amount)) {
                for ($i=0; $i < count($employee_expand_amount); $i++) {
                    $datas = [
                        'employee_id' => $employee_expand_name[$i],
                        'amount' => $employee_expand_amount[$i]
                    ];
                    $query->store('employee_expenses',$datas);
                }
                
            }
            $income = $query->select('incomes','*', null, "DATE(created_at)='$today_date'",null, '1');
            $income_data_str = strtotime($income['created_at']);
            var_dump($income_data_str);
            $income_date= date("Y-m-d", $income_data_str);

             header("location:detail_income_expand.php?income_date=$income_date");
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    if($income == false) {

    

?>
    <div class="container my-4">
        <div class="row col-lg-6 col-md-8 col-12 offset-lg-3 offset-md-2">
            <h3 class=" mb-5">Create Income/Expenses Record</h3>
            <form action="" method="post" >
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Total Income</label>
                    <input type="number" class="form-control" name="total-income" id="exampleInputEmail1" placeholder="Total Income" aria-describedby="emailHelp"> 
                </div>
                <div class=" mb-3" id="list">
                    <div class="row mb-2">
                        <label class="col" for="exampleInputPassword1" class="form-label">Expenses</label>
                        <label class="col text-end add-expand-imcome" for=""><i data-feather="plus"></i></label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-7">
                            <input type="text" class="form-control" name="expand_name[]" placeholder="Expense" id="exampleInputPassword1">
                        </div>
                        <div class="col-5">
                            <input type="number" class="form-control" name="expand_amount[]" placeholder="Amount" id="exampleInputPassword1">
                        </div>
                    </div>
                </div>

                <div class=" mb-3" id="employee">
                    <div class="row mb-2">
                        <label class="col" for="exampleInputPassword1" class="form-label">Employee Expenses</label>
                        <label class="col text-end add-employee " for=""><i data-feather="plus"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <select class="form-select mb-3" name="employee_expand_name[]" aria-label="Default select example" placeholder="Select">
                                <option >Select</option>
                                <?php 
                                
                                    $employees = $query->select('employees');

                                    foreach( $employees as $employee) {
                                ?>
                                <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name'];?></option>

                                <?php 
                                    }
                                ?>
                            </select> 
                        </div>
                        <div class="col-5">
                            <input type="number" class="form-control"  name="employee_expand_amount[]" placeholder="Amount" id="exampleInputPassword1">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn border border-dark col-12">သိမ်းမည်</button>
            </form>
        </div>
    </div>

<?php 

                                }else{

                                    $income_data_str = strtotime($income['created_at']);
                                    $income_date= date("Y-m-d", $income_data_str);
                                    //var_dum($income_data_str);
                                    header("location:detail_income_expand.php?income_date=$income_date");
                                }

?>


    <script>
        $(document).ready(function() {
            $('.add-expand-imcome').on('click',function() {
                
                let data = `
                        <div class="row mb-3">
                            <div class="col-7">
                                <input type="text" class="form-control" name="expand_name[]" placeholder="Expense" id="exampleInputPassword1">
                            </div>
                            <div class="col-5">
                                <input type="number" name="expand_amount[]" class="form-control" placeholder="Amount" id="exampleInputPassword1">
                            </div>
                        </div>`;

                $('#list').append(data);
            });

            $('.add-employee').on('click',function() {
                let employee = `
                            <div class="row">
                                <div class="col-7">
                                    <select class="form-select mb-3" name="employee_expand_name[]" aria-label="Default select example" placeholder="Select">
                                        <option selected>Select</option>
                                        <?php 
                                
                                            $employees = $query->select('employees');

                                            foreach( $employees as $employee) {

                                            
                                        
                                        ?>
                                        <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name'];?></option>

                                        <?php 
                                            }
                                        ?>
                               
                                    </select> 
                                </div>
                                <div class="col-5">
                                    <input type="number" name="employee_expand_amount[]" class="form-control" placeholder="Amount" id="exampleInputPassword1">
                                </div>
                            </div>`;
                $('#employee').append(employee);
            });

        });
    </script>

<?php 

    require "includes/footer.php";

?>