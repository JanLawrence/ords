<!-- Landing Page of Researcher User -->
<?php 
    $session = $this->session->userdata['user'];
    $query = $this->db->get_where('tbl_user_info', array('user_id' => $session->id));
    $userinfo = $query->result();
?>
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
                                        Research: <input type="radio" name="classif-radio" value="research"><br><br>
                                        <div class="research-radio d-none">
                                            <input type="radio" name="class_research" value="Basic"> Basic <br>
                                            <input type="radio" name="class_research" value="Applied"> Applied <br> <br>
                                        </div>
                                        Development: <input type="radio" name="classif-radio" value="dev"><br><br>
                                        <div class="development-radio d-none">
                                            <input type="radio" name="class_dev" value="Pilot Testing"> Pilot Testing <br>
                                            <input type="radio" name="class_dev" value="Tech. Promotion/ Commercialization"> Tech. Promotion/ Commercialization
                                        </div>
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
                                <td>
                                    <div class="form-group">
                                        <label>Budget: </label>
                                        <input class="form-control" type="number" name="budget" required>
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Duration: </label>
                                        <input class="form-control" type="date" name="duration" required>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label>Abstract: </label>
                                        <input class="form-control" type="text" name="abstract" required>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td class="appendAuthor">
                                    <div class="form-group">
                                        <label>Author: <a class="addAuthor" style="cursor: pointer; color: #41a8fc">Add</a></label>
                                        <input class="form-control" type="text" name="author[]" readonly value="<?=  $userinfo[0]->first_name.' '.$userinfo[0]->middle_name.' '.$userinfo[0]->last_name  ?>" required>
                                    </div>
                                </td>
                                <td class="appendKeyword">
                                    <div class="form-group">
                                        <label>Keyword: <a class="addKeyword" style="cursor: pointer; color: #41a8fc">Add</a></label>
                                        <input class="form-control" type="text" name="keyword[]" required>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label>Description: </label>
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
        $('input[name="classif-radio"]').change(function(){
            var val = $(this).val();
            if(val == 'research'){
                $('.research-radio').removeClass('d-none');
                $('.development-radio').addClass('d-none'); 
                $('input[name="class_dev"]').prop('checked', false); 
            } else if(val == 'dev') {
                $('.research-radio').addClass('d-none');
                $('.development-radio').removeClass('d-none');
                $('input[name="class_research"]').prop('checked', false); 
            }
        })
        $('.addAuthor').click(function(){
            var append = '<div class="input-group mb-3">'+
                            '<input type="text" class="form-control" name="author[]">'+
                            '<div class="input-group-append">'+
                                '<button class="btn btn-danger btnremoveauthor" type="button">Delete</button>'+
                            '</div>'+
                        '</div>'
            $('.appendAuthor').append(append);

            $('.btnremoveauthor').click(function(){
                $(this).closest('.input-group').remove();
            })
        })
        $('.addKeyword').click(function(){
            var append = '<div class="input-group mb-3">'+
                            '<input type="text" class="form-control" name="keyword[]">'+
                            '<div class="input-group-append">'+
                                '<button class="btn btn-danger btnremovekeyword" type="button">Delete</button>'+
                            '</div>'+
                        '</div>'
            $('.appendKeyword').append(append);
            $('.btnremovekeyword').click(function(){
                $(this).closest('.input-group').remove();
            })
        })


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