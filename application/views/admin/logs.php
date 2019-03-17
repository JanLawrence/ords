<!-- List of Users -->
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <h2>User Logs</h2>
                <div class="text-right">
                    <!-- <a href="#" class="btn btn-secondary btn-sm mb-4" data-toggle="modal" data-target="#addModal"><i class="ti-plus"></i> Add User</a> -->
                </div>
                <table class="table table-bordered table-striped table-hovered" id="tableList">
                    <thead>
                        <tr>
                            <th style="width: 10%">Date</th>
                            <th style="width: 50%">Name</th>
                            <th style="width: 40%">Transaction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Variable $userList was declared in Admin Controller $data['userList'] -->
                        <!-- Displays Data of $userList -->
                        <?php 
                            foreach($logs as $each){
                        ?>
                            <tr>
                                <td><?= date('F d, Y H:i A', strtotime($each->date_created))?></td>
                                <td><?= $each->name?></td>
                                <td><?= $each->transaction?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#tableList').DataTable();
    })
</script>