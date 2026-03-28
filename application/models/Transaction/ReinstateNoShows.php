<?php

class ReinstateNoShows extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		 
    }
	function ReinstateNoShows_Val()
	{
		 $this->form_validation->set_rules('NewArrival', 'NewArrival', 'required');		 
		 $this->form_validation->set_rules('NewDeparture', 'NewDeparture', 'required');		 
		 
		 if ($this->form_validation->run() == FALSE)
		 {
			 $output = $this->form_validation->return_f_error($this->input->post());
			 echo $output = json_encode($output);
		 }
		 else
		 {
			 $output = $this->form_validation->return_success($this->input->post());
			 echo $output = json_encode($output);
		 }
	}
	function ReinstateNoShows_exec()
	{		
		$date=date("Y-m-d");
		$time= date("H:i:s");
		$sql2="	 delete Trans_Reserve_det1 where refresdetid='".$_REQUEST['resdetid']."'";
		$res2=$this->db->query($sql2);	
		
		$sql="Insert into trans_reservenoshow(entrydate,entrytime,resid,resno,noshowarrivaldate,noshowarrivaltime,noshowdeparturedate,noshowdeparturetime,newarrivaldate,newarrivaltime,newdeparturedate,newdeparturetime,userid) 
			  values('".$date."','".$time."','".$_REQUEST['idv']."','".$_REQUEST['ResNo']."','".date('Y-m-d',strtotime(substr($_REQUEST['Arrival'],0,10)))."','".substr($_REQUEST['Arrival'],11,6)."','".date('Y-m-d',strtotime(substr($_REQUEST['Departure'],0,10)))."','".substr($_REQUEST['Departure'],11,6)."','".date('Y-m-d',strtotime(substr($_REQUEST['NewArrival'],0,10)))."','".substr($_REQUEST['NewArrival'],11,6)."','".date('Y-m-d',strtotime(substr($_REQUEST['NewDeparture'],0,10)))."','".substr($_REQUEST['NewDeparture'],11,6)."','".User_id."')";
		
		$sql1="Update Trans_Reserve_det set Noshows='0', fromdate='".date('Y-m-d',strtotime(substr($_REQUEST['NewArrival'],0,10)))."',fromtime='".substr($_REQUEST['NewArrival'],11,6)."',todate='".date('Y-m-d',strtotime(substr($_REQUEST['NewDeparture'],0,10)))."',totime='".substr($_REQUEST['NewDeparture'],11,6)."' where resid='".$_REQUEST['idv']."'";	

		$Indate = str_replace('/', '-',date('Y-m-d',strtotime(substr($_REQUEST['NewArrival'],0,10))));
		$Indate=date('Y/m/d', strtotime($Indate));
		$todate = str_replace('/', '-',date('Y-m-d',strtotime(substr($_REQUEST['NewDeparture'],0,10))));
		$todate=date('Y/m/d', strtotime($todate)); $i=1; $sql3="";
		$From=$Indate;
		while ($Indate <= $todate) 
		{ 
		
			if($From==$Indate)
			{ $fromtime=substr($_REQUEST['NewArrival'],11,6); }
			else
			{ $fromtime="00:00"; }

			if($Indate==$todate)
			{  $totime=substr($_REQUEST['NewDeparture'],11,6); }
			else
			{ $totime="00:00"; }

			$sql3=$sql3."insert into Trans_Reserve_det1(resdate,typeid,noofrooms,refresdetid,fromtime,totime,fromdate,todate,ratetypeid) 
			values('".$date."','".$_REQUEST['typeid']."','".$_REQUEST['noofrooms']."','".$_REQUEST['resdetid']."','".$fromtime."','".$totime."','".$Indate."','".$Indate."','".$_REQUEST['typeid']."')";
			$Indate = date ("Y/m/d", strtotime("+1 day", strtotime($Indate)));
		}				
	  
		ob_start();
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $sql3;
		echo "set @Siden=@@identity; ";
	    echo $sql;
		echo $sql1;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();	
		$qry = "".$sqc."";			
		//$qry = $this->db->query("exec #".$ran);
		//$qry="exec #".$ran;
		$res=$this->db->query($qry);
		$this->db->close();
		$this->db->reconnect();	 
		$res=$this->db->query("SELECT 'Successfully Saved' AS MGS");
		$msg=$this->db->error();
		$this->Myclass->GetRec($msg,$res,$qry);
		
	}
}
?>
