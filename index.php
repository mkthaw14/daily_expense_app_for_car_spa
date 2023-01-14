
<?php 
    require "includes/nav.php";
    require "query/Query.php";

    $query = new Query();
    $where = "Year(CURRENT_DATE()) = Year(created_at) And Month(CURRENT_DATE()) = Month(created_at)";
    $incomes = $query->select("incomes", "*", null, $where, "DATE(created_at) DESC", null);
    //var_dump($incomes);



?>
                <!-- Page content-->
                <div class="container-fluid">
                    <div class="row mt-5 d-flex justify-content-center">
                        <form class="col-5" method="GET" action="detail_income_expand.php">
                            <label for="" class="form-label">Total Income</label>
                            <div class="mb-3">
                                <input name="income_date" class="form-control" type="date" placeholder="Select a date" required="required" />
                            </div>
                            <div class="mb-5">
                                <input class="form-control" type="submit" value="Search">
                            </div>
                            <hr/>
                        </form>
                    </div>


                    <div class="row mt-5 d-flex justify-content-center">
                        <h5 class="text-center mb-5">Income & Expenses</h5>
                        <div class="col-5">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Income</th>
                                            <th>Net Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($incomes as $income)
                                            {
                                                $income_date_str = strtotime($income["created_at"]);
                                                $income_date = date("Y-m-d", $income_date_str);
                                                // echo "income date : ".$income_date;
                                                $expenses = $query->select("expenses", "amount", null, "DATE(created_at) = '$income_date' ", null, null);

                                                $net_income = $income["total_income"];
                                                $total_expenses = 0;
                                                foreach($expenses as $exp)
                                                {
                                                    //echo "<br>".$exp["amount"];
                                                    $total_expenses += $exp["amount"];
                                                }
                                                $employee_expenses = $query->select("employee_expenses", "amount", null, "DATE(created_at) = '$income_date'", null, null);

                                                foreach($employee_expenses as $emp_exp)
                                                {
                                                    //echo "<br>".$emp_exp["amount"];
                                                    $total_expenses += $emp_exp["amount"];
                                                }

                                                $net_income -= $total_expenses;
                                                //var_dump($employee_expenses);
                                                ?>

                                                    <tr>
                                                        <td><a href="detail_income_expand.php?income_date=<?php  echo $income_date; ?>"><?php  echo $income_date; ?></a> </td>
                                                        <td><?php echo $income["total_income"]; ?></td>
                                                        <td><?php echo $net_income; ?></td>
                                                    </tr>

                                                <?php 
                                            }
                                        ?>

                                    </tbody>

                                </table>
                        </div>

                    </div>

                </div>
<?php 
    require "includes/footer.php";

?>