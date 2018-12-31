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
			'class_research'=> $_POST['class_research'],
			'class_development'=> $_POST['class_dev'],
			'rndsite'=> $_POST['rnd'],
			'agencies'=> isset($_POST['agency']) ? $_POST['agency'] : '',
			'moi'=> $_POST['moi'],
			'sector_commodity'=> $_POST['sector'],
			'discipline'=> $_POST['discipline'],
			'series_number' => empty($series) ? 'RSH-0000001' : $series[0]->newnum,
			'title' => $_POST['title'],
			'details' => $_POST['details'],
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
	public function getResearchByResearcher(){
		//get data of joined tables
		$researcher = $this->user->id;
		$this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rp.status, rd.duration_date')
			->from('tbl_research r')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
			->join('tbl_research_progress rp', 'rp.research_id = r.id', 'left')
			->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left');
		$this->db->where('r.created_by', $researcher);
		$this->db->order_by('r.date_created','DESC');
		$this->db->group_by('r.id');
		$query = $this->db->get();
        return $query->result();
	}
	public function getResearchByResearcherMonthly(){
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
	public function getResearchByResearcherTerminal(){
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

	public function edit()
	{
		$researchId = $_POST['id'];
		$this->db->set('class_research', $_POST['class_research']);
		$this->db->set('class_development', $_POST['class_dev']);
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
	}

}