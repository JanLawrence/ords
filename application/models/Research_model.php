<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research_model extends CI_Model {
	
	public function __construct(){
		$this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : array(); //get session
	}
	public function upload()
	{
		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){ //validation if all condition statement are true proceed to sub statement
 			if($_FILES['file']['type'] != 'application/pdf'){
				echo 2;
				exit;
			} 
		}

		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){//if statement is true
			//insert attachment
			list($fileName , $ext) = explode('.', $_FILES['file']['name']);
			$tmpName  = $_FILES['file']['tmp_name'];            
			$fileSize = $_FILES['file']['size'];                
			$fileType = $_FILES['file']['type'];   
			$fileNewTemp = file_get_contents($tmpName);     
			if(!get_magic_quotes_gpc())
			{  
				$fileName = addslashes($fileName);
			}
			
			$data = array(
				'research_id' => $_POST['id'],
				'name' => $fileName,
				'type' => $fileType,
				'size' => $fileSize,
				'content' => $fileNewTemp,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_attachment', $data);

			$data = array(
				"user_id" => $this->user->id,
				"username" => '',
				"transaction" => 'Uploaded Research',
				"created_by" => !empty($this->user) ? $this->user->id : 0,
				"date_created" => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs

        }
	}
	public function add()
	{
		// if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){ //validation if all condition statement are true proceed to sub statement
 		// 	if($_FILES['file']['type'] != 'application/pdf'){
		// 		echo 2;
		// 		exit;
		// 	} 
		// }
		$series = $this->seriesIDResearch();
		//insert data to tbl_research
		$data = array(
			'class_research'=> isset($_POST['class_research']) ? $_POST['class_research'] : '',
			'class_development'=> isset($_POST['class_dev']) ? $_POST['class_dev'] : '',
			'rndsite'=> $_POST['rnd'],
			'agencies'=> isset($_POST['agency']) ? $_POST['agency'] : '',
			'moi'=> $_POST['moi'],
			'sector_commodity'=> $_POST['sector'],
			'discipline'=> $_POST['discipline'],
			'series_number' => empty($series) ? 'RSH-0000001' : $series[0]->newnum,
			'title' => $_POST['title'],
			'details' => $_POST['details'],
			'abstract' => $_POST['abstract'],
			'duration' => $_POST['duration'],
			'budget' => $_POST['budget'],
			'content' => isset($_POST['content']) ? $_POST['content'] : '',
			'created_by' => $this->user->id,
			'date_created' => date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_research', $data);
		$researchId = $this->db->insert_id();//get tbl_research id
		//insertion of attachment
		// if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){//if statement is true
		// 	//insert attachment
		// 	list($fileName , $ext) = explode('.', $_FILES['file']['name']);
		// 	$tmpName  = $_FILES['file']['tmp_name'];            
		// 	$fileSize = $_FILES['file']['size'];                
		// 	$fileType = $_FILES['file']['type'];   
		// 	$fileNewTemp = file_get_contents($tmpName);     
		// 	if(!get_magic_quotes_gpc())
		// 	{  
		// 		$fileName = addslashes($fileName);
		// 	}
			
		foreach($_POST['author'] as $each){
			$data = array(
				'research_id' => $researchId,
				'author' => $each,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_author', $data);
		}
		foreach($_POST['keyword'] as $each){
			$data = array(
				'research_id' => $researchId,
				'keyword' => $each,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_keyword', $data);
		}
		foreach($_POST['agenda'] as $each){
			$data = array(
				'research_id' => $researchId,
				'agenda_id' => $each,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_agenda', $data);
		}

        // }
		//insert data into tbl_research_progress
		$data = array(
			'research_id' => $researchId,
			'levels' => 0,
			'status' => 'open',
			'created_by' => $this->user->id,
			'date_created' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('tbl_research_progress', $data);
		$progressId = $this->db->insert_id();

		$data = array(
			'research_progress_id' => $progressId,
			'notif' => 'unread',
			'status' => 'open',
			'created_by' => $this->user->id,
			'date_created' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('tbl_admin_notif', $data);

		$data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Added Research',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs

	}
	public function seriesIDResearch(){
		//get data of NEW research series number
		$this->db->select("r.series_number lastnum,
		CONCAT('RSH-',LPAD(TRIM(LEADING '0' FROM TRIM(LEADING 'RSH-' FROM r.series_number)) + 1,7,'0')) newnum")
				->from('tbl_research r');
		$this->db->where('r.series_number = (
			SELECT
				MAX(r.series_number) lastnum
			FROM tbl_research r
		)');
		$query = $this->db->get();
        return $query->result();

	}
	public function download(){
		//for attachment download
		$data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Downloaded Research',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
		$this->db->order_by('ra.id', "DESC");
		$query = $this->db->get_where('tbl_research_attachment ra', array('research_id'=> $_REQUEST['id']));
		$researchData = $query->result();
		$name = $researchData[0]->name;
		$type = $researchData[0]->type;
		$size = $researchData[0]->size;
		$content = $researchData[0]->content;
			header("Content-Disposition: attachment; filename=".$name.".pdf");
			header("Content-Type: $type");
			header("Content-Length: $size");
			ob_clean();
			flush();
			echo $content;
			
	} 
	public function getResearchByResearcher($from, $to){
		//get data of joined tables
		$researcher = $this->user->id;
		$this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rp.status, rd.duration_date, d.department,  group_concat(agenda.agenda separator ", ") agenda')
			->from('tbl_research r')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
			->join('tbl_research_progress rp', 'rp.research_id = r.id', 'left')
			->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left')
			->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
        	->join('tbl_department d', 'd.id = ui.department_id', 'left')
			->join('tbl_research_agenda research_agenda', 'research_agenda.research_id = r.id', 'left')
        	->join('tbl_priority_agenda agenda', 'research_agenda.agenda_id = agenda.id', 'left');
		$this->db->where('r.created_by', $researcher);
		if($from != ''){
			$this->db->where("DATE(r.date_created) >= '$from' && DATE(r.date_created) <= '$to'");
		}
		$this->db->order_by('r.date_created','DESC');
		$this->db->group_by('r.id');
		$query = $this->db->get();
		return $query->result();
	}
	public function getResearchByResearcherMonthly(){
		//get data of joined tables
		$researcher = $this->user->id;
		$this->db->select('r.*, CONCAT(ui.first_name," ",ui.middle_name," ",ui.last_name) u_name')
			->from('tbl_monthly_report r')
			->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left');
		$this->db->where('r.created_by', $researcher);
		$this->db->order_by('r.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
	}
	// public function getResearchByResearcherMonthly(){
	// 	//get data of joined tables
	// 	$researcher = $this->user->id;
	// 	$this->db->select('r.*, rp.status, rd.duration_date')
	// 		->from('tbl_research r')
	// 		->join('tbl_research_progress rp', 'rp.research_id = r.id', 'left')
	// 		->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left');
	// 	$this->db->where('r.created_by', $researcher);
	// 	$this->db->where("rd.duration_date != '' ");
	// 	$this->db->order_by('r.date_created','DESC');
	// 	$this->db->group_by('r.id');
	// 	$query = $this->db->get();
    //     return $query->result();
	// }
	public function getResearchByResearcherTerminal($from, $to){
		//get data of joined tables
		$researcher = $this->user->id;
		$this->db->select('r.*, rp.status, rd.duration_date')
			->from('tbl_research r')
			->join('tbl_research_progress rp', 'rp.research_id = r.id', 'left')
			->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left');
		if($this->user->user_type == 'researcher'){
			$this->db->where('r.created_by', $researcher);
		}
		$this->db->where("rd.duration_date != ''");
		if($from != ''){
			$this->db->where("DATE(r.date_created) >= '$from' && DATE(r.date_created) <= '$to'");
		}
		$this->db->order_by('r.date_created','DESC');
		$this->db->group_by('r.id');
		$query = $this->db->get();
		return $query->result();
	}
	public function getResearchByResearcherMidterm(){
		//get data of joined tables
		$researcher = $this->user->id;
		$this->db->select('r.*, rp.status, rd.duration_date')
			->from('tbl_research r')
			->join('tbl_research_progress rp', 'rp.research_id = r.id', 'left')
			->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left');
		$this->db->where('r.created_by', $researcher);
		$this->db->where("rd.duration_date != '' ");
		$this->db->order_by('r.date_created','DESC');
		$this->db->group_by('r.id');
		$query = $this->db->get();
        return $query->result();
	}

	public function getResearch($id){
		//get data of joined tables filtered by research id
		$this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size,
							,rp.status')
			->from('tbl_research r')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
			->join('tbl_research_progress rp', 'rp.research_id = r.id', 'left');
		$this->db->where('r.id', $id);
		$this->db->group_by('r.id');
		$query = $this->db->get();
        return $query->result();
	}
	public function addMonthly(){
		echo $this->user->id;
		foreach($_POST['objectives'] as $key => $each){
			$data = array(
				'objectives' => $each,
				'activities' => $_POST['activities'][$key],
				'responsible' => $_POST['responsible'][$key],
				'involved' => $_POST['involved'][$key],
				'schedule' => $_POST['schedule'][$key],
				'resources' => $_POST['resources'][$key],
				'output' => $_POST['output'][$key],
				'created_by' => $this->user->id
			);
			$this->db->insert('tbl_monthly_report',$data); //insert data to tbl_monthly_report
		}
		$data2 = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Added Monthly Performance Report',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data2); //insert data to tbl_user_logs
	}

	public function edit()
	{
		$researchId = $_POST['id'];
		$this->db->set('class_research', isset($_POST['class_research']) ? $_POST['class_research'] : '');
		$this->db->set('class_development', isset($_POST['class_dev']) ? $_POST['class_dev'] : '');
		$this->db->set('rndsite', $_POST['rnd']);
		$this->db->set('agencies', isset($_POST['agency']) ? $_POST['agency'] : '');
		$this->db->set('moi', $_POST['moi']);
		$this->db->set('sector_commodity', $_POST['sector']);
		$this->db->set('discipline', $_POST['discipline']);
		$this->db->set('series_number' , empty($series) ? 'RSH-0000001' : $series[0]->newnum);
		$this->db->set('title' , $_POST['title']);
		$this->db->set('details' , $_POST['details']);
		$this->db->set('content' , isset($_POST['content']) ? $_POST['content'] : '');
		$this->db->set('modified_by' , $this->user->id);
		$this->db->set('date_modified' , date('Y-m-d H:i:s'));
		$this->db->where('id' , $researchId);
		$this->db->update('tbl_research');

		$this->db->delete('tbl_research_agenda', array('research_id' => $researchId));

		foreach($_POST['agenda'] as $each){
			$data = array(
				'research_id' => $researchId,
				'agenda_id' => $each,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_agenda', $data);
		}
		$this->db->delete('tbl_research_keyword', array('research_id' => $researchId));

		foreach($_POST['keyword'] as $each){
			$data = array(
				'research_id' => $researchId,
				'keyword' => $each,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_keyword', $data);
		}
		$this->db->delete('tbl_research_author', array('research_id' => $researchId));

		foreach($_POST['author'] as $each){
			$data = array(
				'research_id' => $researchId,
				'author' => $each,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_author', $data);
		}
		$progress = $this->db->get_where('tbl_research_progress', array('research_id' => $researchId));
		$progress = $progress->result();

		if($progress[0]->status == 'admin_remarks'){
			$data = array(
				'research_progress_id' => $progress[0]->id,
				'notif' => 'unread',
				'status' => 'remarks',
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);	
			$this->db->insert('tbl_admin_notif', $data);
		} else if($progress[0]->status == 'twg_remarks'){
			$data = array(
				'research_progress_id' => $progress[0]->id,
				'notif' => 'unread',
				'status' => 'remarks',
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);	
			$this->db->insert('tbl_twg_notif', $data);
		} else if($progress[0]->status == 'rde_remarks'){
			$data = array(
				'research_progress_id' => $progress[0]->id,
				'notif' => 'unread',
				'status' => 'remarks',
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);	
			$this->db->insert('tbl_rde_notif', $data);
		} else if($progress[0]->status == 'pres_remarks'){
			$data = array(
				'research_progress_id' => $progress[0]->id,
				'notif' => 'unread',
				'status' => 'remarks',
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);	
			$this->db->insert('tbl_pres_notif', $data);
		}
		$data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Updated Research',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
	}

}