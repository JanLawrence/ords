<!-- Landing Page of Researcher User -->
<div class="row">
    <div class="col-md-12">
        <!-- Form for creating new research-->
        <form id="newResearchForm" method="post" enctype="multipart/form-data">
            <div class="card rounded-0">
                <div class="card-body">
                    <label class="card-subtitle mb-3 text-muted"><small>Control Number: </small></label> <strong> <?= empty($control_num) ? 'RSH-0000001' : $control_num[0]->newnum?></strong>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group"> 
                                        <label>Project Title: </label>
                                        <input class="form-control" type="text" name="title" required>
                                    </div>  
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Cooperating Agencies (if any): </label>
                                        <input class="form-control" type="text" name="agency">
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>R & D Site EVSU Main: </label>
                                        <input class="form-control" type="text" name="rnd" required>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Classification: </label> <br>
                                        Research: <br><br>
                                        <input type="radio" name="class_research" value="Basic" required> Basic <br>
                                        <input type="radio" name="class_research" value="Applied" required> Applied <br> <br>
                                        Development: <br><br>
                                        <input type="radio" name="class_dev" required value="Pilot Testing"> Pilot Testing <br>
                                        <input type="radio" name="class_dev" required value="Tech. Promotion/ Commercialization"> Tech. Promotion/ Commercialization
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Mode of Implementation: </label> <br><br>
                                        <input type="radio" name="moi" value="Single Department/College" required> Single Department/College <br>
                                        <input type="radio" name="moi" value="Multi College" required> Multi College <br> <br>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label>Priority Agenda: </label> <br> <br> 
                                        <?php foreach($agendaList as $each):?>
                                        <input type="checkbox" name="agenda[]" value="<?= $each->id?>"> <?= $each->agenda?><br>
                                        <?php endforeach;?>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Sector Commodity: </label>
                                        <input class="form-control" type="text" name="sector" required>
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Discipline: </label>
                                        <input class="form-control" type="text" name="discipline" required>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label>Details: </label>
                                        <input class="form-control" type="text" name="details" required>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-info" type="submit"><i class="ti-save"></i> Submit</button> 
                </div>
            </div>
        </form>
    </div>
</div>
<div id="notifTerminalModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="pe-7s-date pe-lg"></i> Please submit your research listed below</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered" id="table-terminal">
                <thead>
                    <tr>
                        <th>Research No.</th>
                        <th>Title</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

    </div>
</div>
<div id="notifMonthlyModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="pe-7s-date pe-lg"></i> Please submit your research listed below, you have only 1 month before submission</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered" id="table-monthly">
                <thead>
                    <tr>
                        <th>Research No.</th>
                        <th>Title</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

    </div>
</div>
<!-- Point to external Javascript file -->
<script src="<?= base_url()?>assets/modules/js/research.js"></script>
<script>
    $(function(){
        notifTerminal();
        researchDurNotifMonthly();
    })
    function notifTerminal(){
        $.post(URL + 'research/researchDurNotifTerminal')
        .done(function(returnData){
            if(returnData != '[]'){
                var data = $.parseJSON(returnData);
                var append = '';
                $.each(data,function(key,a){
                    append += '<tr>'+
                                '<td>'+a.series_number+'</td>'+
                                '<td>'+a.title+'</td>'+
                                '<td>'+a.duration_date+'</td>'+
                            '</tr>';
                })
                $('#table-terminal tbody').html(append);
                $('#notifTerminalModal').modal('toggle');
            }
        })
    }
    function researchDurNotifMonthly(){
        $.post(URL + 'research/researchDurNotifMonthly')
        .done(function(returnData){
            if(returnData != '[]'){
                var data = $.parseJSON(returnData);
                var append = '';
                $.each(data,function(key,a){
                    append += '<tr>'+
                                '<td>'+a.series_number+'</td>'+
                                '<td>'+a.title+'</td>'+
                                '<td>'+a.duration_date+'</td>'+
                            '</tr>';
                })
                $('#table-monthly tbody').html(append);
                $('#notifMonthlyModal').modal('toggle');
            }
        })
    }
</script>