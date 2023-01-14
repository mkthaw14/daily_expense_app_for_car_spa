<?php 

    require "includes/nav.php";
    require "query/Query.php";

    $query = new Query();
    $employees = $query->select('employees','*',null, null, 'id ASC');
    //var_dump($employees);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

       

        if(isset($_POST['employee_del'])) {
            $id = $_POST['employee_del'];
            $query->delete('employees', 'id = '.$id);
            header("location:".$_SERVER['HTTP_REFERE']);
          }
    }

?>

<div class="container">
<div class=" card  my-5">
        <div class="card-header d-sm-flex align-items-center justify-content-between  py-3 ">
            <p class="m-0 font-weight-bold text-primary ">Employee List</p>
            <a href="add_employee.php" class="btn btn-primary rounded-pill btn-sm px-4">Add</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Salary</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $j =1;
                            foreach($employees as $employee) {
                        
                        ?>
                        <tr>
                            <td><?php echo $j++ ?></td>                            
                            <td><?php echo $employee['name'] ?></td>
                            <td><?php echo $employee['dob'] ?></td>
                            <td><?php echo $employee['salary'] ?></td>
                            <td class="d-flex">
                      
                                <button type="button" data-name="<?php echo $employee['name'] ?>" data-birthday="<?php echo $employee['dob'] ?>" data-salary="<?php echo $employee['salary'] ?>" data-nrc="<?php echo $employee['nrc'];?>" data-address="<?php echo $employee['address'];?>" class="btn btn-sm text-primary detail" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <i data-feather="info"></i>
                                </button>
                
                                <a href="edit_employee.php?employee_id=<?php echo $employee['id']; ?>" class="btn btn-sm text-warning"><i data-feather="edit"></i></a>
                                <form action="" method="post">
                                    <input type="hidden" name="employee_del" value="<?php echo $employee['id'] ?>">
                                    <button type="submit" class="btn btn-sm text-danger" onclick="return confirm('Are you sure to delete');" ><i data-feather="trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Salary</th>
                            <th>Date of Birth</th>
                            <th>action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Employee Detail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                
                                                <div class="text-center">
                                                    <h5 id="detail_name"></h5>
                                                    <h5 id="detail_birthday"></h5>
                                                    <h5 id="detail_nrc"></h5>
                                                    <h5 id="detail_salary"></h5>
                                                    <h5 id="detail_address"></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            
                                        </div>
                                        </div>
                                    </div>
                                </div>  



    <script>
        $(document).ready(function() {
            $('tbody').on('click','.detail',function() {
                let name = $(this).data('name');
                let birthday = $(this).data('birthday');
                let nrc = $(this).data('nrc');
                let salary = $(this).data('salary');
                let address = $(this).data('address');


                $('#detail_name').text(name);
                $('#detail_birthday').text(birthday);
                $('#detail_nrc').text(nrc);
                $('#detail_salary').text(salary);
                $('#detail_address').text(address);

            })
        });
    </script>
<?php 

    require "includes/footer.php";

?>