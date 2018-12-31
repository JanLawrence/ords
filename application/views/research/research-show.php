
<div class="row">
    <div class="col-md-12">
        <!-- Form for creating new research-->
        <form id="editResearchForm" method="post" enctype="multipart/form-data">
            <div class="card rounded-0">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group"> 
                                        <label>Project Title: </label>
                                        <input class="form-control" type="hidden" name="id" required readonly value="<?= $_REQUEST['id']?>" >
                                        <input class="form-control" type="text" name="title" required readonly value="<?= $research[0]->title?>">
                                    </div>  
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Cooperating Agencies (if any): </label>
                                        <input class="form-control" type="text" name="agency" readonly value="<?= isset($research[0]->agencies) ? $research[0]->agencies : ''?>">
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>R & D Site EVSU Main: </label>
                                        <input class="form-control" type="text" name="rnd" required readonly value="<?= $research[0]->rndsite?>">
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Classification: </label> <br>
                                        Research: <br><br>
                                        <input type="radio" name="class_research" value="Basic" required readonly <?= $research[0]->class_research == 'Basic' ? 'checked' : ''?>> Basic <br>
                                        <input type="radio" name="class_research" value="Applied" required readonly  <?= $research[0]->class_research == 'Applied' ? 'checked' : ''?>> Applied <br> <br>
                                        Development: <br><br>
                                        <input type="radio" name="class_dev" required readonly value="Pilot Testing"  <?= $research[0]->class_development == 'Pilot Testing' ? 'checked' : ''?>> Pilot Testing <br>
                                        <input type="radio" name="class_dev" required readonly value="Tech. Promotion/ Commercialization"  <?= $research[0]->class_development == 'Tech. Promotion/ Commercialization' ? 'checked' : ''?>> Tech. Promotion/ Commercialization
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Mode of Implementation: </label> <br><br>
                                        <input type="radio" name="moi" value="Single Department/College" required readonly <?= $research[0]->moi == 'Single Department/College' ? 'checked' : ''?>> Single Department/College <br>
                                        <input type="radio" name="moi" value="Multi College" required readonly <?= $research[0]->moi == 'Multi College' ? 'checked' : ''?>> Multi College <br> <br>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <?php   
                                            // check if research agenda
                                            $agenda = $this->db->get_where('tbl_research_agenda', array('research_id' => $_REQUEST['id'])); //get notes by research id
                                            $agenda = $agenda->result();

                                            $arr = array();
                                            if(!empty($agenda)){
                                                foreach($agenda as $each){
                                                    $arr[] = $each->agenda_id;
                                                }
                                            }
                                        ?>
                                        <label>Priority Agenda: </label> <br> <br> 
                                        <?php foreach($agendaList as $each):?>
                                        <input type="checkbox" name="agenda[]" value="<?= $each->id?>" <?= in_array( $each->id , $arr) ? 'checked' : '' ?>> <?= $each->agenda?><br>
                                        <?php endforeach;?>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>Sector Commodity: </label>
                                        <input class="form-control" type="text" name="sector" required readonly value="<?= $research[0]->sector_commodity?>">
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>Discipline: </label>
                                        <input class="form-control" type="text" name="discipline" required readonly value="<?= $research[0]->discipline?>">
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label>Details: </label>
                                        <input class="form-control" type="text" name="details" required readonly value="<?= $research[0]->details?>">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Point to external Javascript file -->
<script src="<?= base_url()?>assets/modules/js/research.js"></script>