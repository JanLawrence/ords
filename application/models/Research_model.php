<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research_model extends CI_Model {
	
	public function __construct(){
		$this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : array();
	}
	public function add()
	{
		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){
			if($_FILES['file']['type'] != 'application/pdf'){
				echo 2;
				exit;
			} 
		}
		// $code = 'RSH-';
		// $query = $this->db->get('tbl_research');
		// $researchData = $query->result();
		// if(empty($researchData)){
		// 	$lastnum = $code.str_pad(1,7,'0',STR_PAD_LEFT);
		// } else {

		// }
		// $lastnum = $code.str_pad($num,7,'0',STR_PAD_LEFT);
		$data = array(
            'series_number' => 'RSH-0000001',
            'title' => $_POST['title'],
            'details' => $_POST['details'],
            'content' => $_POST['content'],
            'created_by' => $this->user->id,
            'date_created' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('tbl_research', $data);
        $researchId = $this->db->insert_id();
		
		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){

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

		$data = array(
			'research_id' => $researchId,
			'created_by' => $this->user->id,
			'date_created' => date('Y-m-d H:i:s'));
		
		$this->db->insert('tbl_research_status', $data);

	}
	public function download(){
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
		$id = $_REQUEST['id'];

		if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=''){
			if($_FILES['file']['type'] != 'application/pdf'){
				echo 2;
				exit;
			} 
		}

        $this->db->set('title', $_POST['title']);
        $this->db->set('details', $_POST['details']);
        $this->db->set('content', $_POST['content']);
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