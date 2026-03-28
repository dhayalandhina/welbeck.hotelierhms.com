<?php

class AdvanceResettlement extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
function AdvanceResettlement_Val()
{
    $this->form_validation->set_rules('RoomNo', 'RoomNo', 'required');
    $this->form_validation->set_rules('Advance', 'Advance', 'required');
    $this->form_validation->set_rules('paymode', 'paymode', 'required');

   $paymode = $this->input->post('paymode');
 
    if ($paymode !== 'CASH' ) 
	{
		if($paymode == 'UPI')
		{
        $this->form_validation->set_rules('bank', 'bank', 'required');
		}
		else
		{
        $this->form_validation->set_rules('cardnumber', 'cardnumber', 'required');
        $this->form_validation->set_rules('bank', 'bank', 'required');
        $this->form_validation->set_rules('validate', 'validate', 'required');
		}
     
    }

    if ($this->form_validation->run() === FALSE)
	 {
        $output = $this->form_validation->return_f_error($this->input->post());
    }
	 else
	 {
        $output = $this->form_validation->return_success($this->input->post());
    }

	

    echo json_encode($output);
}

	function AdvanceResettlement_exec()
	{ if($_REQUEST['BUT'] =='SAVE')
	   {
		$payQuery = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = '" . $_REQUEST['paymode'] . "'";
        $payResult = $this->db->query($payQuery); 
        $prow = $payResult->row_array();
        $payid = $prow['PayMode_Id'] ?? 0;
		$curr = date("Y-m-d");
       $currtime = date("H:i:s");

           	$qry="Update Trans_Receipt_mas set amount = '".$_REQUEST['Advance']."',paymodeid='". $payid."',bank='". $_REQUEST['bank']  ."',cardnumber='".$_REQUEST['cardnumber']."',validdate='".$_REQUEST['validate']."',edituserid=".User_id.",editdate='".$curr."',edittime='".$currtime."' where Receiptid='".$_REQUEST['idv']."'";	
	
	           $qry2 = "Update trans_advancereceipt_mas set amount = '".$_REQUEST['Advance']."' where Receiptid='".$_REQUEST['idv']."'";

			$res=$this->db->query($qry);
			$res2=$this->db->query($qry2);
			$msg=$this->db->error(); 
			//$this->Myclass->GetRec($msg,$res,$qry);
			$output = array();
			$output['Success']=true;
			 $output['MSG']="Advance Resettlement Successfully";		 
			print_r(json_encode($output));
	     
		}
	   else
	   {
		  $qry= " Exec_Facility '".$_REQUEST['Facility']."',".Hotel_Id.",'".$_REQUEST['Active']."','".@$_REQUEST['idv']."','".str_replace(" ","",$_REQUEST['BUT'])."'";
		$res=$this->db->query($qry);
		$msg=$this->db->error(); 
		$this->Myclass->GetRec($msg,$res,$qry); 
	   }
	}
}
?>
