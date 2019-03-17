<!-- List of Users -->
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <h2>User Logs</h2>
                <div class="text-right">
                    <!-- <a href="#" class="btn btn-secondary btn-sm mb-4" data-toggle="modal" data-target="#addModal"><i class="ti-plus"></i> Add User</a> -->
                </div>
                <form method="get">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>From</label>
                            <input type="date" class="form-control" name="from" value="<?= isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : ''?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>To</label>
                            <input type="date" class="form-control" name="to" value="<?= isset($_GET['to']) && $_GET['to'] != '' ? $_GET['to'] : ''?>">
                        </div>
                        <div class="form-group col-md-3 mt-4">
                            <button type="submit" class="btn btn-info"> Generate</button>
                        </div>
                    </div>
                </form>
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