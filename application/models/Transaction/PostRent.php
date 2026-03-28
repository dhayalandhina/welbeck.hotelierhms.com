<?php

class PostRent extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function PostRent_Val()
	{
		 $this->form_validation->set_rules('auditdate', 'auditdate', 'required');		 
		 
		 if ($this->form_validation->run() == FALSE)
		 {
			 $output = $this->form_validation->return_f_error($this->input->post());
			 echo $result = json_encode($output);

		 }
		 else
		 {
			 $output = $this->form_validation->return_success($this->input->post());
			 echo $result = json_encode($output);
	

		 }
	}
	function PostRent_exec()
	{		
		$date=date("Y-m-d");
		$time= date("H:i:s");
		$sql="select DateofAudit,* from night_audit";
		$res=$this->db->query($sql);
		foreach ($res->result_array() as $row)
		{ $auditdate=$row['DateofAudit']; } 
        $creditdate=date('Y-m-d',strtotime('+1 day', strtotime($auditdate)));
	    $qry="exec Exec_NightAudit '".$auditdate."',".User_id."";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry);
		
	}
}
?>
