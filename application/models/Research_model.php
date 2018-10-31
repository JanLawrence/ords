<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research_model extends CI_Model {
	
	public function __construct(){
		$this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : array(); //get session
	}
	public function add()
	{
		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){ //validation if all condition statement are true proceed to sub statement
 			if($_FILES['file']['type'] != 'application/pdf'){
				echo 2;
				exit;
			} 
		}
		$series = $this->seriesIDResearch();

		//insert data to tbl_research
		$data = array(
            'series_number' => $series[0]->newnum,
            'title' => $_POST['title'],
            'details' => $_POST['details'],
            'content' => isset($_POST['content']) ? $_POST['content'] : '',
            'created_by' => $this->user->id,
            'date_created' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('tbl_research', $data);
        $researchId = $this->db->insert_id();//get tbl_research id
		//insertion of attachment
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
				'research_id' => $researchId,
				'name' => $fileName,
				'type' => $fileType,
				'size' => $fileSize,
				'content' => $fileNewTemp,
				'created_by' => $this->user->id,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_research_attachment', $data);

        }
		//insert data into tbl_research_status
		$data = array(
			'research_id' => $researchId,
			'created_by' => $this->user->id,
			'date_created' => date('Y-m-d H:i:s'));
		
		$this->db->insert('tbl_research_status', $data);

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
		$query = $this->db->get_where('tbl_research_attachment', array('research_id'=> $_REQUEST['id']));
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
		$this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rs.status, rs.admin_status, rs.president_status')
			->from('tbl_research r')
			->join('tbl_research_status rs', 'rs.research_id = r.id', 'inner')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left');
		$this->db->where('r.created_by', $researcher);
		$this->db->order_by('r.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
	}

	public function getResearch($id){
		//get data of joined tables filtered by research id
		$this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rs.status, rs.admin_status, rs.president_status')
			->from('tbl_research r')
			->join('tbl_research_status rs', 'rs.research_id = r.id', 'inner')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left');
		$this->db->where('r.id', $id);
		$query = $this->db->get();
        return $query->result();
	}

	public function edit()
	{
		//edit research
		$id = $_REQUEST['id'];

		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){
			if($_FILES['file']['type'] != 'application/pdf'){
				echo 2;
				exit;
			} 
		}

        $this->db->set('title', $_POST['title']);
        $this->db->set('details', $_POST['details']);
        $this->db->set('content', isset($_POST['content']) ? $_POST['content'] : '');
        $this->db->set('modified_by', $this->user->id);
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $this->db->update('tbl_research');
        
		if(isset($_FILES['file'])  && $_FILES['file']['tmp_name']!='' ){

			list($fileName , $ext) = explode('.', $_FILES['file']['name']);
			$tmpName  = $_FILES['file']['tmp_name'];            
			$fileSize = $_FILES['file']['size'];                
			$fileType = $_FILES['file']['type'];   
			$fileNewTemp = file_get_contents($tmpName);     
			if(!get_magic_quotes_gpc())
			{  
				$fileName = addslashes($fileName);
			}

			$this->db->set('name', $fileName);
			$this->db->set('type', $fileType);
			$this->db->set('size', $fileSize);
			$this->db->set('content', $fileNewTemp);
			$this->db->set('modified_by', $this->user->id);
			$this->db->set('date_modified', date('Y-m-d H:i:s'));
			$this->db->where('research_id', $id);
			$this->db->update('tbl_research_attachment');
        }

	}

}