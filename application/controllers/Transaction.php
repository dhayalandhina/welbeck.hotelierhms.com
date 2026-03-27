<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller
{

	function __construct()
	{
	
	
		parent::__construct();

		$this->load->library('session');

		if (empty($this->session->userdata('POS'))) {
			echo '
			<!DOCTYPE html>
			<html>
			<head>
				<!-- Load SweetAlert v1 -->
				<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			</head>
			<body>
				<script>
					swal("Session Expired", "Your session has ended. You will be logged out.", "warning")
					.then(() => {
						window.location.href = "' . scs_index . 'login/logout";
					});
				</script>
			</body>
			</html>';
			exit;
		}
			
		
		define('ActMenu', 'Transaction');
		$ci = &get_instance();
		$ci->router->class;
		$ci->router->method;

     
      

	}


	public function RoomChart($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'RoomChart', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RoomStatusOnline($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'RoomChart', 'F_Ctrl' => 'RoomStatusOnline', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function RoomStatusOnline_new($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'RoomChart', 'F_Ctrl' => 'RoomStatusOnline_new', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}



	public function Reservation($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Reservation', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Reservationadvance($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Reservationadvance', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RegistrationCard()
	{
		$data = array('F_Class' => 'Print', 'F_Ctrl' => 'RegistrationCard');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Walkout()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Walkout');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReserveCheckin()
	{
		date_default_timezone_set('Asia/Kolkata');

		  $sql="select remas.totamt,mr.RoomType, * from Trans_Reserve_Mas rm 
		inner join Trans_Reserve_Det rd on rm.Resid=rd.resid
		inner join Mas_Customer mc on mc.Customer_Id= rm.cusid
		inner join Mas_RoomType mr on mr.RoomType_Id=rd.typeid
		inner join Mas_PlanType mp on mp.PlanType_Id=rd.ratetypeid
		inner join Mas_FoodPlan mf on mf.FoodPlan_Id=rd.planid
		inner join mas_city mci on mci.Cityid = mc.Cityid
		left join trans_reserveadd_mas remas on remas.resno=rm.ResNo
		where  ((ISNULL(rd.noofrooms, 0) - ISNULL(rd.checkinrooms, 0)) + ISNULL(rd.cancelrooms, 0)) > 0 and  
		rm.Resid='".$_REQUEST['resno']."' and rd.fromdate='".date('Y-m-d')."' 
		and isnull(rd.stat, '') not in ('C','Y')";  
  
		$exqry = $this->db->query($sql);
		$count = 1; 
		foreach ($exqry->result_array() as $ress) {
			$noofrooms = $ress['noofrooms'];  
			$Resid = $ress['Resid'];  
			
			
			$del = "DELETE FROM temp_trans_reservecheckin_log WHERE Resid = '".$Resid."' AND typeid = '".$ress['typeid']."'";
			$delqry = $this->db->query($del); 
			
			
			for ($j = 1; $j <= $noofrooms; $j++) { 
				$ins = "INSERT INTO temp_trans_reservecheckin_log (Resid, typeid, noofrooms, resrow) 
						VALUES ('" . $Resid . "', '" . $ress['typeid'] . "', '".$noofrooms."', '" . $count . "')";
				
				$this->db->query($ins); 
				
				$count++;
			}
		}
		

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Reservation_checkin_edit');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function delete_temprescheckin(){
		$count = $_REQUEST['count'];
		$del = "DELETE FROM temp_trans_reservecheckin_log WHERE resrow = '".$count."'";
		$delqry = $this->db->query($del); 
	}


	public function ReservationAmendment($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationAmendment', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationCancel($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationCancel', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationCancels($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationCancels', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationCheckin($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationCheckin', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReinstateNoShows($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReinstateNoShows', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReinstateNoShows_Update($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReinstateNoShows_Update', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->ResNoShow($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function allowanceposting()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'allowanceposting');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationCancels_Update($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReinstateNoShows_Update', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_Reservation($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReinstateNoShows_Val()
	{
		$this->load->model('Transaction/ReinstateNoShows');
		$this->ReinstateNoShows->ReinstateNoShows_Val();
	}
	public function GetChart($ID)
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'GetChart', 'ID' => $ID);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ResAmendment()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ResAmendment');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Checkin()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Checkin');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function visiting()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'visiting');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function cleaning()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'cleaning');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function maintainance()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'maintainance');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
		public function Checkinnew()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Checkinnew');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ResCheckin()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ResCheckin');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Checkout()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Checkout');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function rescancel()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ResCancel');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function advanceposting()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'advanceposting');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function CheckoutResettlement()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'CheckoutResettlement');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function CheckoutResettlement_Edit($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'CheckoutResettlement_Edit', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_Checkoutbill($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function CheckoutResettlement_Val()
	{

		date_default_timezone_set('Asia/Kolkata');

	 $check1 = "Select  cast(toroomid as bigint) as toroomid,totalamount,roomgrcid,checkoutdate from trans_checkout_mas where Checkoutid='" . $_REQUEST['idv'] . "'";
		$exech1 = $this->db->query($check1);
		foreach ($exech1->result_array() as $ch1)
		 {
			$tamounts = $ch1['totalamount'];
			$roomgrcid = $ch1['roomgrcid'];
			$checkoutdate = $ch1['checkoutdate'];
			if ($ch1['toroomid'] != 0)
			 {

			   $stqry = "SELECT * from room_status where roomid = '".$ch1['toroomid']."' and isnull(status,'') ='Y' and isnull(billsettle,0) = 0";
			    $exst = $this->db->query($stqry)->row_array();
				$strqrycount = count($exst);
                    if($strqrycount != 0)
					 {
								$sq2 = "SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TCR'";
					$exsq1 = $this->db->query($sq2);
					foreach ($exsq1->result_array() as $row1) {
						$Creditheadid1 = $row1['Revenue_Id'];
					}
					$sq3 = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TDR'";
					$exsq1 = $this->db->query($sq3);
					foreach ($exsq1->result_array() as $row1) {
						$Creditheadid2 = $row1['Revenue_Id'];
					}
					if ($tamounts > 0) {
						$Creditheadid = $Creditheadid1;
					} else {
						$Creditheadid = $Creditheadid2;
					}

				// $delete1 = "delete  from trans_credit_entry where Roomid='" . $ch1['toroomid'] . "'";
				$delete1 = "delete  from trans_credit_entry where roomid='".$ch1['toroomid']."' and  roomgrcid ='".$roomgrcid."' and creditheadid = '".$Creditheadid."' and creditdate = '".date('Y-m-d', strtotime($checkoutdate))."'";
				// $res = $this->db->query($delete1);

					}

			
			}
		}

	

		
		for ($i = 0; $i < $_REQUEST['counts']; $i++) 
		{
        
			if (@$_REQUEST['Amt'][$i])
			 {

	      $paymode = $_REQUEST['paymode'][$i] ?? '';

$sql = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = '".$paymode."'";
$paymode_row = $this->db->query($sql)->row_array();

$pay = $paymode_row['PayMode_Id'] ?? null;

				

$toroompay = '';
				if ($paymode == "COMPANY") 
				{

					$ins = "insert into Trans_Pay_Det (Checkoutid,Paymodeid,Bankid,Amount,ChqNo,Validdate,Paidamount,receiptid,userid)
						values('" . $_REQUEST['idv'] . "','" . $pay . "','" . @$_REQUEST['bank'][$i] . "','" . $_REQUEST['Amt'][$i] . "',
						'" . @$_REQUEST['cardno'][$i] . "','" . date('Y-m-d', strtotime(@$_REQUEST['validate'][$i])) . "','0',
						'" . $_REQUEST['receiptid'] . "','" . User_id . "')";
					// $res = $this->db->query($ins);
				} else if ($paymode == "TOROOM")
				 {
					$toroompay = "TOROOM";
					$check = "select * from trans_checkout_mas cm
							inner join trans_roomdet_det det on
							det.roomgrcid = cm.roomgrcid
							inner join mas_room ms on ms.Room_id = cm.roomid
							where Checkoutid='" . $_REQUEST['idv'] . "'  ";
					 $exch = $this->db->query($check);
					  foreach ($exch->result_array() as $ch)
					 {
						$tamount = $ch['totalamount'];
						$tcheckoutdate = $ch['Checkoutdate'];
						$tratetype = $ch['ratetypeid'];
						$Billno = $ch['Checkoutno'];
						$ttariff = $ch['tarrifftypeid'];
						$ttax = $ch['taxid'];
						$Roomno = $ch['RoomNo'];
					}


					$sq = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TCR'";
					$exsq = $this->db->query($sq);
					foreach ($exsq->result_array() as $row1) {
						$Creditheadid1 = $row1['Revenue_Id'];
					}
					$sq1 = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TDR'";
					$exsq = $this->db->query($sq1);
					foreach ($exsq->result_array() as $row1) {
						$Creditheadid2 = $row1['Revenue_Id'];
					}
					if ($tamount >= 0) {
						$Creditheadid = $Creditheadid1;
					} else {
						$Creditheadid = $Creditheadid2;
					}
					$sqlto = "select mr.RoomNo, rs.Roomid, * from room_status rs
							inner join mas_room mr on rs.Roomid = mr.Room_Id
							where rs.roomid = '" . @$_REQUEST['bank'][$i] . "' and isnull(rs.status,'') = 'Y' and isnull(rs.billsettle,0)=0";
					$exec = $this->db->query($sqlto);
					foreach ($exec->result_array() as $row)
					 {
						$troomid = $row['Roomid'];
						$tgrcid = $row['grcid'];
						$troomgrcid = $row['roomgrcid'];

						$sqlch = "update trans_checkout_mas set toroomid= '" . $troomid . "' where Checkoutno = '" . $Billno . "'";
						// $exech = $this->db->query($sqlch);
						$sqlins = "insert into Trans_credit_entry (CreditNo,Roomid,Grcid,CreditDate,
							Creditheadid,Amount,roomgrcid,otherAmount,crtime,tarrifftype,tarriffsetupid,
							Actroomrent,Nettarrifamount,Ratetypeid,actrackrate,chNo)
							values(dbo.Credit_Entry_No(),'" . $troomid . "','" . $tgrcid . "','" . $tcheckoutdate . "','" . $Creditheadid . "','" . $tamount . "',
							'" . $troomgrcid . "','" . $tamount . "',convert(varchar(25),getdate(),108),'" . $ttariff . "','" . $ttax . "',
							'" . $tamount . "','0.00','" . $tratetype . "','" . $tamount . "', '" . 'Chk.No : ' . $Billno . '- RoomNo: ' . $Roomno . "' ) ";
						// $execc = $this->db->query($sqlins);
					}
				}
				 $ins = "insert into Trans_Pay_Det (Checkoutid,Paymodeid,Bankid,Amount,ChqNo,Validdate,Paidamount,receiptid,userid)
						 	values('" . $_REQUEST['idv'] . "','" . $pay . "','" . @$_REQUEST['bank'][$i] . "','" . $_REQUEST['Amt'][$i] . "',
						    '" . @$_REQUEST['cardno'][$i] . "','" . date('Y-m-d', strtotime(@$_REQUEST['validate'][$i])) . "','" . $_REQUEST['Amt'][$i] . "',
						    '" . $_REQUEST['receiptid'] . "','" . User_id . "')";
				// $res = $this->db->query($ins);
			} else {
			 	 $ins = "insert into Trans_Pay_Det (Checkoutid,Paymodeid,Bankid,Amount,ChqNo,Validdate,Paidamount,receiptid,userid)
							values('" . $_REQUEST['idv'] . "','" .$pay. "','" . @$_REQUEST['bank'][$i] . "','" . $_REQUEST['Amt'][$i] . "',
						'" . @$_REQUEST['cardno'][$i] . "','" . date('Y-m-d', strtotime(@$_REQUEST['validate'][$i])) . "','" . $_REQUEST['Amt'][$i] . "',
						'" . $_REQUEST['receiptid'] . "','" . User_id . "')";
				// $res = $this->db->query($ins);
			}
		}
		
	$delete = "delete Trans_Pay_Det where Checkoutid='" . $_REQUEST['idv'] . "'";
	
              if($toroompay == 'TOROOM')
			  {
			
	// echo  $res = $this->db->query($delete,$delete1,$ins,$sqlch,$sqlins);
	                $res1 = $this->db->query($delete);
					$res2 = $this->db->query($delete1);
					$res3 = $this->db->query($ins);
					$res4 = $this->db->query($sqlch);
					$res5 = $this->db->query($sqlins);
	
			  } else
			  {

					// echo  $res = $this->db->query($delete,$ins);
					$res2 = $this->db->query($delete);
					$res1 = $this->db->query($ins);
				
	
			  }

			  echo "success";
			  
	// 		 if (!$res1 || !$res2 || !$res3 || !$res4 || !$res5) {
    //     echo "success";
    // } else{
	// 	echo "failed";
	// }

	// if (!$res1 || !$res2) {
    //     echo "success";
    // } else{
	// 	echo "failed";
	// }
			  

	
	}

	public function AdvanceResettlement()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'AdvanceResettlement');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function AdvanceResettlement_Edit($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'AdvanceResettlement_Edit', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_Advancereceipt($ID);
			$data = array_merge($data, $REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function AdvanceResettlement_Val()
	{
		$this->load->model('Transaction/AdvanceResettlement');
		$this->AdvanceResettlement->AdvanceResettlement_Val();
	}
	public function resadvanceposting()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'resadvanceposting');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Collection($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Collection', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Collection_Edit($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Collection_Edit', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			// $REC=$this->Myclass->Get_Checkoutbill($ID);
			// $data=array_merge($data,$REC[0]);
		}
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function AdvanceReceipt()
	{
		$data = array('F_Class' => 'Print', 'F_Ctrl' => 'AdvanceReceipt');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function BillEntryReceipt()
	{
		$data = array('F_Class' => 'Print', 'F_Ctrl' => 'BillEntryReceipt');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationAdvanceReceipt()
	{
		$data = array('F_Class' => 'Print', 'F_Ctrl' => 'ReservationAdvanceReceipt');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
public function CheckoutReceipt()
{
$checkoutId = $this->input->get('checkoutId');

    $data = array(
        'F_Class'     => 'Print',
        'F_Ctrl'      => 'CheckoutReceipt',
        'checkoutId'  => $checkoutId
    );

    $this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
}

	public function billposting()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'billposting');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function cleardirty()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'cleardirty');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function amendment()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'amendment');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function roomtransfer()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'roomtransfer');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function settlement()
	{
		  $Billid = $this->input->post('Billid');
		$data = array(
			'F_Class' => 'Transaction', 
			'F_Ctrl' => 'settlement',
			'Billid' => $Billid
		);


		
		if (!$data['Billid']) {
			show_error('Invalid Bill ID');
			return;
		}
		
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function GetResNo()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'GetResNo');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function PostRent($ID = -1, $BUT = 'POST')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'PostRent', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Floor($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Changegueststay($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Changegueststay', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Floor($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Changegueststay_Val()
	{
		$this->load->model('Transaction/Changegueststay');
		$this->Changegueststay->Changegueststay_Val();
	}
	public function RoomStatusChange($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'RoomStatusChange', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Floor($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RoomBlockRelease($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'RoomBlockRelease', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function RoomBlockRelease_Val()
	{
		$this->load->model('Transaction/RoomBlockRelease');
		$this->RoomBlockRelease->RoomBlockRelease_Val();
	}
	public function RoomStatusChange_Val()
	{
		$this->load->model('Transaction/RoomStatusChange');
		$this->RoomStatusChange->RoomStatusChange_Val();
	}
	public function Reservation_Val()
	{
		$this->load->model('Transaction/Reservation');
		$this->Reservation->Reservation_Val();
	}

	
	public function DateChange($ID = -1, $BUT = 'Done')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'DateChange', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Floor($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function NightAuditReversal($ID = -1, $BUT = 'Done')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'NightAuditReversal', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Floor($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function DateChange_Val()
	{
		$this->load->model('Transaction/DateChange');
		$this->DateChange->DateChange_Val();
	}
	public function NightAuditReversal_Val()
	{
		$this->load->model('Transaction/NightAuditReversal');
		$this->NightAuditReversal->NightAuditReversal_Val();
	}
	//###########################################
	public function Advance($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Advance', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_Advancereceipt($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function Advance_Val()
	{
	
		$this->load->model('Transaction/Advance');
		$this->Advance->Advance_Val();
	}
	public function Advance_View()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Advance');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	///////
	public function PostBill($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'PostBill', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_PostBills($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function PostBill_Val()
	{
		$this->load->model('Transaction/PostBill');
		$this->PostBill->PostBill_Val();
	}
	public function PostBill_View()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'PostBill');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	//////////
	public function ReservationAdvanceRefund($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationAdvanceRefund', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_ReservationAdvanceRefund($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationAdvanceRefund_Val()
	{
		$this->load->model('Transaction/ReservationAdvanceRefund');
		$this->ReservationAdvanceRefund->ReservationAdvanceRefund_Val();
	}
	public function ReservationAdvanceRefund_View()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationAdvanceRefund');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	///////
	public function ReservationAdvances($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationAdvances', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Get_ReservationAdvances($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}
	public function ReservationAdvances_Val()
	{
		$this->load->model('Transaction/ReservationAdvances');
		$this->ReservationAdvances->ReservationAdvances_Val();
	}
	public function ReservationAdvances_View()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationAdvances');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}
	///////////////////////
	public function Pop_city()
	{
		$query = $this->db->query("exec Get_City"); ?>
		<table style="width:100%" class="sertable">
			<thead>
				<tr style="background-color:#949191 !important">
					<td>#S.No</td>
					<td>City</td>
				</tr>
			</thead>
			<?php $i = 1;
			foreach ($query->result_array() as $row) {              ?>
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td onclick="Get_checkinCity(this.id)" id="<?php echo $row['Cityid']; ?>" name="<?php echo $row['Cityid']; ?>"><?php echo $row['City']; ?><input id="city<?php echo $row['Cityid']; ?>" value="<?php echo $row['City']; ?>" type="hidden" /></td>

					</tr>
				</tbody>
			<?php $i++;
			}  ?>
		</table>
	<?php

	}
	public function extendoverstay()
	{

		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from night_audit";
		$res  = $this->db->query($sql);
		foreach ($res->result_array() as $rower) {
		 	$audtidate = date('Y-m-d', strtotime($rower['DateofAudit']));
		}

		 $nextdate = date('Y-m-d', strtotime("+1 days", strtotime($audtidate)));

		 $sql = " select det.roomgrcid,* from Room_Status Rs
		 Inner join Trans_Roomdet_det det on det.roomgrcid=Rs.roomgrcid
		 where Rs.Status='Y' and isnull(billsettle,0)=0";
		$res = $this->db->query($sql);

		foreach ($res->result_array() as $row) {

			$sql1 = " select max(Rentdate) as Rentdate , singlerent,Doublerent ,Triplerent,Quartertriplerent,roomgrcid, 
			actdoublerent,actsinglerent,acttriplerent,actquartertriplerent,extraadultcharges,extrachildcharges,
			noofpersons from Trans_roomdet_det_rent where grcid='" . $row['grcid'] . "' group by roomid,singlerent,Doublerent,
			Triplerent,Quartertriplerent,roomgrcid,grcid,checkinrenttype,actsinglerent,
			actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,extrachildcharges,noofpersons,userid";
			$res1 = $this->db->query($sql1);
			foreach ($res1->result_array() as $row1) {
				$startDate = date('Y-m-d', strtotime($row1['Rentdate']));
				$Indate = date('Y-m-d', strtotime($row1['Rentdate']));
				$todate = $nextdate;
				while ($Indate <= $todate) {
					$sql2 = "select Count(roomrentid) as coun from Trans_roomdet_det_rent 
					where Rentdate='" . $Indate . "' and grcid='" . $row['grcid'] . "'";
					$res2 = $this->db->query($sql2);
					foreach ($res2->result_array() as $row2) {
						$no = $row2['coun'];
					}
					if ($no == 0) {

						$sql3 = "Insert into Trans_roomdet_det_rent (Rentdate,roomid,singlerent,
						Doublerent,Triplerent,Quartertriplerent,roomgrcid,grcid,checkinrenttype,
						actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,
						extraadultcharges,extrachildcharges,noofpersons,userid)
						values('" . $Indate . "','" . $row['Roomid'] . "','" . $row1['singlerent'] . "',
						'" . $row1['Doublerent'] . "','" . $row1['Triplerent'] . "','" . $row1['Quartertriplerent'] . "',
						'" . $row1['roomgrcid'] . "','" . $row['grcid'] . "','I','" . $row1['actsinglerent'] . "',
						'" . $row1['actdoublerent'] . "','" . $row1['acttriplerent'] . "','" . $row1['actquartertriplerent'] . "',
						'" . $row1['extraadultcharges'] . "','" . $row1['extrachildcharges'] . "','" . $row1['noofpersons'] . "',
						'" . User_id . "')";
						$this->db->query($sql3);
					}
					$Indate = date('Y-m-d', strtotime('+1 day', strtotime($Indate)));
				}
			}

			

			
        $up = "Update Trans_Roomdet_det set depdate='" . $nextdate . "' where roomgrcid='" . $row['roomgrcid'] . "'";

		
			$resup = $this->db->query($up);

			while ($startDate <= $nextdate) {
				$sql4 = "select count(Avaid) as avail from Trans_RoomAvailability_Chart where Avdate='" . $startDate . "' and Roomtypeid='" . $row['typeid'] . "'";
				$res4 = $this->db->query($sql4);
				foreach ($res4->result_array() as $row4) {
					$co = $row4['avail'];
				}
				$sql5 = "exec Room_availability '" . $startDate . "', '" . $row['typeid'] . "'";
				$res5 = $this->db->query($sql5);
				foreach ($res5->result_array() as $row5) {
					$totalrooms = $row5['Totalrooms'];
					$checkins = $row5['Checkins'];
					$Booking = $row5['Booking'];
					$Availablerooms = $row5['Availablerooms'];
					$Expcheckout = $row5['Expcheckout'];
				}
				if ($co == 0) {
					$upd = "Insert into Trans_RoomAvailability_Chart(Avdate,Roomtypeid,Checkins,Totalrooms,Booking,Expcheckout,Availablerooms)
					values('" . $startDate . "','" . $row['typeid'] . "','" . $checkins . "','" . $totalrooms . "','" . $Booking . "','" . $Expcheckout . "', '" . $Availablerooms . "')";
				} else {
					$upd = "Update Trans_RoomAvailability_Chart set Avdate='" . $startDate . "', Roomtypeid='" . $row['typeid'] . "', Checkins='" . $checkins . "',
					Booking='" . $Booking . "', Expcheckout='" . $Expcheckout . "', Availablerooms='" . $Availablerooms . "' where Avdate='" . $startDate . "' and Roomtypeid='" . $row['typeid'] . "'";
				}

				$this->db->query($upd);
				$startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
			}
		}
		echo "Sucess";
	}

	public function nextSplitBillNumber($cur_Splitbilno)
	{
		$splitbilno = (int)substr($cur_Splitbilno, 3) + 1;
		return 'SPL' . str_pad($splitbilno, 5, '0', STR_PAD_LEFT);
	}


	//// Split Bill 01-05-2025 by prakash
	public function tempBillSplitform() {

		date_default_timezone_set('Asia/Kolkata');

    $begin = new DateTime($_REQUEST['checkindate']);
    $end = new DateTime($_REQUEST['outdate']);
    $roomid = $_REQUEST['Roomid'];
    $Status = "Success";

    $room = $this->db->query("SELECT roomgrcid, grcid FROM room_status WHERE roomid = ?", [$roomid])->row_array();
    $roomgrcid = $room['roomgrcid'] ?? '';
    $grcid = $room['grcid'] ?? '';

    $this->db->query("UPDATE Trans_Credit_Entry SET groupno='', splitbillno='' WHERE roomgrcid='$roomgrcid'");
    $this->db->query("UPDATE Temp_Trans_Credit_Entry SET groupno='', splitbillno='' WHERE roomgrcid='$roomgrcid'");

    $split = $this->db->query("SELECT dbo.SPL_Credit_Entry_No() AS splitbilno, dbo.SPL_Temp_Credit_Entry_No() AS tempSplitbilno")->row_array();
    $splitbilno = $split['splitbilno'];
    $tempSplitbilno = $split['tempSplitbilno'];

    for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
        $date = $i->format("Y-m-d");

		

        $sql = "SELECT CreditNo, Credid, CreditDate, grcid
                FROM Trans_credit_entry WHERE roomgrcid='$roomgrcid' AND CreditDate='$date'
                UNION
                SELECT CreditNo, Credid, CreditDate, grcid
                FROM Temp_Trans_credit_entry WHERE roomgrcid='$roomgrcid' AND CreditDate='$date'";

        $entries = $this->db->query($sql)->result_array();
        foreach ($entries as $entry) {
            $key = $entry['CreditNo'] . '_' . $entry['Credid'];
            $groupno = $_REQUEST[$key] ?? '';

            if (strpos($entry['CreditNo'], 'TRE') === 0) {
                $this->db->query("UPDATE Temp_Trans_credit_entry SET groupno=?, splitbillno=?, mainroomgrcid=?
                                  WHERE CreditDate=? AND roomgrcid=? AND Credid=?",
                                 [$groupno, $tempSplitbilno, $roomgrcid, $entry['CreditDate'], $roomgrcid, $entry['Credid']]);
            } elseif (strpos($entry['CreditNo'], 'CRE') === 0) {
                $this->db->query("UPDATE Trans_Credit_Entry SET groupno=?, splitbillno=?, mainroomgrcid=?
                                  WHERE CreditDate=? AND roomgrcid=? AND Credid=?",
                                 [$groupno, $splitbilno, $roomgrcid, $entry['CreditDate'], $roomgrcid, $entry['Credid']]);
                $splitbilno = $this->nextSplitBillNumber($splitbilno);
            } else {
                $Status = "Failed";
            }
        }

        $receipts = $this->db->query("SELECT * FROM Trans_receipt_mas WHERE grcid='$grcid' ORDER BY Receiptid")->result_array();
        foreach ($receipts as $receipt) {
            $field = 'R' . $receipt['Receiptid'];
            if (!empty($_REQUEST[$field])) {
                $groupno = $_REQUEST[$field];
                $sqlCheck = "SELECT Revenue_Id FROM Mas_Revenue rev
                             JOIN Trans_credit_entry tce ON tce.Creditheadid = rev.Revenue_Id
                             WHERE tce.grcid=? AND CreditDate=? AND groupno=?
                             UNION
                             SELECT Revenue_Id FROM Mas_Revenue rev
                             JOIN Temp_Trans_credit_entry ttce ON ttce.Creditheadid = rev.Revenue_Id
                             WHERE ttce.grcid=? AND CreditDate=? AND groupno=?";
                $check = $this->db->query($sqlCheck, [$grcid, $date, $groupno, $grcid, $date, $groupno]);
                if ($check->num_rows() == 0) {
                    $this->db->query("UPDATE Trans_Credit_Entry SET groupno='', splitbillno='' WHERE grcid='$grcid'");
                    $this->db->query("UPDATE Temp_Trans_Credit_Entry SET groupno='', splitbillno='' WHERE grcid='$grcid'");
                    echo "Error: Debit group number {$groupno} not linked to any credit entry.";
                    return;
                } else {
                    $this->db->query("UPDATE Trans_receipt_mas SET groupno=?, splitbillno=0 WHERE Receiptid=?", [$groupno, $receipt['Receiptid']]);
                }
            }
        }
    }

    $this->db->query("UPDATE Trans_Roomdet_det SET splitbill=1 WHERE grcid='$grcid'");
    echo $Status;
}
Public function validatenightaudit()
{
	date_default_timezone_set('Asia/Kolkata');
	$boolen = true;
	$opening = 0;
	$closing = 0;
	$curClosing = 0;
	$actualroomforsales = 0;
	$totalroomrevenue = 0;
	$arr = 0;
	$totalsoldrooms = 0;
	$arp = 0;
	$Revper = 0;
	$nightposition = 0;
	$todaysarrival = 0;
	$todaysdeparture = 0;
	$occupiedrooms = 0;
	$vaccantrooms = 0;
	$dirtyrooms = 0;
	$blockedrooms = 0;
	$exparrival = 0;
	$expdeparture = 0;
	$cash = 0;
	$net = 0;
	$cc = 0;
	$toroom = 0;
	$upi = 0;
	$company = 0;
	$cheque = 0;
	$newstr = '';
	$newstrvalue = '';
	 
	 $nextYear = date('Y');
	 $curDate = date('d');
	 $curMonth = date('m');
	 $curDate = (int) $curDate;
	 $curMonth = (int) $curMonth;
	 date_default_timezone_set("Asia/Kolkata");
	
	if($curDate == 01 && $curMonth == 04){
		$newFinancialYear = date('Y-m-d');
		$newFinancialYearEnd = date('d-m-Y', strtotime('+1 year'));
		$newFinancialYearEnd =date('Y-m-d', strtotime('-1 day', strtotime($newFinancialYearEnd)));
		$hotelcode = "select Hcode from mas_hotel where Hotel_Id='".Hotel_Id."'";
		$Res = $this->db->query($hotelcode);
		foreach($Res->result_array() as $row){
			$Hcode = $row['Hcode'];
		}
		$udateoldyear = "update financial_year_new set Currentyear='0'";
		$this->db->query($udateoldyear);
		$updatenewyear = "insert financial_year_new (Fromdate,Todate,Currentyear,Companyid) values('".$newFinancialYear."', '".$newFinancialYearEnd."','1', '".$Hcode."')";
		$upexec = $this->db->query($updatenewyear);
	}
	$sql3="select DateofAudit,* from night_audit";
	$res3=$this->db->query($sql3);
	$row3=$res3->row();
	$auditdate=$row3->DateofAudit; 

	$sql="select * from Room_Status Rms 
	Inner join Mas_Room RM on Rms.Roomid=RM.Room_Id
	where Rms.Status='Y' and isnull(billsettle,0)=0";
	$res=$this->db->query($sql);
	$numberofrooms= $res->num_rows();

	$sql4="select * from Room_Status Rms 
	Inner join Mas_Room RM on Rms.Roomid=RM.Room_Id
	where Rms.Status='Y' and isnull(billsettle,0)=1";
	$res4=$this->db->query($sql4);
	$numberofunsettlement= $res4->num_rows();

	$sql1="select * from Trans_Credit_Entry  tce
	Inner join Room_Status Rs on tce.Roomgrcid=Rs.Roomgrcid and tce.Roomid=Rs.Roomid 
	Inner join Mas_Revenue Ms on Ms.Revenue_Id=tce.Creditheadid
	Where Rs.Status='Y' and Ms.RevenueHead='ROOM RENT' and CreditDate='".$auditdate."'
	and tce.roomgrcid not in (select Roomgrcid from Trans_checkout_mas where  checkoutdate='".$auditdate."' and isnull(cancelflag,0)=0 and isnull(reinstate,0) = 0) ";
	$res1=$this->db->query($sql1);
	$numberofposted= $res1->num_rows();

	$blo= "select * from room_status rs
	inner join Trans_blockmas bm on bm.roomid = rs.Roomid 
	where rs.blocked=1 and bm.todate='".$auditdate."' and isnull(bm.blockrelasedate, '')=''";
	$bo = $this->db->query($blo);
	$blocked = $bo->num_rows();

	if($blocked != 0){
		$boolen = false;
		$caltion= "Please Unblock the Blocked Rooms ";
	}else if(date("Y-m-d") < $auditdate)
	{
		$boolen = false;
		$caltion= "Feature Date Change Not Allow ";
	}
	else if($numberofunsettlement !=0)
	{
		$boolen = false;
		$caltion= "kindly Settle the Unsettled Checkout Bills";
	}
	else if($numberofrooms == $numberofposted)
	{
	  $sql2="select * from Trans_Roomdet_det det
	  inner join Room_Status room on room.grcid=det.grcid
	   where det.depdate='".$auditdate."' and room.Status='Y'";
	  $res2=$this->db->query($sql2);
	  $depdatecount= $res2->num_rows();
	  if($depdatecount !=0)
	  {
		$boolen = false;
		$Roomnos ='';
		$sql10="select * from Trans_Roomdet_det det
		inner join Mas_Room rm on rm.Room_Id=det.Roomid
		inner join Room_Status rs on rs.grcid=det.grcid
		where rs.Status='Y' and det.depdate='".$auditdate."'";
		$res10=$this->db->query($sql10);
		 foreach ($res10->result_array() as $row10)
		{ $Roomnos=$Roomnos.$row10['RoomNo'].",";  }
		$caltion="Please to Change Departure date Following Rooms ".$Roomnos;
	  }
	  else
	  {
		$boolen = true;
	  }
	}
	else
	{
	  $boolen = false;
	  $Roomnos='';
	  $sql10="select * from Room_Status Rms
	 Inner join Mas_Room RM on Rms.Roomid=RM.Room_Id
	  where Rms.Status='Y' and RM.Room_Id not in (select tce.Roomid from Trans_Credit_Entry tce 
	  Inner join Room_Status Rs on tce.Roomid=Rs.Roomid 
	  Inner join Mas_Revenue Ms on Ms.Revenue_Id=tce.Creditheadid Where Rs.Status='Y'
	   and Ms.RevenueHead='ROOM RENT' and CreditDate='".$auditdate."')";
	  $res10=$this->db->query($sql10);
	  foreach ($res10->result_array() as $row10)
	   { $Roomnos=$Roomnos.$row10['RoomNo'].",";  }
	  $caltion="Tariff Not Posted Following Rooms ".$Roomnos;
	}

	$sql = "exec dayclosingbalance '".$auditdate."'";
	$res = $this->db->query($sql);
	foreach($res->result_array() as $dayclose){
		$closing = $dayclose['handcash'];
	}
	 $previous = "select * from cash_opening where opdate='".date('Y-m-d', strtotime('-1 Days', strtotime($auditdate)))."'";
	$result= $this->db->query($previous);
	foreach($result->result_array() as $pre){
		$opening = $pre['clbal'];
	}
	$curClosing = $closing + $opening;
	$upcl = "insert into Cash_opening(opbal,clbal,opdate)values('".$opening."','".$curClosing."','".$auditdate."')";
	$resupcl = $this->db->query($upcl);
	
	if($boolen==true)
	{
	  $curY = "select fromdate from financial_year_new where Currentyear=1";
	  $exxx = $this->db->query($curY);
	  foreach($exxx ->result_array() as $ro){
		$fromdate = date('Y-m-d',strtotime($ro['fromdate']));
	  }


	  $managerReport = "exec tal_manager_audit '".date('Y-m-d', strtotime($auditdate))."','".date('Y-m-d', strtotime($auditdate))."', '".$fromdate."' ";
	  $this->db->query($managerReport); 
		$this->db->close();
		$this->db->reconnect();

		$check = "select isnull(enablewhatsappsmsformd,0) as md from extraoption";
		$check = $this->db->query($check);
		foreach ($check->result_array() as $r) {
			$enableMd = $r['md'];
		}
		if ($enableMd == 1)
	{
		$sql11 = "select poweredby,company from mas_hotel where Hotel_Id='".Hotel_Id."'";
		$res11 = $this->db->query($sql11);
		foreach($res11->result_array() as $row11){
			$poweredby = $row11['poweredby'];
			$companyName = $row11['company'];
		}

		$headermsg = $companyName.' - Day End Sales - '. date('d-m-Y', strtotime($auditdate));
		$sq = "select * from tbl_manager_audit where rptdate='" . date('Y-m-d', strtotime($auditdate)) . "'";
		$re = $this->db->query($sq);


		foreach ($re->result_array() as $rw) {
			if ($rw['particulars'] == 'Actual Rooms for Sale') {
				$actualroomforsales = $rw['days'];
			}
			if ($rw['particulars'] == 'Total Sold Rooms') {
				$totalsoldrooms = $rw['days'];
			}
			if ($rw['particulars'] == 'Total Room Revenue') {
				$totalroomrevenue = $rw['days'];
			}

			if ($rw['particulars'] == 'ARR') {
				$arr = $rw['days'];
			}
			if ($rw['particulars'] == 'ARP') {
				$arp = $rw['days'];
			}
			if ($rw['particulars'] == 'Revper') {
				$Revper = $rw['days'];
			}
			if ($rw['particulars'] == 'Day use') {
				$nightposition = $rw['days'];
			}
			if ($rw['particulars'] == 'Total Arrivals') {
				$todaysarrival = $rw['days'];
			}
			if ($rw['particulars'] == 'Total Departures') {
				$todaysdeparture = $rw['days'];
			}
			if ($rw['particulars'] == 'Occupied Room') {
				$occupiedrooms = $rw['days'];
			}
			if ($rw['particulars'] == 'Vaccant Rooms') {
				$vaccantrooms = $rw['days'];
			}

			if ($rw['particulars'] == 'Dirty Rooms') {
				$dirtyrooms = $rw['days'];
			}
			if ($rw['particulars'] == 'Management Block') {
				$blockedrooms = $rw['days'];
			}
			if ($rw['particulars'] == 'Maintetanance Block') {
				$blockedrooms += $rw['days'];
			}
			if ($rw['particulars'] == 'Exp.Arrivals Tomorrow:') {
				$exparrival = $rw['days'];
			}
			if ($rw['particulars'] == ['Exp.Departures Tomorrow:']) {
				$expdeparture = $rw['days'];
			}
		}


		$this->db->close();
		$this->db->reconnect();

		$sq1 = "
		select * from (
		select * from (
		select isnull(sum(Amount),00.00) as cash from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='CASH') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as t,
		
		(select isnull(sum(Amount),00.00) as cc from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='CREDIT CARD') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as b,
		
		(select isnull(sum(Amount),00.00) as cheque from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='CHEQUE') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as c,
		
		(select isnull(sum(Amount),00.00) as company from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='COMPANY') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as d,
		
		(select isnull(sum(Amount),00.00) as net from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='NET TRANSFER') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as e,
		
		(select isnull(sum(Amount),00.00) as toroom from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='TO ROOM') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as f,
		
		(select isnull(sum(Amount),00.00) as upi from trans_credit_entry 
		where payid=(select paymode_id from mas_paymode where paymode='UPI') and CreditDate='" . date('Y-m-d', strtotime($auditdate)) . "') as g
		
		) as tmp";
		$re1 = $this->db->query($sq1);
		foreach ($re1->result_array() as $rw1) {
			$cash = number_format($rw1['cash'],2);
			$cc = number_format($rw1['cc'],2);
			$cheque = number_format($rw1['cheque'],2);
			$company = number_format($rw1['company'],2);
			$net = number_format($rw1['net'],2);
			$toroom = number_format($rw1['toroom'],2);
			$upi = number_format($rw1['upi'],2);
		}
		$this->db->close();
		$this->db->reconnect();

		$temquy = "select Template,campaign from mas_smsmessage where  isnull(nightaudit,0)='1'";
		$smTemp = $this->db->query($temquy);
		$detmsg1 = '';
		$insmd = '';

		foreach ($smTemp->result_array() as $ro) {
			$msgg = $ro['Template'];
			$msg = $ro['Template'];
			$campaignname1 = $ro['campaign'];

			$msgg = str_replace('*auditdate*', $headermsg, $msgg);
			$msgg = str_replace('*Actual Rooms for Sale*', $actualroomforsales, $msgg);
			$msgg = str_replace('*Total Sold Rooms*', $totalsoldrooms, $msgg);
			$msgg = str_replace('*Total Room Revenue*', $totalroomrevenue, $msgg);
			$msgg = str_replace('*ARR*', $arr, $msgg);
			$msgg = str_replace('*APR*', $arp, $msgg);
			$msgg = str_replace('*REVPAR*', $Revper, $msgg);
			$msgg = str_replace('*Yesterday Night Position*', $nightposition, $msgg);
			$msgg = str_replace('*Todays Arrivals*', $todaysarrival, $msgg);
			$msgg = str_replace('*Todays Departures*', $todaysdeparture, $msgg);
			$msgg = str_replace('*Current Occupied Rooms*', $occupiedrooms, $msgg);
			$msgg = str_replace('*Vacant Rooms*', $vaccantrooms, $msgg);
			$msgg = str_replace('*Blocked Rooms*', $blockedrooms, $msgg);
			$msgg = str_replace('*Direct Rooms*', $dirtyrooms, $msgg);
			$msgg = str_replace('*Expected Arrivals Tomorrow*', $exparrival, $msgg);
			$msgg = str_replace('*Expected Departures Tomorrow *', $expdeparture, $msgg);
			$msgg = str_replace('*Cash*', $cash, $msgg);
			$msgg = str_replace('*Credit Card *', $cc, $msgg);
			$msgg = str_replace('*Cheque*', $cheque, $msgg);
			$msgg = str_replace('*Company*', $company, $msgg);
			$msgg = str_replace('*UPI*', $upi, $msgg);
			$msgg = str_replace('*To Room *', $toroom, $msgg);
			$msgg = str_replace('*Net Transfer*', $net, $msgg);
			$msgg = str_replace('*PoweredBy*', $poweredby, $msgg);

			$sle = "select * from mas_smsusers where isnull(inactive,0)<>1";
			$exe = $this->db->query($sle);

			foreach ($exe->result_array() as $CMD) {
				$smstype1 = 'NAM';
				$detmsg1 = '';
				$i = 1;


				$string = $msg;
				$strlen = strlen($string);
				$ii = 0;
				$count = 0;
				while ($ii < $strlen) {
					$newstr = '';
					if ($string[$ii] == '*') {
						$jj = $ii;
						while ($string[$jj + 1] != '*' && $jj < $strlen) {
							$newstr .= $string[$jj + 1];
							$jj++;
						}
						$ii = $jj + 1;
						$count = $count + 1;
						// insert query here..
						$newstrvalue = '';

						if ('auditdate' == $newstr) {
							$newstrvalue = $headermsg;
						} elseif ('Actual Rooms for Sale' == $newstr) {
							$newstrvalue = $actualroomforsales;
						} else if ('Total Sold Rooms' == $newstr) {
							$newstrvalue = $totalsoldrooms;
						} else if ('Total Room Revenue' == $newstr) {
							$newstrvalue = $totalroomrevenue;
						} else if ('ARR' == $newstr) {
							$newstrvalue = $arr;
						} else if ('APR' == $newstr) {
							$newstrvalue = $arp;
						} else if ('REVPAR' == $newstr) {
							$newstrvalue = $Revper;
						} else if ('Yesterday Night Position' == $newstr) {
							$newstrvalue = $nightposition;
						} else if ('Todays Arrivals' == $newstr) {
							$newstrvalue = $todaysarrival;
						} else if ('Todays Departures' == $newstr) {
							$newstrvalue = $todaysdeparture;
						} else if ('Current Occupied Rooms' == $newstr) {
							$newstrvalue = $occupiedrooms;
						} else if ('Vacant Rooms' == $newstr) {
							$newstrvalue = $vaccantrooms;
						} else if ('Blocked Rooms' == $newstr) {
							$newstrvalue = $blockedrooms;
						} else if ('Direct Rooms' == $newstr) {
							$newstrvalue = $dirtyrooms;
						} else if ('Expected Arrivals Tomorrow' == $newstr) {
							$newstrvalue = $exparrival;
						} else if ('Expected Departures Tomorrow ' == $newstr) {
							$newstrvalue = $expdeparture;
						} else if ('Cash' == $newstr) {
							$newstrvalue = $cash;
						} else if ('Credit Card ' == $newstr) {
							$newstrvalue = $cc;
						} else if ('Cheque' == $newstr) {
							$newstrvalue = $cheque;
						} else if ('UPI' == $newstr) {
							$newstrvalue = $upi;
						} else if ('Company' == $newstr) {
							$newstrvalue = $company;
						} else if ('To Room ' == $newstr) {
							$newstrvalue = $toroom;
						} else if ('Net Transfer' == $newstr) {
							$newstrvalue = $net;
						} else if ('PoweredBy' == $newstr) {
							$newstrvalue = $poweredby;
						}

						$detmsg1 = $detmsg1 . "
				insert into Outbox_smsval(msgid,smstype,variablename,Variableval,Smsval)
				values(ident_current('outbox'),'" . $smstype1 . "','" . $newstr . "',
				'" . $count . "', '" . $newstrvalue . "')";

						// echo $count;
						// echo $newstr;
					}
					$ii++;
				}

				$mdmobile = $CMD['mobileno'];
				$insmd = "insert into outbox (MobileNumber,SMSMessage,DateCreated,campaign)
						values('" . $mdmobile . "','" . $msgg . "',convert(VARCHAR,getdate(),20),'" . $campaignname1 . "')";
				$execins = $this->db->query($insmd . $detmsg1);
				$this->db->close();
				$this->db->reconnect();

			}
		}
	}
	  echo "Sucress";
	}
	else
	{
	  echo $caltion;	
	}

	

}
	public function validatenightauditreversal()
	{
		date_default_timezone_set('Asia/Kolkata');
		$boolen = true;
		$sql3 = "select DateofAudit,* from night_audit";
		$res3 = $this->db->query($sql3);
		foreach ($res3->result_array() as $row3) {
			$auditdate = $row3['DateofAudit'];
		}
		$sql = "select * from Trans_Checkin_mas where CheckinDate='" . $auditdate . "'";
		$res = $this->db->query($sql);
		$numberofcheckins = $res->num_rows();

		$sql1 = "select * from Trans_Checkout_mas where Checkoutdate='" . $auditdate . "'";
		$res1 = $this->db->query($sql1);
		$numberofcheckouts = $res1->num_rows();

		$sql4 = "select * from Trans_Credit_Entry where CreditDate ='" . $auditdate . "'";
		$res4 = $this->db->query($sql4);
		$numberofcreditentry = $res4->num_rows();
		if ($numberofcheckins != 0) {
			$boolen = false;
			$caltion = "Checkin Made at Current Date ";
		} else if ($numberofcheckouts != 0) {
			$boolen = false;
			$caltion = "Checkout Made at Current Date ";
		} else if ($numberofcreditentry != 0) {
			$boolen = false;
			$caltion = "Transaction Made at Current Date ";
		} else {
			$boolen = true;
		}
		if ($boolen == true) {
			echo "Sucress";
		} else {
			echo $caltion;
		}
	}
	public function Gst_State()
	{

		$query = $this->db->query("exec Get_StateCountry '" . $_REQUEST['Cityid'] . "'");
		foreach ($query->result() as $row) {
			$cityid = $row->Cityid;
			$State_id = $row->State_id;
			$State = $row->State;
			$Country_Id = $row->Country_Id;
			$Country = $row->Country;
		}
		echo json_encode($cityid . "-" . $State_id . "-" . $Country . "-" . $Country_Id . "-" . $State);
	}
	public function GetAdvanceGuestDetails()
	{
		$sql = " Select  mt.Title+'.'+cus.Firstname as Name, isnull(sum(amas.amount),0) as Amount,rs.roomgrcid from Mas_Room Rm
		Inner join room_status rs on Rm.Room_Id=rs.Roomid
		Inner join trans_roomdet_det rdet on rdet.roomgrcid= rs.roomgrcid
		Inner join trans_roomcustomer_Det rd on rd.grcroomdetid=rdet.grcroomdetid
		Inner join Mas_Customer cus on cus.Customer_Id=rd.Customerid
		left outer join Mas_Title mt on mt.Titleid=cus.Titelid
		left outer join Trans_Receipt_mas amas on amas.roomgrcid=rdet.roomgrcid
		where Rm.Room_Id='" . $_REQUEST['Roomid'] . "'
		Group by mt.Title,cus.Firstname,rs.roomgrcid";
		$res = $this->db->query($sql);
		foreach ($res->result() as $row) {
			$data['Name'] = $row->Name;
			$data['Amount'] = $row->Amount;
			$data['Roomgrcid'] = $row->roomgrcid;
			$row_set[] = $data;
		}
		echo json_encode($row_set);
	}
	public function getdepdate()
	{
		date_default_timezone_set('Asia/Kolkata');

		$sql = "Select det.deptime,det.depdate,det.grcid,* from Room_Status rs 
			inner join Mas_Room rm on rm.Room_Id=rs.Roomid
			Inner join Trans_Roomdet_det det on det.roomgrcid=rs.roomgrcid
			Inner join Trans_RoomCustomer_det rcd on rcd.grcroomdetid=det.grcroomdetid
			Inner join Mas_Customer cus on cus.Customer_Id=rcd.Customerid
			left outer  join Mas_Title mt on mt.Titleid=cus.Titelid
			Where rs.Status='Y' and isnull(billsettle,0)=0
			and rm.Room_Id=" . $_REQUEST['Roomid'];
		$res = $this->db->query($sql);
		foreach ($res->result() as $row) {
			$data['depdate'] = date("d/m/Y", strtotime($row->depdate));
			$data['deptime'] = substr($row->deptime, 11, 5);
			$data['newdepdate'] = date("d-m-Y", strtotime("+1 day", strtotime($row->depdate)));
			$data['Firstname'] = $row->Firstname;
			$data['Title'] = $row->Title;
			$data['Noofpersons'] = $row->Noofpersons;
			$data['grcid'] = $row->grcid;
			$row_set[] = $data;
		}
		echo json_encode($row_set);
	}
	public function getBlock()
	{
		date_default_timezone_set('Asia/Kolkata');

		$sql = "select * from Trans_blockmas where isnull(Reblockeduserid,0)=0 and  isnull(checkoutid,0)=0
		and roomid=" . $_REQUEST['Roomid'];
		$res = $this->db->query($sql);
		foreach ($res->result() as $row) {
			$data['fromdate'] = date("d/m/Y", strtotime($row->fromdate));
			$data['todate'] = date("d/m/Y", strtotime($row->todate));
			$data['mblock'] = $row->mblock;
			$data['foblock'] = $row->foblock;
			$data['blockid'] = $row->blockid;
			$data['fromtime'] = substr($row->fromtime, 11, 8);
			$data['totime'] = substr($row->totime, 11, 8);
			$row_set[] = $data;
		}
		echo json_encode($row_set);
	}





	


// public function Roomtransfersave()
// {
//     $this->db->trans_begin(); 

//     $date = date("Y-m-d");
//     $time = date("H:i:s");

//     $Roomid = (int)$_REQUEST['Roomid'];
//     $TransferTo = (int)$_REQUEST['transferto'];
//     $CustomerId = (int)$_REQUEST['customerid'];
//     $Reason = addslashes($_REQUEST['reason']);
//     $User_id = $this->session->userdata('userid') ?? 1;

//     $res = $this->db->query("SELECT * FROM Room_status WHERE Roomid = $Roomid")->result_array();

//     foreach ($res as $row) {
//         $checkindate = $row['checkindate'] ?? '';
//         $grcid = $row['grcid'];
//         $roomgrcid = $row['roomgrcid'];

//         $roomDet = $this->db->query("SELECT * FROM Trans_Roomdet_det WHERE roomgrcid = $roomgrcid")->row_array();
//         $Noofpersons = $roomDet['Noofpersons'] ?? 1;

 
//         $this->db->query("INSERT INTO Trans_RoomSwap_Mas 
//             (SwapNo, Roomid, Totroomid, Grcid, roomgrcid, Swapdate, Singlecheck, NoofPersons, Maxocc, Customerid, Nonac, Reason, userid, timeval)
//             VALUES (dbo.TransferNo(), ?, ?, ?, ?, CONVERT(VARCHAR(25), GETDATE(), 101), '0', ?, '0', ?, '0', ?, ?, CONVERT(VARCHAR(25), GETDATE(), 108))", 
//             [$Roomid, $TransferTo, $grcid, $roomgrcid, $Noofpersons, $CustomerId, $Reason, $User_id]);

     
//         $this->db->query("INSERT INTO Trans_Blockmas 
//             (blockdate, blockno, reason, fromdate, fromtime, todate, totime, roomgrcid, roomid, dirty, blockeduserid, rptdirty, blocktime)
//             VALUES (CONVERT(VARCHAR(25), GETDATE(), 101), dbo.BlockMasNo(), 'FROM ROOM SWAP', 
//                     CONVERT(VARCHAR(25), GETDATE(), 101), CONVERT(VARCHAR(25), GETDATE(), 108),
//                     CONVERT(VARCHAR(25), GETDATE(), 101), CONVERT(VARCHAR(25), GETDATE(), 108), 
//                     ?, ?, 1, ?, 1, CONVERT(VARCHAR(25), GETDATE(), 108))",
//             [$roomgrcid, $Roomid, $User_id]);

//         $this->db->query("UPDATE Room_status 
//             SET notready = '1', Status = 'N', grcid = '0', checkindate = '', roomgrcid = '0' 
//             WHERE Roomid = ?", [$Roomid]);


//         $this->db->query("UPDATE Room_status 
//             SET Status = 'Y', grcid = ?, roomgrcid = ?, checkindate = ? 
//             WHERE Roomid = ?", [$grcid, $roomgrcid, $checkindate, $TransferTo]);

//         $tarrif = '';
//         $guestcharge = 0;

//         $FromRoom = $this->db->query("SELECT RoomType_Id FROM Mas_room WHERE Room_Id = $Roomid")->row_array()['RoomType_Id'] ?? null;
//         $ToRoom = $this->db->query("SELECT RoomType_Id FROM Mas_room WHERE Room_Id = $TransferTo")->row_array()['RoomType_Id'] ?? null;

//         if ($FromRoom !== $ToRoom) {
//             $ratePlanData = $this->db->query("SELECT d.*, rt.* 
//                 FROM Mas_RatePlan_Det d
//                 JOIN Mas_RatePlan r ON r.RatePlan_Id = d.RatePlan_Id
//                 JOIN Mas_RoomType rt ON rt.RoomType_Id = r.RoomType_Id
//                 WHERE rt.RoomType_Id = ?", [$ToRoom])->row_array();

//             if (!empty($ratePlanData)) {
//                 $single = $ratePlanData['Single'];
//                 $Doubles = $ratePlanData['Doubles'];
//                 $Triple = $ratePlanData['Triple'];
//                 $Quadruple = $ratePlanData['Quadruple'];
//                 $AdultRate = $ratePlanData['AdultRate'];

//                 switch ($Noofpersons) {
//                     case 1:
//                         $tarrif = $single;
//                         break;
//                     case 2:
//                         $tarrif = $Doubles;
//                         break;
//                     case 3:
//                         $tarrif = ($Triple > 0) ? $Triple : $Doubles;
//                         $guestcharge = $AdultRate * 1;
//                         break;
//                     case 4:
//                         if ($Quadruple > 0) {
//                             $tarrif = $Quadruple;
//                         } elseif ($Triple > 0) {
//                             $tarrif = $Triple;
//                             $guestcharge = $AdultRate * 1;
//                         } else {
//                             $tarrif = $Doubles;
//                             $guestcharge = $AdultRate * 2;
//                         }
//                         break;
//                 }

//                 $this->db->query("UPDATE Trans_Roomdet_det 
//                     SET Roomid = ?, roomrent = ?, guestcharge = ? 
//                     WHERE roomgrcid = ?", [$TransferTo, $tarrif, $guestcharge, $roomgrcid]);

//                 $rentRows = $this->db->query("SELECT * FROM Trans_Roomdet_det_rent
//                     WHERE roomgrcid = ? AND checkinrenttype = 'I'
//                     AND (nightauditcompleted = 0 OR nightauditcompleted IS NULL)", [$roomgrcid])->result_array();

//                 foreach ($rentRows as $rentRow) {
//                     $this->db->query("UPDATE Trans_Roomdet_det_rent 
//                         SET singlerent = ?, Doublerent = ?, Triplerent = ?, Quartertriplerent = ?
//                         WHERE roomrentid = ?", [$single, $Doubles, $Triple, $Quadruple, $rentRow['roomrentid']]);
//                 }
//             } else {
//                 $this->db->query("UPDATE Trans_Roomdet_det 
//                     SET Roomid = ? WHERE roomgrcid = ?", [$TransferTo, $roomgrcid]);
//             }
//         } else {
//             $this->db->query("UPDATE Trans_Roomdet_det 
//                 SET Roomid = ? WHERE roomgrcid = ?", [$TransferTo, $roomgrcid]);
//         }
//     }


//     if ($this->db->trans_status() === FALSE) {
//         $this->db->trans_rollback();
//         echo "Failed";
//     } else {
//         $this->db->trans_commit();
//         echo "Success";
//     }
// }




public function Roomtransfersave()
{
	date_default_timezone_set('Asia/Kolkata');

    $this->db->trans_begin();



    $date = date("Y-m-d");
    $time = date("H:i:s");

    $Roomid = (int)$this->input->get_post('Roomid');
    $TransferTo = (int)$this->input->get_post('transferto');
    $CustomerId = (int)$this->input->get_post('customerid');
    $Reason = addslashes($this->input->get_post('reason'));
    $User_id = $this->session->userdata('userid') ?? 1;

    $sql1 = "SELECT * FROM Room_status WHERE Roomid = ?";
    $res = $this->db->query($sql1, [$Roomid]);

    foreach ($res->result_array() as $row) {
        $checkindate = $row['checkindate'] ?? '';
        $grcid = $row['grcid'];
        $roomgrcid = $row['roomgrcid'];

       $roomDet = $this->db->query("SELECT * FROM Trans_Roomdet_det WHERE roomgrcid = '" . $roomgrcid . "'")->result_array();

        $Noofpersons = $roomDet[0]['Noofpersons'] ?? 1;

    $ins = "
    INSERT INTO Trans_RoomSwap_Mas 
    (SwapNo, Roomid, Totroomid, Grcid, roomgrcid, Swapdate, Singlecheck, NoofPersons, Maxocc, Customerid, Nonac, Reason, userid, timeval) 
    VALUES 
    (
        dbo.TransferNo(),'$Roomid','$TransferTo','$grcid','$roomgrcid',CONVERT(VARCHAR(25), GETDATE(), 101),'0','$Noofpersons','0','$CustomerId','0','$Reason', '$User_id', CONVERT(VARCHAR(25), GETDATE(), 108)
    )";
     $this->db->query($ins);

       $ins1 = "
    INSERT INTO Trans_Blockmas 
    (blockdate, blockno, reason, fromdate, fromtime, todate, totime, roomgrcid, roomid, dirty, blockeduserid, rptdirty, blocktime) 
    VALUES 
    (CONVERT(VARCHAR(25), GETDATE(), 101), dbo.BlockMasNo(), 'FROM ROOM SWAP',  CONVERT(VARCHAR(25), GETDATE(), 101),  CONVERT(VARCHAR(25), GETDATE(), 108),  CONVERT(VARCHAR(25), GETDATE(), 101), CONVERT(VARCHAR(25), GETDATE(), 108), '$roomgrcid', '$Roomid',  1, '$User_id', 1, CONVERT(VARCHAR(25), GETDATE(), 108)
    )
";
   $this->db->query($ins1);


        $FromRoom = $this->db->query("SELECT RoomType_Id FROM Mas_room WHERE Room_Id = ?", [$Roomid])->row_array()['RoomType_Id'] ?? null;
        $ToRoom = $this->db->query("SELECT RoomType_Id FROM Mas_room WHERE Room_Id = ?", [$TransferTo])->row_array()['RoomType_Id'] ?? null;

        $tarrif = '';
        $guestcharge = 0;

        if ($FromRoom !== $ToRoom) {
            $ratePlanData = $this->db->query("
                SELECT d.*, rt.*
                FROM Mas_RatePlan_Det d
                JOIN Mas_RatePlan r ON r.RatePlan_Id = d.RatePlan_Id
                JOIN Mas_RoomType rt ON rt.RoomType_Id = r.RoomType_Id
                WHERE rt.RoomType_Id = ?
            ", [$ToRoom])->row_array();

            if (!empty($ratePlanData)) {
                if ($Noofpersons == 1) {
                    $tarrif = $ratePlanData['Single'];
                } elseif ($Noofpersons == 2) {
                    $tarrif = $ratePlanData['Doubles'];
                } elseif ($Noofpersons == 3) {
                if ($ratePlanData['Triple'] > 0) {
                 $tarrif = $ratePlanData['Triple'];
                   } else {
                 $tarrif = $ratePlanData['Doubles'];
				    $guestcharge = $ratePlanData['AdultRate'] * 1;
                  }
             
                } elseif ($Noofpersons == 4) {
                    if ($ratePlanData['Quadruple'] > 0) {
                        $tarrif = $ratePlanData['Quadruple'];
                    } elseif ($ratePlanData['Triple'] > 0) {
                        $tarrif = $ratePlanData['Triple'];
                        $guestcharge = $ratePlanData['AdultRate'] * 1;
                    } else {
                        $tarrif = $ratePlanData['Doubles'];
                        $guestcharge = $ratePlanData['AdultRate'] * 2;
                    }
                }
            }


		//  $sql7 = " exec Exec_Temp_Trans_credit_entry   '" .$Roomid. "', '" . $_REQUEST['Indate'] . "'";
		//  $this->db->query($sql7); 



        }

        $up = "UPDATE Room_status SET notready = '1', Status = 'N', grcid = '0', checkindate = '', roomgrcid = '0' WHERE Roomid = ?";
        $this->db->query($up, [$Roomid]);

		$roomtype = "select mtype.RoomType_Id from mas_roomtype mtype
		            inner join mas_room mr on mr.roomtype_id= mtype.roomtype_id
					where mr.room_id = $TransferTo" ;
					$roomtypeid =$this->db->query($roomtype)->row_array()['RoomType_Id'] ?? null;

     $up1 = "UPDATE Room_status 
        SET Status = 'Y', 
            grcid = '$grcid', 
            roomgrcid = '$roomgrcid', 
            checkindate = '$checkindate' 
        WHERE Roomid = '$TransferTo'";

          $this->db->query($up1);

        if ($tarrif !== '' && $tarrif !== null) {
         $up2 = "UPDATE Trans_Roomdet_det 
        SET Roomid = '$TransferTo', 
            roomrent = $tarrif, 
			typeid = $roomtypeid,
			Actroomrent = $tarrif,
			Actrackrate = $tarrif,
            guestcharge = $guestcharge
        WHERE roomgrcid = '$roomgrcid'";
        $this->db->query($up2);

	

            $single = $ratePlanData['Single'];
            $Doubles = $ratePlanData['Doubles'];
            $Triple = $ratePlanData['Triple'];
            $Quadruple = $ratePlanData['Quadruple'];

           $rentRows = $this->db->query("
           SELECT * FROM Trans_Roomdet_det_rent
            WHERE roomgrcid = $roomgrcid 
            AND checkinrenttype = 'I' 
            AND  nightauditcompleted IS NULL
             ")->result_array();


        foreach ($rentRows as $rentRow) {
    $roomrentid = (int)$rentRow['roomrentid'];
    $up3 = "
        UPDATE Trans_Roomdet_det_rent 
        SET singlerent = $single, 
            Doublerent = $Doubles, 
            Triplerent = $Triple, 
            Quartertriplerent = $Quadruple,
			extraadultcharges = $guestcharge,
			actsinglerent = $single,
			actdoublerent = $Doubles,
			acttriplerent = $Triple
        WHERE roomgrcid = $roomgrcid";
    
    $this->db->query($up3);

}
	 $sql7 = " exec Exec_Temp_Trans_credit_entry   '" .$TransferTo. "', '" . $checkindate . "'";
		 $this->db->query($sql7); 

        } 
		
		else {
            $up2 = "UPDATE Trans_Roomdet_det 
			SET Roomid = $TransferTo 
			WHERE roomgrcid = $roomgrcid";
            $this->db->query($up2);
        }
    }


	$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

		$set = $this->db->query($setqry)->row_array();

	

		if($set['Enablebeehivesroominventoryintergration'] == 1) {

			$troomexe = "select RoomNo from mas_room where Room_id = '".$TransferTo."'";

			$troom = $this->db->query($troomexe)->row_array();

		  	$fromroomnoqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
			inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
			inner join room_status rs on rs.Roomid = mr.Room_Id
			WHERE mr.Room_id = '".$Roomid."'";

		

			$fromroomno = $this->db->query($fromroomnoqry)->row_array();

		

		   $rsdetqry1 = "INSERT INTO trans_roomstatus_det
		(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,toroomno,updateflg)
		VALUES ('".$fromroomno['RoomNo']."','".$Roomid."','".$fromroomno['RoomType_Id']."','".$fromroomno['grcid']."','".$fromroomno['roomgrcid']."','".$fromroomno['RoomType']."','".date("Y-m-d") ."','".date("H:i:s") ."','','','ROOM TRANSFER','".$troom['RoomNo']."','0')";
	$exe1 = $this->db->query($rsdetqry1);


		}



	$setqry = "select enablepower from extraoption";

				$set = $this->db->query($setqry)->row_array();
		
				if($set['enablepower'] == 1) {

	 $cusqry = "select Firstname from mas_customer where Customer_Id = '".$CustomerId."'";

	$custom = $this->db->query($cusqry)->row_array();



	$customername = $custom['Firstname'];


 	$select ="select RoomNo from mas_room where Room_Id = '".$TransferTo."'";

	$roomnumber = $this->db->query($select)->row_array();

	$tranroomgqry = "SELECT roomgrcid FROM Room_status WHERE Roomid = '".$TransferTo."'";
    $tranroomgr = $this->db->query($tranroomgqry)->row_array();


	$otherDB = $this->load->database('another_db', TRUE);
  
  
	$selroom = "
	SELECT mc.ControlType_Id as control, md.Device
	FROM mas_control mc
	INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
	INNER JOIN mas_device md ON mc.Device = md.Device
	WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
	
	$result = $otherDB->query($selroom)->result_array();
	

	foreach($result as $res){
		$control = $res['control'];
		$Device = $res['Device'];
		
		$process = "select Status_Id from mas_status where upper(status) = 'CHECKIN'";
	  
		$process_id = $otherDB->query($process)->row_array();
	  
		
		 $ins9 = "
		INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
		VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$tranroomgr['roomgrcid']."','Room Swap','" . $date . "','".$time."','".$customername."','".$customername."','0')";
	  
		$this->db->query($ins9);
	}

	$sqlBatch = "update room_status set Pwcleaning = 0 , Pwvisiting = 0 , Pwmaintenance = 0,Pwondate = NULL,Pwoffdate = NULL,Pwontime = NULL,Pwofftime = NULL WHERE Roomid = '".$TransferTo."' ";
	$this->db->query($sqlBatch);

	



  $seltrns ="select RoomNo from mas_room where Room_Id = '".$Roomid."'";

  $tranroomno = $this->db->query($seltrns)->row_array();
    
	$otherDB = $this->load->database('another_db', TRUE);
  
  
	$selroom = "
	SELECT mc.ControlType_Id as control, md.Device
	FROM mas_control mc
	INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
	INNER JOIN mas_device md ON mc.Device = md.Device
	WHERE mr.RoomNo = '".$tranroomno['RoomNo']."'";
	
	$result = $otherDB->query($selroom)->result_array();


	foreach($result as $res) {
  
  $controltrans = $res['control'];
  $Devicetrans = $res['Device'];


  
  $trnpros = "select Status_Id from mas_status where upper(status) = 'CHECKOUT'";

  $trnpros_id = $otherDB->query($trnpros)->row_array();


	$ins10 = "
	INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
	VALUES ('".$tranroomno['RoomNo']."', '".$trnpros_id['Status_Id']."','".$controltrans."','".$Devicetrans."','".$roomgrcid."','Room Swap','" . $date . "','".$time."','".$customername."','".$customername."','1')";
  
	$this->db->query($ins10);
  }

}


//   $upd = "update trans_power set process = '".$trnpros_id['Status_Id']."' , control = '".$controltrans."' ,Remarks = 'Checkout' where roomno = '".$tranroomno['RoomNo']."'";

  


    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        echo "Failed";
    } else {
        $this->db->trans_commit();
        echo "Success";

	$roomswap = "
SELECT 
    cmas.swapdate, 
    oldroom.roomtype_id AS oldtypeid,
    newroom.roomtype_id AS newtypeid,
    newroomdet.depdate
FROM Trans_RoomSwap_Mas cmas
INNER JOIN mas_room oldroom ON oldroom.room_id = cmas.roomid
INNER JOIN mas_room newroom ON newroom.room_id = cmas.totroomid
INNER JOIN Trans_Roomdet_det newroomdet ON newroomdet.roomgrcid = cmas.roomGrcid
";
	$swapqry = $this->db->query($roomswap);
foreach ($swapqry->result_array() as $ress) {
    $swapdate = $ress['swapdate'];
    $oldtypeid = $ress['oldtypeid'];
    $newtypeid = $ress['newtypeid'];
    $depdate = $ress['depdate'];

    $start_date = date_create($swapdate);
    $end_date = date_create($depdate);
    $diff = date_diff($start_date, $end_date);
    $days = $diff->format("%a");

    for ($i = 0; $i <= $days; $i++) {
        $dateStr = date("Y-m-d", strtotime("+$i days", strtotime($swapdate)));

        $this->db->query("EXEC Update_RoomAvailability '$dateStr', '$oldtypeid'");
  
        $this->db->query("EXEC Update_RoomAvailability '$dateStr', '$newtypeid'");
    }
}
    }
}





	public function Guestamendmentsave()
	{
		date_default_timezone_set('Asia/Kolkata');

		// discreason
		$sql = " Select * from Mas_Room Rm
		 Inner join room_status rs on Rm.Room_Id=rs.Roomid
		 inner join Trans_roomdet_det det on det.roomgrcid=rs.roomgrcid
		 Inner join trans_roomcustomer_Det rd on rd.grcroomdetid=det.grcroomdetid
		 Inner join Mas_Customer cus on cus.Customer_Id=rd.Customerid
		 left outer join Mas_Title mt on mt.Titleid=cus.Titelid
		 left outer join Mas_city ct on ct.Cityid=cus.Cityid
		 Inner join Mas_Roomtype rt on rt.RoomType_Id=det.typeid
		 Inner join Mas_PlanType pt on pt.PlanType_Id = det.ratetypeid
		 where Rm.Room_Id='" . $_REQUEST['Roomid'] . "' and isnull(rs.status,'')='Y' and isnull(rs.billsettle,0) = 0" ;
		$res = $this->db->query($sql);
		$Roomid = $_REQUEST['Roomid'];

		foreach ($res->result_array() as $row) {
			if ($_FILES['fileToUpload']['name'][0] != '') {
				$photopath = $row['Photopath'];
				$directory = $photopath . "/" . $_REQUEST['Mobile'] . "_";
				$filecount = count(glob($directory . "*")); // filecount in that folder
				foreach (glob($directory . '*') as $file) {
					// check if is a file and not sub-directory
					if (is_file($file)) {
				
						unlink($file);
					}
				}
				$curmonth = date('M Y');
				$curYear = date('Y');
				$curDate = date('d-m-Y');
				$path = "GuestProof/" . $curYear . "/" . $curmonth . "/" . $curDate;
				$files = array_filter($_FILES['fileToUpload']['name']);
				$total_count = count($_FILES['fileToUpload']['name']);
				// Loop through every file
				for ($i = 0; $i < $total_count; $i++) {
					$j = $i;
					$j++;
					$extension = explode(".", $_FILES["fileToUpload"]["name"][$i]);
					$newname = '' . $_REQUEST['Mobile'] . "_$j." . $extension[1];
					//A file path needs to be present
					$desdirc = $path . "/" . $newname;
					if (!file_exists($path)) {

						mkdir($path, 0777, true);
					}


					if (!file_exists($desdirc)) {
						move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $desdirc);
					} else {
						move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $desdirc);
					}
				}
				$up = "update Mas_Customer set Firstname='" . $_REQUEST['Firstname'] . "',Middlename='" . $_REQUEST['Middlename'] . "',Lastname='" . $_REQUEST['Lastname'] . "',Mobile='" . $_REQUEST['Mobile'] . "',Email_ID='" . $_REQUEST['email'] . "',HomeAddress1='" . $_REQUEST['address1'] . "',HomeAddress2='" . $_REQUEST['address2'] . "',HomeAddress3='" . $_REQUEST['address3'] . "',Cityid='" . $_REQUEST['Cityid'] . "',Nationality='" . $_REQUEST['Nationid'] . "',ResidentialPhone='" . $_REQUEST['Phone'] . "',WorkAddress1='" . $_REQUEST['workaddress1'] . "',
				WorkAddress2='" . $_REQUEST['workaddress2'] . "',WorkAddress3='" . $_REQUEST['workaddress3'] . "',Id_Documenttype='" . $_REQUEST['Id_Documenttype'] . "',Id_Documentno='" . $_REQUEST['Id_Documentno'] . "', Photopath = '" . $path . "', Titelid = '".$_REQUEST['title']."'
					where Customer_Id='" . $row['Customerid'] . "'";
				}
	
				$up = "update Mas_Customer set Firstname='" . $_REQUEST['Firstname'] . "',Middlename='" . $_REQUEST['Middlename'] . "',Lastname='" . $_REQUEST['Lastname'] . "',Mobile='" . $_REQUEST['Mobile'] . "',Email_ID='" . $_REQUEST['email'] . "',HomeAddress1='" . $_REQUEST['address1'] . "',HomeAddress2='" . $_REQUEST['address2'] . "',HomeAddress3='" . $_REQUEST['address3'] . "',Cityid='" . $_REQUEST['Cityid'] . "',Nationality='" . $_REQUEST['Nationid'] . "',ResidentialPhone='" . $_REQUEST['Phone'] . "',WorkAddress1='" . $_REQUEST['workaddress1'] . "',
				WorkAddress2='" . $_REQUEST['workaddress2'] . "',WorkAddress3='" . $_REQUEST['workaddress3'] . "',Id_Documenttype='" . $_REQUEST['Id_Documenttype'] . "',Id_Documentno='" . $_REQUEST['Id_Documentno'] . "',Titelid = '".$_REQUEST['title']."'
					where Customer_Id='" . $row['Customerid'] . "'";

			$resup = $this->db->query($up);


			$roomgrcid = $row['roomgrcid'];
			$grcid = $row['grcid'];
			$Actrackrate = $row['Actrackrate'];
			$guestcharge = $row['guestcharge'];
		}
		$sql1 = "select * from trans_roomdet_det_rent where roomgrcid='" . $roomgrcid . "'  and Rentdate =( select DateofAudit from Night_audit)";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $row1) {
			$single = $row1['singlerent'];
			$double = $row1['Doublerent'];
			$triple = $row1['Triplerent'];
			$quartertriple = $row1['Quartertriplerent'];
		}
		if ($_REQUEST['Adults'] == '1') {
			$RoomRent = $single;
		} else if ($_REQUEST['Adults'] == '2') {
			$RoomRent = $double;
		} else if ($_REQUEST['Adults'] == '3') {
			$RoomRent = $triple;
		} else {
			$RoomRent = $quartertriple;
		}

		if ($RoomRent == '0.00') {
			echo 'There is No Roomrent available!';
			return;
		}
		$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $_REQUEST['discamt'] . "',(select DateofAudit from Night_audit)) as Taxid";
		$res5 = $this->db->query($sql5);
		foreach ($res5->result_array() as $row5) {
			$Taxid = $row5['Taxid'];
		}

		$sql12 = "exec Get_TaxSetup '" . $Taxid . "'";
		$res12 = $this->db->query($sql12);
		foreach ($res12->result_array() as $row12) {
			$CGST = $row12['CGST'];
		}

		$sql11 = "select NetTarriff,PubTarriff from Mas_Plantype where PlanType_Id='" . $_REQUEST['ratetypid'] . "'";
		$res11 = $this->db->query($sql11);
		foreach ($res11->result_array() as $row11) {
			$NetTarriff = $row11['NetTarriff'];
		}
		if ($NetTarriff == '1') {
			$PerRoomRent = ($RoomRent * (100 / (100 + $CGST + $CGST)));
		} else {
			$PerRoomRent = $RoomRent;
		}

		$noofadt = $_REQUEST['male'] +  $_REQUEST['female'];
       
		$up2 = "INSERT INTO trans_roomdet_det_log (grcid,roomid,noofpersons,roomgrcid,typeid,roomrent,depdate,deptime,guestcharge,extrabed,tarrifftypeid,discper,discamount,splitbill,ratetypeid,planid,plancharges,travelagentid,male,female,onlinebookingno,actroomrent,companyid,userid,actrackrate,taxid,child,editeduserid,editeddate)
		SELECT grcid,roomid,noofpersons,roomgrcid,typeid,roomrent,depdate,deptime,guestcharge,extrabed,tarrifftypeid,discper,discamount,splitbill,ratetypeid,planid,plancharges,travelagentid,male,female,onlinebookingno,actroomrent,companyid,userid,actrackrate,taxid,child,editeduserid,Getdate()
		FROM trans_roomdet_det  where roomgrcid=" . $roomgrcid;
		$upress = $this->db->query($up2);

		$up1 = "update Trans_roomdet_det set Noofpersons='" . $noofadt . "', ratetypeid='" . $_REQUEST['ratetypid'] . "',roomrent = " . $PerRoomRent . ", Actroomrent=" . $PerRoomRent . ",Actrackrate=" . $Actrackrate . ",
		discper='" . $_REQUEST['discper'] . "',discamount='" . $_REQUEST['discamt'] . "',Reason = '".$_REQUEST['discreason']."',planid='" . $_REQUEST['foodplanid'] . "',plancharges='0.00',travelagentid='" . $_REQUEST['Travelagentid'] . "',male='" . $_REQUEST['male'] . "',female='" . $_REQUEST['female'] . "',Child='" . $_REQUEST['child'] . "',onlinebookingno='" . $_REQUEST['Bookingid'] . "',companyid='" . $_REQUEST['Company_id'] . "' where grcid=" . $grcid;
		$upres = $this->db->query($up1);

		 $sql7 = " exec Exec_Temp_Trans_credit_entry   '" . $_REQUEST['Roomid'] . "', '" . date("Y-m-d") . "'";
		$res7 = $this->db->query($sql7);
		if ($res7) {
			echo "success";
		} else {
			echo "Fail";
		}
	}
	public function Settlementsave()
	{

		date_default_timezone_set('Asia/Kolkata');

        $datetime = new DateTime();
        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('H:i:s');
		$totalbillamt = $_REQUEST['totalbillamout'];
		$ros = $_REQUEST['ros'];
		$billid = $_REQUEST['Roomid'];
		$amt = 0;
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$paidamt = 0;
		$Creditheadid = 0;
		for ($j = 1; $j <= $ros; $j++) {

			$amt = $amt + $_REQUEST['Amt_' . $j];
		}
		if ($totalbillamt == $amt) {
			 $sql = "Select cms.grcid,cms.Roomgrcid,cms.Roomid,Checkoutno,RoomNo, Customerid,totalamount,Checkoutdate,tarrifftypeid,ratetypeid,taxid 
				from Trans_Checkout_mas cms
              	Inner Join Mas_Room rm on rm.Room_Id = cms.Roomid
			  	inner join trans_roomdet_det det on det.roomgrcid = cms.Roomgrcid
			  	where Checkoutid='" . $billid . "'";
			$res = $this->db->query($sql);
			foreach ($res->result_array() as $row) {

				
				$grcid = $row['grcid'];
				$roomgrcid = $row['Roomgrcid'];
				$roomid = $row['Roomid'];
				$Billno = $row['Checkoutno'];
				$Roomno = $row['RoomNo'];
				$Customerid = $row['Customerid'];
				$tamount = $row['totalamount'];
				$tcheckoutdate = $row['Checkoutdate'];
				$ttariff = $row['tarrifftypeid'];
				$tratetype = $row['ratetypeid'];
				$ttax = $row['taxid'];
			}

			for ($j = 1; $j <= $ros; $j++)
			 {

		$paymode = $_REQUEST['paymode_' . $j]; 




				if ($paymode == "COMPANY") 
				{
					$paidamt = 0;
				} 
				else if ($paymode == "TOROOM") 
				{

					  $sqlto = "select mr.RoomNo, rs.Roomid, * from room_status rs
				inner join mas_room mr on rs.Roomid = mr.Room_Id
				where rs.roomid = '" . @$_REQUEST['bank_' . $j] . "' and isnull(rs.status,'')='Y' and isnull(billsettle,0)=0";
					$exec = $this->db->query($sqlto);
					foreach ($exec->result_array() as $row) {
						$troomid = $row['Roomid'];
						// $roomid = $row['Roomid'];
						$tgrcid = $row['grcid'];
						$troomgrcid = $row['roomgrcid'];
					}

					$sq = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TCR'";
					$exsq = $this->db->query($sq);
					foreach ($exsq->result_array() as $row1) {
						$Creditheadid1 = $row1['Revenue_Id'];
					}
					$sq1 = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TDR'";
					$exsq = $this->db->query($sq);
					foreach ($exsq->result_array() as $row1) {
						$Creditheadid2 = $row1['Revenue_Id'];	
					}
					if ($tamount > 0)
					 {
						$Creditheadid = $Creditheadid1;
					} 
					else if($tamount < 0)					
					{
						$Creditheadid = $Creditheadid2;
					}
					$sqlch = "update trans_checkout_mas set toroomid= '" . $troomid . "' where Checkoutid = '" . $billid . "'";
					$exech = $this->db->query($sqlch);
					$sqlins = "insert into Trans_credit_entry (CreditNo,Roomid,Grcid,CreditDate,
				Creditheadid,Amount,roomgrcid,otherAmount,crtime,tarrifftype,tarriffsetupid,
				Actroomrent,Nettarrifamount,Ratetypeid,actrackrate,chNo)
				values(dbo.Credit_Entry_No(),'" . $troomid . "','" . $tgrcid . "','" . $tcheckoutdate . "','" . $Creditheadid . "','" . $tamount . "',
				'" . $troomgrcid . "','" . $tamount . "',convert(varchar(25),getdate(),108),'" . $ttariff . "','" . $ttax . "',
		        '" . $tamount . "','0.00','" . $tratetype . "','" . $tamount . "', '" . 'Chk.No : ' . $Billno . '- RoomNo: ' . $Roomno . "' ) ";
					$execc = $this->db->query($sqlins);

				// 	echo $sqlins;
				}
				 else
				{
					$paidamt = $_REQUEST['Amt_' . $j];
				
				}

				// 	$sqlins = "insert into Trans_credit_entry (CreditNo,Roomid,Grcid,CreditDate,
				// Creditheadid,Amount,roomgrcid,otherAmount,crtime,tarrifftype,tarriffsetupid,
				// Actroomrent,Nettarrifamount,Ratetypeid,actrackrate,chNo)
				// values(dbo.Credit_Entry_No(),'" . $roomid . "','" . $grcid . "','" . $tcheckoutdate . "','" . $Creditheadid . "','" . $tamount . "',
				// '" . $roomgrcid . "','" . $tamount . "',convert(varchar(25),getdate(),108),'" . $ttariff . "','" . $ttax . "',
		        // '" . $tamount . "','0.00','" . $tratetype . "','" . $tamount . "', '" . 'Chk.No : ' . $Billno . '- RoomNo: ' . $Roomno . "' ) ";
				// 	$execc = $this->db->query($sqlins);


				$amt = $_REQUEST['Amt_' . $j];
				// $paymode = $_REQUEST['paymode_' . $j];
				$bankid = @$_REQUEST['bank_' . $j];
				$vdate = @$_REQUEST['validate_' . $j];
				$cardnumber = @$_REQUEST['cardno_' . $j];


$paymode_id = $_REQUEST['paymode_' . $j] ?? '';

$sql = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = ?";
$paymode_row = $this->db->query($sql, [$paymode_id])->row_array();

$paymodeid = $paymode_row['PayMode_Id'] ?? null;


	         	 $ins1 = $ins1 . "insert into Trans_receipt_mas (Receiptno,Billid,ReceiptType,Amount,paymodeid,cancel,grcid,roomgrcid,rptdate,roomid,billno,narration,customerid,bank,cardnumber,ADJUSTAMOUT,userid,rpttime,validdate)
				values(dbo.SettlementNo(),'" . $billid . "','O','" . $amt . "','".$paymodeid."','0','" . $grcid . "','" . $roomgrcid . "','" . $date . "','" . $roomid . "','" . $Billno . "','Set-Room No." . $Roomno . " BillNo." . $Billno . "','" . $Customerid . "','" . $bankid . "','" . $cardnumber . "','" . $amt . "','" . User_id . "','" . $time . "','" . $vdate . "')";
				$ins2 = $ins2 . "Insert into Trans_Pay_Det(Checkoutid,Paymodeid,Bankid,Amount,ChqNo,Validdate,Paidamount,receiptid,userid)
				values('" . $billid . "','". $paymodeid."','" . $bankid . "','" . $amt . "','" . $cardnumber . "','" . $vdate . "','" . $paidamt . "',@Siden,'" . User_id . "')";
			}
			$ins3 = $ins3 . "Insert into Trans_Blockmas(blockdate,blockno,reason,roomgrcid,roomid,dirty,blockeduserid,rptdirty,blocktime,checkoutid)
				values(convert(varchar(25),getdate(),101),dbo.BlockMasNo(),'FROM CHECKOUT','" . $roomgrcid . "','" . $roomid . "','1','" . User_id . "','1',convert(varchar(25),getdate(),108),'" . $billid . "')";

			  $sql3 = "select * from Room_Status rs
					INNER JOIN Trans_checkout_mas cmas on cmas.roomgrcid=rs.roomgrcid 
					INNER JOIN Mas_Customer cus on cus.Customer_Id=cmas.Customerid 
					where rs.Status='Y' and isnull(billsettle,0)='1' and isnull(cmas.Settle,0)=0 and isnull(cmas.cancelflag,0)=0 and isnull(cmas.reinstate,0)= 0 and cmas.Checkoutno like 'CHK%' 
					and cmas.roomgrcid='" . $roomgrcid . "'";
			$res3 = $this->db->query($sql3);
			$NoOfBils = $res3->num_rows();
			$up = '';
			if ($NoOfBils == 1) {
				  $up = "UPDATE Room_status set notready='1',Status='N',grcid='0',billsettle='0',checkindate='',roomgrcid='0' where Roomid=" . $roomid;
				 	$res4 = $this->db->query($up);
			}
			$update = "update Trans_checkout_mas set Settle=1 where Checkoutid='" . $billid . "'";
			$res5 = $this->db->query($update);

			$setqry = "select enablepower,powercut_after_settlement from extraoption";

			$set = $this->db->query($setqry)->row_array();
	
			if($set['enablepower'] == 1) {

				if($set['powercut_after_settlement'] == 1) {


				 $custqry = "select Firstname from mas_customer where Customer_Id = '".$Customerid."'";

				 $cust = $this->db->query($custqry)->row_array();
			

			$select ="select RoomNo from mas_room where Room_Id = '".$_REQUEST['Roomid']."'";

			$roomnumber = $this->db->query($select)->row_array();
		  
		  
			$otherDB = $this->load->database('another_db', TRUE);
		  
		  
			 $selroom = "
			SELECT mc.ControlType_Id as control, md.Device
			FROM mas_control mc
			INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
			INNER JOIN  mas_device md ON mc.Device = md.Device
			WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";

			
			
			$result = $otherDB->query($selroom)->result_array();
			foreach($result as $res) {

				$control = $res['control'];
				$Device  = $res['Device'];
			
				$process = "SELECT Status_Id FROM mas_status WHERE UPPER(status) = 'CHECKOUT'";
				$process_id = $otherDB->query($process)->row_array();
			
				$today = date('Y-m-d');
				$nowtime = date('H:i:s');
		
				
				$ins4 = "
					INSERT INTO trans_power 
					(roomno, Process, control, devicenumber, Roomgrcid, Remarks, powerondate, powerontime, customer, usersname, onoff)
					VALUES (
						'".$roomnumber['RoomNo']."',
						'".$process_id['Status_Id']."',
						'".$control."',
						'".$Device."',
						'".$roomgrcid."',
						'Checkout',
						'".$today."',
						'".$nowtime."',
						'".$cust['Firstname']."',
						'".$cust['Firstname']."',
						'1'
					)
				";
			
				$this->db->query($ins4);
			}
		}
	}
			


			
			ob_start();
			@session_start();
			echo "BEGIN Try ";
			echo "BEGIN Transaction ";
			echo "BEGIN Tran ";
			echo "Declare @Siden INT; ";
			echo $ins1;
			echo "set @Siden=@@identity; ";
			echo $ins2;
			echo $ins3;
			echo $update;
			echo $up;
			echo " If @@error<>0 Rollback Tran else Commit Tran ";
			echo "COMMIT ";
			echo "end try ";
			echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
			echo "END CATCH ";
			$sqc = ob_get_clean();
			$ran = rand() . rand() . rand();
			$sq = "Create Procedure #" . $ran . " as " . $sqc . "";
			$result = $this->db->query($sq);
			$result = $this->db->query("exec #" . $ran);
			$this->db->close();
			$this->db->reconnect();
			echo "Bill Settled Successfully";
		} else {
			echo "Amount Incorrect";
		}
	}
	public function reservecancelsave()
	{
		date_default_timezone_set('Asia/Kolkata');

		 $reason =  $this->input->post("Reason");
		

		$sql = "select sum(rmas.totamt) as Amount,ms.Customer_Id,rm.RoomNo,res.Roomid,RoomType_Id,resdetid,fromdate,
			ci.City,res.ResNo,ms.Firstname,ms.HomeAddress1,ms.HomeAddress2,ti.Title,todate,det.noofrooms from trans_reserve_mas res
			inner join Trans_reserve_det det on res.Resid=det.resid
			left join Mas_Room rm on rm.Room_Id=res.Roomid
			Inner join Mas_Customer ms on ms.Customer_Id=res.cusid
			Inner join Mas_City ci on ci.Cityid=ms.Cityid
			Inner join Mas_Title ti on ti.Titleid=ms.Titelid
			left outer join trans_reserveadd_mas rmas on rmas.resid=res.Resid
			where res.Resid=" . $_REQUEST['Roomid'] . "  Group By ms.Customer_Id,rm.RoomNo,res.Roomid,RoomType_Id,resdetid,fromdate,
			ci.City,res.ResNo,ms.Firstname,ms.HomeAddress1,ms.HomeAddress2,ti.Title,todate,det.noofrooms";
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $row) {
			$cusid = $row['Customer_Id'];
			$Roomno = $row['RoomNo'];
			$city = $row['City'];
			$ResNo = $row['ResNo'];
			$gname = $row['Firstname'];
			$Address1 = $row['HomeAddress1'];
			$Address2 = $row['HomeAddress2'];
			$Title = $row['Title'];
			$Roomid = $row['Roomid'];
			$RoomType_Id = $row['RoomType_Id'];
			$resdetid = $row['resdetid'];
			$fromdate = $row['fromdate'];
			$todate = $row['todate'];
			$Amount = $row['Amount'];
			$noofrooms = $row['noofrooms'];
		}


		//	$up3="update Trans_Receipt_mas set cancel='1' where Billid='".$_REQUEST['resid']."'";


	   	$ins = "insert into trans_reservecancel_mas (resno,reserveid,communicate,address1,resdate,restime,address2,advamount,payid,remarks,cancelorextend,refund,totrooms,conference,userid,chqno,bankid,duedatetypeid,yearprefix)
	 values(dbo.ResclNo(),'" . $_REQUEST['Roomid'] . "',0,'" . $Address1 . "',convert(varchar(25),getdate(),101),convert(varchar(25),getdate(),108),'" . $Address2 . "','" . $Amount . "','0','".$reason."','C','','1','0','" . User_id . "','0','0','0',dbo.YearPrefix())";
		$ins1 = "insert into trans_reservecancel_det(resid,roomtypeid,fromtime,totime,advance,stat,reservedetid,waitinglist,fromdate,todate,noofrooms,refund)
	 values(@Siden,'" . $RoomType_Id . "',convert(varchar(25),getdate(),108),convert(varchar(25),getdate(),108),'0.00','C','" . $resdetid . "','0','" . $fromdate . "','" . $todate . "','".$noofrooms."','0.00')";
		$up = "update trans_reserve_mas set stat='C' where Resid=" . $_REQUEST['Roomid'];
		$up1 = "update trans_reserve_det set stat='C' where resid=" . $_REQUEST['Roomid'];
		$up2 = "update trans_reserve_det1 set cancelrooms= '".$noofrooms."', noofrooms=0 where refresdetid=" . $resdetid;
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo $ins1;
		echo $up;
		echo $up1;
		echo $up2;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		 $sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();

			
	

		$check = "select isnull(enablewhatsappsmsforresc,0) as res from extraoption";
		$check = $this->db->query($check);
		foreach ($check->result_array() as $r) {
			$enableResc = $r['res'];
		}	

		if ($enableResc == 1) {	
			$sql = "select resno, resdate,mh.mobileno,mc.mobile as mob,mh.Company+','+mh.city as hotelname,mt.title+'.'+ mc.Firstname+' '+mc.Lastname as name from trans_reserve_mas mas
		inner join mas_customer mc on mc.Customer_Id = mas.cusid
		inner join Mas_Title mt on mt.Titleid = mc.Titelid
		inner join mas_hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
		where isnull(mas.stat,'')='C' and mas.resid='" . $_REQUEST['Roomid'] . "'";
			$res = $this->db->query($sql);
			foreach ($res->result_array() as $row) {
				$resno = $row['resno'];
				$resdate = date('d-m-Y', strtotime($row['resdate']));
				$hotelname = $row['hotelname'];
				$mobileno = $row['mobileno'];
				$mob = $row['mob'];
				$name = $row['name'];
			}


			$detmsg = '';
			$i = 1;
			$temqury = "select Template,campaign from mas_smsmessage where  isnull(reservecancelG,0)='1'";
			$smsTemp = $this->db->query($temqury);
			foreach ($smsTemp->result_array() as $row) {
				$msg = $row['Template'];
				$campaignname = $row['campaign'];
				$smstype = 'GRC';

				$string = $msg;
				$strlen = strlen($string);
				$ii = 0;
				$count = 0;
				while ($ii < $strlen) {
					$newstr = '';
					if ($string[$ii] == '*') {
						$jj = $ii;
						while ($string[$jj + 1] != '*' && $jj < $strlen) {
							$newstr .= $string[$jj + 1];
							$jj++;
						}
						$ii = $jj + 1;
						$count = $count + 1;
						// insert query here..
						$newstrvalue = '';

						if ('CustomerName' == $newstr) {
							$newstrvalue = $name;
						} elseif ('Hotelname' == $newstr) {
							$newstrvalue = $hotelname;
						} else if ('ResNo' == $newstr) {
							$newstrvalue = $resno;
						} else if ('Reserve Date' == $newstr) {
							$newstrvalue = $resdate;
						} else if ('ContactNo' == $newstr) {
							$newstrvalue = $mobileno;
						}

						$detmsg = $detmsg . "
				insert into Outbox_smsval(msgid,smstype,variablename,Variableval,Smsval)
				values(ident_current('outbox'),'" . $smstype . "','" . $newstr . "',
				'" . $count . "', '" . $newstrvalue . "')";

						// echo $count;
						// echo $newstr;
					}
					$ii++;
				}

					$checkout = " select room.fromdate,mas.resid, room.typeid, room.todate from trans_reservecancel_mas mas 
					inner join Trans_reserve_det room on  room.resdetid = mas.resid
					where mas.resid= '" .$resdetid. "'";
			$checkqry = $this->db->query($checkout);
			foreach ($checkqry->result_array() as $ress) {
				$cid = $ress['fromdate'];
				$typeid = $ress['typeid'];
				$depdate = $ress['todate'];
				$resid = $ress['resid'];
			}
		

			$aa_date = date_create($cid); 
			$l_date = date_create($depdate);
			$diff = date_diff($aa_date, $l_date);
			$difference = $diff->format("%a");

			

			for ($i = 0; $i <= $difference; $i++) {
			
				$val = "exec roomavailability_validation '".$cid."','".$typeid."','".$resid."'";
				
				
				$validationResult = $this->db->query($val);
				$this->db->close();
				$this->db->reconnect();

	
				if ($validationResult) {
				
			      $insR = " exec Update_RoomAvailability  '" . $cid. "', '" . $typeid. "'";
					
					$execute = $this->db->query($insR);
					$this->db->close();
				$this->db->reconnect();
				}
				
			
				$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
				
				$this->db->close();
				$this->db->reconnect();
			}


			// $aa_date = date_create($cid); 
			// $l_date = date_create($depdate);
			// $diff = date_diff($aa_date, $l_date);
			// $difference = $diff->format("%a");
			// for ($i = 0; $i <= $difference; $i++) {
			// $insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";
		    //   $execute = $this->db->query($insR);

			// 	$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
			// }
	

		

				

				$msg = str_replace('*CustomerName*', $name, $msg);
				$msg = str_replace('*Hotelname*', $hotelname, $msg);
				$msg = str_replace('*ResNo*', $resno, $msg);
				$msg = str_replace('*Reserve Date*', $resdate, $msg);
				$msg = str_replace('*ContactNo*', $mobileno, $msg);

				$inss = "insert into outbox (MobileNumber,SMSMessage,DateCreated,campaign)
			   values('" . $mob . "','" . $msg . "',convert(VARCHAR,getdate(),20),'" . $campaignname . "')";
				$execins = $this->db->query($inss . $detmsg);
				$this->db->close();
				$this->db->reconnect();
			}
		
		
		}

		
	}



	public function checkoutsave()
	{

		date_default_timezone_set('Asia/Kolkata');
		    $sql = "exec Exec_Checkout_Save '" . $_REQUEST['Room_id'] . "','" . date("Y-m-d") . "','" . User_id . "'";

		 



			$query = $this->db->query($sql);

			if ($query && $query->num_rows() > 0) {
				$rows = $query->result_array();
				$chkoutid = $rows[0]['id']; 
			}
			
		if ($query && $query->num_rows() > 0) {
			$sql = "SELECT roomgrcid, grcid FROM room_status WHERE roomid = ?";
			$res = $this->db->query($sql, [$_REQUEST['Roomid']]);

			$row = $res->row_array();
			if ($row) {
				$roomgrcid = $row['roomgrcid'];
				$grcid     = $row['grcid'];
				
			}

	
			$this->db->close();
			$this->db->reconnect();




			$check = "select isnull(enablewhatsappsmsforcheckout,0) as checkout from extraoption";
			$check = $this->db->query($check);
			foreach ($check->result_array() as $r) {
				$enableCheckout = $r['checkout'];
			}
			if ($enableCheckout == 1) {

				$qry = "select mh.Company as Com, * from Trans_checkout_mas cm
				inner join Trans_checkin_mas ch on ch.Grcid=cm.grcid
				inner join Trans_RoomCustomer_det det on det.grcid = ch.Grcid
				inner join mas_customer cus on cus.Customer_Id = det.Customerid
				inner join mas_title t on t.Titleid = cus.Titelid
				inner join Trans_Roomdet_det roomdet on roomdet.grcid=ch.Grcid
				inner join Mas_room room on room.Room_Id=roomdet.Roomid
				inner join Mas_RoomType mr on mr.RoomType_Id= room.RoomType_Id
				inner join Trans_checkout_mas outm on outm.grcid = ch.Grcid
				inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
				where cm.Checkoutid = '".$chkoutid."' and cm.checkoutno like '%CHK%'";
				$result = $this->db->query($qry);
				foreach ($result->result_array() as $row1) {
					
					$firstname = $row1['Firstname'];
					$lastname = $row1['Lastname'];
					$title = $row1['Title'];
					$name = $title . '.' . $firstname . $lastname;
					$roomno = $row1['RoomNo'];
					$roomType = $row1['RoomType'];
					$roomTypeid = $row1['RoomType_Id'];
					$rent = $row1['roomrent'];
					$company = $row1['Com'];
					$mobile = $row1['Mobile'];
					$checkintime = new dateTime($row1['CheckinTime']);
					$checkintime = $checkintime->format('H:i');
					$resno = $row1['Grcno'];
					$checkindate = date('Y-m-d', strtotime(substr($row1['CheckinDate'], 0, 10)));
					$billamount = $row1['totalamount'];
					$checkoutdate = date('Y-m-d', strtotime(substr($row1['Checkoutdate'], 0, 10)));
					$url = $row1['feedbackmoduleurl'];
					$Checkoutid =$row1['Checkoutid'];
				}
		
			
			

				$sqlBatchalter = '';
				$sqlmdBatchalter = '';
				$hotcodeexe = "SELECT whatsapphotelcode FROM extraoption"; 
				$hotcode = $this->db->query($hotcodeexe)->row_array();

				$hotelcode = $hotcode['whatsapphotelcode'];

					$sqlBatchalter = "
		BEGIN TRY
			BEGIN TRANSACTION
		";
				$optexe = "SELECT enableguestcheckoutsms FROM extraoption"; 
		$opt = $this->db->query($optexe)->row_array();
		
	
		
		if ($opt['enableguestcheckoutsms'] == 1) {
		
			$tempexe = "SELECT 
							*, 
							mstype.prefix, sdet.variablename, sdet.variableval,
							sv.smstemplatename AS templatetype
						FROM Mas_smstemplateval sv 
						INNER JOIN Mas_smstemplateval_det sdet ON sv.smsvalid = sdet.smsvalid
						INNER JOIN Mas_smstemplatetype mstype ON mstype.stmpid = sv.templatetype
						WHERE mstype.Templatetype = 'Guest Checkout'";
		
			$templates = $this->db->query($tempexe)->result_array();
		
			$sqlBatchalter .= "
				DECLARE @msgid INT;
		
				INSERT INTO outbox (MobileNumber, SMSMessage, DateCreated, smstemplateid,whatsappsmsflg,HotelCode)
				VALUES ('{$mobile}', 'Guest Checkout', '".date('Y-m-d H:i:s')."', '".$templates[0]['templatetype']."','0','".$hotelcode."');
		
				SET @msgid = SCOPE_IDENTITY();
			";


			$selgrc = "SELECT TOP 1 Checkoutid FROM trans_checkout_mas ORDER BY Checkoutid DESC";
			$grc = $this->db->query($selgrc)->row_array();
		
			foreach ($templates as $row) {
		
				$prefix         = $row['prefix'];
				$varname        = $row['variablename'];
				$variableval    = $row['variableval'];
				$dynamicQuery   = $row['Query'];
				$wherecondition = $row['wherecondition'];
		
				if (!empty($wherecondition)) {
		
					$fullWhere = $wherecondition . " = '" . $grc['Checkoutid'] . "'";
		
					if (stripos($dynamicQuery, 'where') !== false) {
						$dynamicQuery .= " AND " . $fullWhere;
					} else {
						$dynamicQuery .= " WHERE " . $fullWhere;
					}
				}
		
				$result = $this->db->query($dynamicQuery)->row_array();
		
				if ($result) {
		
					if (array_key_exists($varname, $result)) {
		
						$smsValue = $result[$varname];
		
						$sqlBatchalter .= "
							INSERT INTO outbox_smsval (msgid, smstype, Variablename, Variableval, Smsval)
							VALUES (@msgid, '{$prefix}', '{$varname}', '{$variableval}', '{$smsValue}');
						";
		
					} else {
		
						$sqlBatchalter .= "
							INSERT INTO outbox_smsval (msgid, smstype, Variablename, Variableval, Smsval)
							VALUES (@msgid, '{$prefix}', '{$varname}', '{$variableval}', '');
						";
					}
				}
			}

	
		
			
		}

		$sqlBatchalter .= "
		IF @@ERROR <> 0 
			ROLLBACK TRANSACTION
		ELSE 
			COMMIT TRANSACTION
	END TRY
	BEGIN CATCH
		ROLLBACK TRANSACTION;
		SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;
	END CATCH;
	";


		$results = $this->db->query($sqlBatchalter);
		$this->db->close();
		$this->db->reconnect();



		$sqlmdBatchalter = "
BEGIN TRY
    BEGIN TRANSACTION
	DECLARE @msgidmd INT;

";

$optexe = "select * from mas_smsusers where isnull(inactive,0)<>1"; 
$opter = $this->db->query($optexe)->result_array();

foreach($opter as $opt) {

if ($opt['checkout'] == 1) {

    $tempexe = "SELECT 
                    *, 
                    mstype.prefix, sdet.variablename, sdet.variableval,
					sv.smstemplatename AS templatetype
                FROM Mas_smstemplateval sv 
                INNER JOIN Mas_smstemplateval_det sdet ON sv.smsvalid = sdet.smsvalid
                INNER JOIN Mas_smstemplatetype mstype ON mstype.stmpid = sv.templatetype
                WHERE mstype.Templatetype = 'MD Checkout'";

    $templates = $this->db->query($tempexe)->result_array();

    $sqlmdBatchalter .= "

        INSERT INTO outbox (MobileNumber, SMSMessage, DateCreated, smstemplateid,whatsappsmsflg,HotelCode)
        VALUES ('{$opt['mobileno']}', 'MD Checkout', '".date('Y-m-d H:i:s')."', '".$templates[0]['templatetype']."','0','".$hotelcode."');

        SET @msgidmd = SCOPE_IDENTITY();
    ";

	$selgrc = "SELECT TOP 1 Checkoutid FROM trans_checkout_mas ORDER BY Checkoutid DESC";
	$grc = $this->db->query($selgrc)->row_array();

    foreach ($templates as $row) {

        $prefix         = $row['prefix'];
        $varname        = $row['variablename'];
        $variableval    = $row['variableval'];
        $dynamicQuery   = $row['Query'];
        $wherecondition = $row['wherecondition'];

        if (!empty($wherecondition)) {

            $fullWhere = $wherecondition . " = '" . $grc['Checkoutid'] . "'";

            if (stripos($dynamicQuery, 'where') !== false) {
                $dynamicQuery .= " AND " . $fullWhere;
            } else {
                $dynamicQuery .= " WHERE " . $fullWhere;
            }
        }

        $result = $this->db->query($dynamicQuery)->row_array();

        if ($result) {

            if (array_key_exists($varname, $result)) {

                $smsValue = $result[$varname];

                $sqlmdBatchalter .= "
                    INSERT INTO outbox_smsval (msgid, smstype, Variablename, Variableval, Smsval)
                    VALUES (@msgidmd, '{$prefix}', '{$varname}', '{$variableval}', '{$smsValue}');
                ";

            } else {

                $sqlmdBatchalter .= "
                    INSERT INTO outbox_smsval (msgid, smstype, Variablename, Variableval, Smsval)
                    VALUES (@msgidmd, '{$prefix}', '{$varname}', '{$variableval}', '');
                ";
            }
        }
    }
}
			}

$sqlmdBatchalter .= "
IF @@ERROR <> 0 
    ROLLBACK TRANSACTION
ELSE 
    COMMIT TRANSACTION
END TRY
BEGIN CATCH
    ROLLBACK TRANSACTION;
    SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;
END CATCH;
";

$mdresults = $this->db->query($sqlmdBatchalter);

$whatsapp_db = $this->load->database('whatsapp_db', TRUE);
		
$whatsapp_db->query($sqlBatchalter);
$whatsapp_db->query($sqlmdBatchalter);
$this->db->close();
$this->db->reconnect();


				// outbox sms end




				$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

				$set = $this->db->query($setqry)->row_array();

				$chkqry = "select Checkoutno from trans_checkout_mas order by Checkoutno desc";

				$chkq = $this->db->query($chkqry)->row_array();
	
				if($set['Enablebeehivesroominventoryintergration'] == 1) {
	
				$rsdetqry = "INSERT INTO trans_roomstatus_det
				(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,billno,updateflg)
				VALUES ('".$roomno."','".$_REQUEST['Roomid']."','".$roomTypeid."','".$grcid."','".$roomgrcid."','".$roomType."','".$checkindate."','".$checkintime."','".$checkoutdate."','".$checkintime."','CHECKOUT','".$chkq['Checkoutno']."','0'); ";

$resde = $this->db->query($rsdetqry);
	
				}


				$setqry = "select enablepower,powercut_after_settlement from extraoption";

				$set = $this->db->query($setqry)->row_array();
		
				if($set['enablepower'] == 1) {
					if($set['powercut_after_settlement'] == 0) {

				$select ="select RoomNo from mas_room where Room_Id = '".$_REQUEST['Room_id']."'";

				$roomnumber = $this->db->query($select)->row_array();
			  
			  
				$otherDB = $this->load->database('another_db', TRUE);
			  
			  
				 $selroom = "
				SELECT mc.ControlType_Id as control, md.Device
				FROM mas_control mc
				INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
				INNER JOIN  mas_device md ON mc.Device = md.Device
				WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";

				
				
				$result = $otherDB->query($selroom)->result_array();
				foreach($result as $res) {

					$control = $res['control'];
					$Device  = $res['Device'];
				
					$process = "SELECT Status_Id FROM mas_status WHERE UPPER(status) = 'CHECKOUT'";
					$process_id = $otherDB->query($process)->row_array();
				
					$today = date('Y-m-d');
					$nowtime = date('H:i:s');
				
					$ins4 = "
						INSERT INTO trans_power 
						(roomno, Process, control, devicenumber, Roomgrcid, Remarks, powerondate, powerontime, customer, usersname, onoff)
						VALUES (
							'".$roomnumber['RoomNo']."',
							'".$process_id['Status_Id']."',
							'".$control."',
							'".$Device."',
							'".$roomgrcid."',
							'Checkout',
							'".$today."',
							'".$nowtime."',
							'".$firstname."',
							'".$firstname."',
							'1'
						)
					";
				
					$this->db->query($ins4);
				}
			}
		}
				
			

	

				$checkout = "select cmas.roomgrcid,cmas.checkoutdate,room.typeid,room.depdate from  trans_checkout_mas cmas
				inner join Trans_Roomdet_det room on  room.roomgrcid = cmas.roomGrcid
				where cmas.roomgrcid= '".$roomgrcid."'";
			$checkqry = $this->db->query($checkout);
			foreach ($checkqry->result_array() as $ress) {
				$cid = $ress['checkoutdate'];
				$typeid = $ress['typeid'];
				$depdate = $ress['depdate'];
				$roomgrcid = $ress['roomgrcid'];
			}

			$aa_date = date_create($cid); 
			$l_date = date_create($depdate);
			$diff = date_diff($aa_date, $l_date);
			$difference = $diff->format("%a");

			for ($i = 0; $i <= $difference; $i++) {
			
			
				
					$insR = "exec Update_RoomAvailability   '" . $cid . "', '" . $typeid . "'";
					
					$execute = $this->db->query($insR);
					$this->db->close();
					$this->db->reconnect();
				
			
				$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
				
			}

			}
			
			
		}

		echo $chkoutid;
		
		
	}



	
	//03-02-2023
	public function checkoutsave_old()
	{

		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = " Select * from Mas_Room Rm
		Inner join room_status rs on Rm.Room_Id=rs.Roomid
		Inner join trans_roomcustomer_Det rd on rd.grcid=rs.grcid
		Inner join Mas_Customer cus on cus.Customer_Id=rd.Customerid
		Inner join Mas_Title mt on mt.Titleid=cus.Titelid
		where Rm.Room_Id='" . $_REQUEST['Room_id'] . "'";
		$res = $this->db->query($sql);
		$Roomid = $_REQUEST['Room_id'];
		foreach ($res->result_array() as $row) {
			$Roomno = $row['RoomNo'];
			$Customer_Id = $row['Customer_Id'];
			$gname = $row['Firstname'];
			$grcid = $row['grcid'];
			$Title = $row['Title'];
			$Roomgrcid = $row['roomgrcid'];
			$RoomType_Id = $row['RoomType_Id'];
			$Noofpersons = $row['Noofpersons'];
		}

		$sql1 = "select rs.roomgrcid,isnull(adv.amount,0) advance,isnull(trc.billamount,0) billamount,
			isnull(trd.discamt,0) as discamt ,isnull(trad.Allowance,0) as Allowance ,rmas.roomno,ti.title + '.' +cmas.Firstname as customer,
			cin.checkindate as checkindate,cin.checkintime as checkintime,case when isnull(cp.company,'') <> '' then cp.company else cin.company end as company,tdet.depdate as depdate,
			tdet.deptime as deptime  from  (select roomgrcid from room_status where status='Y')
			as rs   left outer join  (select sum(isnull(mas.amount,0)) amount,mas.roomgrcid 
			from trans_advancereceipt_mas mas    inner join trans_receipt_mas trm on trm.receiptid=mas.receiptid 
			where mas.type='RMS' and  mas.roomgrcid in (select roomgrcid from room_status rs where status='Y') 
			group by mas.roomgrcid) as adv on rs.roomgrcid=adv.roomgrcid  
			left outer join (select sum(isnull(amount,0)) billamount,roomgrcid 
			from trans_credit_entry tc   left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid 
			where creditordebit<>'D'   and roomgrcid in (select roomgrcid from room_status where status='Y') 
			group by roomgrcid) as trc on trc.roomgrcid=rs.roomgrcid   left outer join 
			(select sum(isnull(amount,0)) Discamt,roomgrcid from trans_credit_entry tc  
			left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit = 'D' and isnull(IsAllowance,0)=0
			and RevenueHead not in ('ADVANCE')  and roomgrcid in (select roomgrcid from room_status
			where status='Y') group by roomgrcid) as trd on trd.roomgrcid=rs.roomgrcid 
			left outer join (select sum(isnull(amount,0)) Allowance,roomgrcid from trans_credit_entry tc   left outer join Mas_Revenue cd on cd.Revenue_Id=tc.creditheadid where creditordebit = 'D' and isnull(IsAllowance,0)=1 and RevenueHead not in ('ADVANCE') and roomgrcid in (select roomgrcid from room_status where status='Y') group by roomgrcid) as trad on trad.roomgrcid=rs.roomgrcid 
			inner join trans_roomdet_Det tdet on rs.roomgrcid=tDet.roomgrcid  
			inner join Mas_Room rmas on rmas.Room_Id=tDet.roomid  
			inner join trans_roomcustomer_det cdet on cdet.grcroomdetid=tdet.grcroomdetid 
			inner join trans_checkin_mas cin on cin.grcid = tdet.grcid 
			inner join Mas_Customer cmas on cmas.Customer_Id=cdet.customerid  
			left outer join Mas_Title ti on ti.Titleid=cmas.Titelid
			left outer join Mas_Company cp on cp.Company_Id = cmas.Company_id where rs.roomgrcid='" . $Roomgrcid . "'  ORDER BY billamount desc";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $row1) {
			$Advanceamt = $row1['advance'];
			$billamount = $row1['billamount'];
			$discamt = $row1['discamt'];
			$checkindate = $row1['checkindate'];
			$checkintime = $row1['checkintime'];
			$Allowance = $row1['Allowance'];
		}
		$date1 = date_create($checkindate);
		$date2 = date_create($date);
		$diff = date_diff($date1, $date2);
		$sql9 = "Select * From Trans_Roomdet_det where grcid='" . $grcid . "'";
		$res9 = $this->db->query($sql9);
		foreach ($res9->result_array() as $row9) {
			$taxid = $row9['taxid'];
			$Actroomrent = $row9['Actroomrent'];
			$companyid = $row9['companyid'];
			$ratetypeid = $row9['ratetypeid'];
			$Actrackrate = $row9['Actrackrate'];
		}
		$noofdays = $diff->format("%a");
		$ins = '';
		$ins2 = '';
		$ins3 = '';
		$ins4 = '';
		$ins6 = '';
		if ($noofdays == 0) 
		{

			$sql2 = "select roomrent,Extrabed,discamount,discper from Trans_Roomdet_det where roomgrcid='" . $Roomgrcid . "'";
			$res2 = $this->db->query($sql2);
			foreach ($res2->result_array() as $row2) {
				$virtualroomrent = $row2['roomrent'];
				$Extrabed = $row2['Extrabed'];

				$qry = " exec  Get_Revenueheadid 'ROOM RENT'";
				$res = $this->db->query($qry);
				foreach ($res->result_array() as $row) {
					$headid = $row['Revenue_Id'];
				}

				$ins = "Insert into Trans_Credit_Entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,Customerid,roomgrcid,payid,Bankid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,groupno,Actroomrent,companyid,Ratetypeid,actrackrate)
			 values(dbo.Credit_Entry_No(),'" . $Roomid . "','" . $grcid . "','" . $date . "','" . $headid . "','" . $virtualroomrent . "','" . $Customer_Id . "','" . $Roomgrcid . "','0','0','" . $time . "','" . $virtualroomrent . "','0','" . $RoomType_Id . "','" . $taxid . "','','" . $Actroomrent . "','" . $companyid . "','" . $ratetypeid . "','" . $Actrackrate . "')";

				$discamt = $row2['discamount'];
				if ($row2['discper'] != 0) {
					$discamt = $virtualroomrent * $row2['discper'] / 100;
				}
				if ($discamt != 0) {
					$qry = " exec  Get_Revenueheadid 'Discount'";
					$res = $this->db->query($qry);
					foreach ($res->result_array() as $row) {
						$headid = $row['Revenue_Id'];
					}

					$ins6 = "Insert into Trans_Credit_Entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,Customerid,roomgrcid,payid,Bankid,crtime,UserID,tarriffsetupid,Atcheckin,tarrifftype)
				values(dbo.Credit_Entry_No(),'" . $Roomid . "','" . $grcid . "','" . $date . "','" . $headid . "','" . $discamt . "','" . $Customer_Id . "','" . $Roomgrcid . "','0','0','" . $time . "','0','" . $taxid . "','1','" . $RoomType_Id . "')";
				}
			}
			if ($Extrabed == 0) {
				$guestcharges = 0;
			} else {
				$sql3 = "SELECT Extrabedamount FROM Mas_Room rm
			Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
			where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
				$res3 = $this->db->query($sql3);
				foreach ($res3->result_array() as $row3) {
					$Extrabedamt = $row3['Extrabedamount'];
					$guestcharges = $Extrabed * $Extrabedamt;
				}
				$qry = " exec  Get_Revenueheadid 'EXTRA BED'";
				$res = $this->db->query($qry);
				foreach ($res->result_array() as $row) {
					$headid = $row['Revenue_Id'];
				}
				$ins2 = "Insert into Trans_Credit_Entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,roomgrcid,payid,Bankid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,groupno)
			 values(dbo.Credit_Entry_No(),'" . $Roomid . "','" . $grcid . "','" . $date . "','" . $headid . "','" . $guestcharges . "','" . $Roomgrcid . "','0','0','" . $time . "','" . $virtualroomrent . "','" . User_id . "','" . $RoomType_Id . "','" . $taxid . "','')";
			}


			$Res = $this->Myclass->Get_CGST($Roomgrcid, $guestcharges, $discamt, $date);
			foreach ($Res as $row) {
				$virtualcgst = $row['CGST'];
			}
			$Res = $this->Myclass->Get_SGST($Roomgrcid, $guestcharges, $discamt, $date);
			foreach ($Res as $row) {
				$virtualsgst = $row['SGST'];
			}
			$grandtotal = ($billamount + $virtualsgst + $virtualcgst + $guestcharges + $virtualroomrent) - ($Advanceamt + $discamt + $Allowance);
		} else {
			if (time() >= strtotime(substr($checkintime, 11, 8))) {
				$sql2 = "select roomrent,Extrabed from Trans_Roomdet_det where roomgrcid='" . $Roomgrcid . "'";
				$res2 = $this->db->query($sql2);
				foreach ($res2->result_array() as $row2) {
					$virtualroomrent = $row2['roomrent'];
					$Extrabed = $row2['Extrabed'];
					$qry = " exec  Get_Revenueheadid 'ROOM RENT'";
					$res = $this->db->query($qry);
					foreach ($res->result_array() as $row) {
						$headid = $row['Revenue_Id'];
					}

					$ins = "Insert into Trans_Credit_Entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,Customerid,roomgrcid,payid,Bankid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,groupno,Actroomrent,companyid,Ratetypeid,actrackrate)
				values(dbo.Credit_Entry_No(),'" . $Roomid . "','" . $grcid . "','" . $date . "','" . $headid . "','" . $virtualroomrent . "','" . $Customer_Id . "','" . $Roomgrcid . "','0','0','" . $time . "','" . $virtualroomrent . "','0','" . $RoomType_Id . "','" . $taxid . "','','" . $Actroomrent . "','" . $companyid . "','" . $ratetypeid . "','" . $Actrackrate . "')";
				}
				if ($Extrabed == 0) {
					$guestcharges = 0;
				} else {
					$sql3 = "SELECT Extrabedamount FROM Mas_Room rm
					Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
					where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
					$res3 = $this->db->query($sql3);
					foreach ($res3->result_array() as $row3) {
						$Extrabedamt = $row3['Extrabedamount'];
						$guestcharges = $Extrabed * $Extrabedamt;
					}
					$qry = " exec  Get_Revenueheadid 'EXTRA BED'";
					$res = $this->db->query($qry);
					foreach ($res->result_array() as $row) {
						$headid = $row['Revenue_Id'];
					}
					$ins2 = "Insert into Trans_Credit_Entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,roomgrcid,payid,Bankid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,groupno)
					 values(dbo.Credit_Entry_No(),'" . $Roomid . "','" . $grcid . "','" . $date . "','" . $headid . "','" . $guestcharges . "','" . $Roomgrcid . "','0','0','" . $time . "','" . $virtualroomrent . "','" . User_id . "','" . $RoomType_Id . "','" . $taxid . "','')";
				}
				$Res = $this->Myclass->Get_CGST($Roomgrcid, $guestcharges, $discamt, $date);
				foreach ($Res as $row) {
					$virtualcgst = $row['CGST'];
				}
				$Res = $this->Myclass->Get_SGST($Roomgrcid, $guestcharges, $discamt, $date);
				foreach ($Res as $row) {
					$virtualsgst = $row['SGST'];
				}

				$grandtotal = ($billamount + $virtualsgst + $virtualcgst + $guestcharges + $virtualroomrent) - ($Advanceamt + $discamt);
			} else {
				$sql2 = "select roomrent,Extrabed from Trans_Roomdet_det where roomgrcid='" . $Roomgrcid . "'";
				$res2 = $this->db->query($sql2);
				foreach ($res2->result_array() as $row2) {
					$virtualroomrent = $row2['roomrent'];
					$Extrabed = $row2['Extrabed'];
				}
				if ($Extrabed == 0) {
					$guestcharges = 0;
				} else {
					$sql3 = "SELECT Extrabedamount FROM Mas_Room rm
					Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
					where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
					$res3 = $this->db->query($sql3);
					foreach ($res3->result_array() as $row3) {
						$Extrabedamt = $row3['Extrabedamount'];
						$guestcharges = $Extrabed * $Extrabedamt;
					}
				}
				$grandtotal = ($billamount + $guestcharges) - ($Advanceamt + $discamt);
			}
		}
		if ($grandtotal) {
			$mainins = "insert into Trans_checkout_mas(Checkoutno,Roomid,Customerid,Roomgrcid,grcid,Noofpersons,Checkoutdate,Checkouttime,totalamount,Discount,DiscPer,Settle,companyid,noofdays,userid,roundoff,toroomid,Actcheckoutno,Actcheckoutdate,actcheckouttime) 
					 values(dbo.[CheckoutNo](),'" . $Roomid . "','" . $Customer_Id . "','" . $Roomgrcid . "','" . $grcid . "','" . $Noofpersons . "','" . $date . "','" . $time . "','" . $grandtotal . "','" . $discamt . "','0','0','" . $companyid . "','1','" . User_id . "','0.00','0',dbo.[CheckoutNo](),'" . $date . "','" . $time . "')";
			$up = "update Room_Status set billsettle=1 where grcid='" . $grcid . "'";
		}
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $mainins;
		echo "set @Siden=@@identity; ";
		if ($ins != '') {
			echo $ins;
			echo $ins2;
			echo $ins6;
		}
		echo $up;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$ran = rand() . rand() . rand();
		$sq = "Create Procedure #" . $ran . " as " . $sqc . "";
		$result = $this->db->query($sq);
		$result = $this->db->query("exec #" . $ran);
		///$this->db->close();
		//$this->db->reconnect();

		$sql = "select sum(Amount) as Amount,rev.Revenue_Id,cmas.Checkoutid from Trans_checkout_mas cmas
			 inner join Trans_Credit_Entry ce on ce.grcid=cmas.grcid
			 Inner Join Mas_Revenue rev on rev.Revenue_Id=ce.Creditheadid
			  where cmas.grcid='" . $grcid . "' Group by rev.Revenue_Id,cmas.Checkoutid";
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $row) {
			$insr = "insert into Trans_checkout_det(Chkoutid,Headid,Amount) values('" . $row['Checkoutid'] . "','" . $row['Revenue_Id'] . "','" . $row['Amount'] . "')	";
			$result = $this->db->query($insr);
		}


		$qry = "select mh.Company as Com, * from Trans_checkout_mas cm
						inner join Trans_checkin_mas ch on ch.Grcid=cm.grcid
						inner join Trans_RoomCustomer_det det on det.grcid = ch.Grcid
						inner join mas_customer cus on cus.Customer_Id = det.Customerid
						inner join mas_title t on t.Titleid = cus.Titelid
						inner join Trans_Roomdet_det roomdet on roomdet.grcid=ch.Grcid
						inner join Mas_room room on room.Room_Id=roomdet.Roomid
						inner join Mas_RoomType mr on mr.RoomType_Id= room.RoomType_Id
						inner join Trans_checkout_mas outm on outm.grcid = ch.Grcid
						inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
						where cm.Checkoutid = IDENT_CURRENT('Trans_checkout_mas')";

		$result = $this->db->query($qry);
		foreach ($result->result_array() as $row1) {
			$firstname = $row1['Firstname'];
			$lastname = $row1['Lastname'];
			$title = $row1['Title'];
			$name = $title . '.' . $firstname . $lastname;
			$roomno = $row1['RoomNo'];
			$roomType = $row1['RoomType'];
			$rent = $row1['roomrent'];
			$company = $row1['Com'];
			$mobile = $row1['Mobile'];
			$checkintime = new dateTime($row1['CheckinTime']);
			$checkintime = $checkintime->format('H:i');
			$resno = $row1['Grcno'];
			$checkindate = date('Y-m-d', strtotime(substr($row1['CheckinDate'], 0, 10)));
			$billamount = $row1['totalamount'];
			$checkoutdate = date('Y-m-d', strtotime(substr($row1['Checkoutdate'], 0, 10)));
		}

		$temqury = "select Template from mas_smsmessage where  isnull(CheckoutGuest,0)='1'";
		$smsTemp = $this->db->query($temqury);
		foreach ($smsTemp->result_array() as $row) {
			$msg = $row['Template'];
			$msg = str_replace('*CutomerName*', $name, $msg);
			$msg = str_replace('*RoomNo*', $roomno, $msg);
			$msg = str_replace('*RoomType*', $roomType, $msg);
			$msg = str_replace('*RoomRent*', $rent, $msg);
			$msg = str_replace('*CompanyName*', $company, $msg);
			$msg = str_replace('*CheckiIntime*', $checkintime, $msg);
			$msg = str_replace('*ResNo*', $resno, $msg);
			$msg = str_replace('*Reserve Date*', $checkindate, $msg);
			$msg = str_replace('*Checkout Date*', $checkoutdate, $msg);
			$msg = str_replace('*Bill Amount*', $billamount, $msg);

			$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
					values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20))";
			$execins = $this->db->query($ins);
		}
		$temquy = "select Template from mas_smsmessage where  isnull(CheckoutMD,0)='1'";
		$smTemp = $this->db->query($temquy);
		foreach ($smTemp->result_array() as $ro) {
			$msgg = $ro['Template'];
			$msgg = str_replace('*CutomerName*', $name, $msgg);
			$msgg = str_replace('*RoomNo*', $roomno, $msgg);
			$msgg = str_replace('*RoomType*', $roomType, $msgg);
			$msgg = str_replace('*RoomRent*', $rent, $msgg);
			$msgg = str_replace('*CheckiIntime*', $checkintime, $msgg);
			$msgg = str_replace('*ResNo*', $resno, $msgg);
			$msgg = str_replace('*Reserve Date*', $checkindate, $msgg);
			$msgg = str_replace('*Checkout Date*', $checkoutdate, $msgg);
			$msgg = str_replace('*Bill Amount*', $billamount, $msgg);

			$sle = "select * from mas_smsusers where usertype='500'";
			$exe = $this->db->query($sle);
			foreach ($exe->result_array() as $CMD) {
				$mdmobile = $CMD['mobileno'];
				$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
							values('" . $mdmobile . "','" . $msgg . "',convert(VARCHAR,getdate(),20))";
				$execins = $this->db->query($ins);
			}
		}
		///	echo "Sucess";

		$sq = "SELECT IDENT_CURRENT('Trans_checkout_mas') id";
		$result = $this->db->query($sq);
		foreach ($result->result() as $row) {
			echo $row->id;;
		}
	}

	public function Postbillsave()
	{
		date_default_timezone_set('Asia/Kolkata');

		ob_start();
		@session_start();
		$ins1 = '';
		$date = date("Y-m-d");
		$time = date("H:i:s"); 

		
		$ins1 = "Insert into Trans_credit_entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,roomgrcid,payid,Bankid,otherAmount,UserID,tarrifftype,tarriffsetupid,yearprefix)
		values(dbo.Credit_Entry_No(),'" . $_REQUEST['Roomid'] . "','" . $_REQUEST['grcid'] . "','" . $date . "','" . $_REQUEST['Revenue_Id'] . "','" . $_REQUEST['Postamt'] . "','" . $_REQUEST['roomgrcid'] . "','0','0','" . $_REQUEST['Postamt'] . "','" . User_id . "','0','0',dbo.YearPrefix())";

		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins1;
		echo "set @Siden=@@identity; ";
		///echo $ins1;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		$sq = "SELECT IDENT_CURRENT('Trans_credit_entry') id";
		$result = $this->db->query($sq);
		foreach ($result->result() as $row) {
			echo $row->id;;
		}
	}
	public function cleardirtysave()
	{

		date_default_timezone_set('Asia/Kolkata');

	 $selqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
			inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
			inner join room_status rs on rs.Roomid = mr.Room_Id
			WHERE mr.Room_id = '".$_REQUEST['Roomid']."' ";

		// $_REQUEST['Roomid']

		$rsdetqry = '';

		$sel = $this->db->query($selqry)->row_array();
	
		$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

		$set = $this->db->query($setqry)->row_array();

	

		if($set['Enablebeehivesroominventoryintergration'] == 1) {

		  $rsdetqry = "INSERT INTO trans_roomstatus_det
		(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,billno,updateflg)
		VALUES ('".$sel['RoomNo']."','".$_REQUEST['Roomid']."','".$sel['RoomType_Id']."','".$sel['grcid']."','".$sel['roomgrcid']."','".$sel['RoomType']."','".date("Y-m-d") ."','".date("H:i:s") ."','','','VACANT','','0'); ";


		}

		ob_start();
		@session_start();
		$ins1 = '';
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$ins1 = "update Room_Status set notready=0,blocked=0,foblock=0,mblock=0 where Roomid='" . $_REQUEST['Roomid'] . "'";
		$ins2 = "Update Trans_blockmas set dirty=0, Reblockeduserid='" . User_id . "', unblockreason='" . $_REQUEST['remark'] . "',blockrelasetime='" . $time . "',blockrelasedate='" . $date . "' where isnull(dirty,0)=1 and roomid='" . $_REQUEST['Roomid'] . "'";
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins1;
		echo $ins2;
		echo $rsdetqry;
		echo "set @Siden=@@identity; ";
		///echo $ins1;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		 $sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		echo "Sucess";
	}
	public function Advanceentrysave()
	{

		date_default_timezone_set('Asia/Kolkata');
		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$narration = "Adv-Room No." . $_REQUEST['Roomno'] . " from ";
		if ($_REQUEST['bank'] == '') {
			$bank = 0;
			$cardnumber = 0;
		} else {
			$bank = $_REQUEST['bank'];
			$cardnumber = $_REQUEST['cardnumber'];
		}
		
   $quer = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = '" . $_REQUEST['paymode'] . "'";
$exeqry = $this->db->query($quer);
$row = $exeqry->row_array();
$payid = $row['PayMode_Id'] ?? 0;

$bankquer = "SELECT Bankid FROM mas_bank WHERE Bank = '" . $bank . "'";
$bankqr = $this->db->query($bankquer);
$row = $bankqr->row_array();
$bankid = $row['Bankid'] ?? 0;
$Bankiddd  = $_REQUEST['bank'];



	 	$ins = "Insert into Trans_receipt_mas (Receiptno,ReceiptType,Amount,paymodeid,cancel,grcid,roomgrcid,rptdate,roomid,narration,customerid,bank,cardnumber,validdate,ADJUSTAMOUT,userid,rpttime,billremark,yearprefix)
	  values(dbo.Advancereceiptno(),'C','" . $_REQUEST['givenadvance'] . "','" . $payid . "','0','" . $_REQUEST['grcid'] . "','" . $_REQUEST['roomgrcid'] . "','" . $date . "','" . $_REQUEST['Roomid'] . "','" . $narration . "','" . $_REQUEST['cusid'] . "','" . $Bankiddd . "','" . $cardnumber . "','" . @$_REQUEST['validate'] . "','" . $_REQUEST['givenadvance'] . "','" . User_id . "','" . $time . "','" . $_REQUEST['advanceremark'] . "', dbo.YearPrefix())";
		$ins1 = "Insert into Trans_Advancereceipt_mas (receiptid,amount,roomgrcid,type,adjustamount,userid,yearprefix)
	  values(@siden,'" . $_REQUEST['givenadvance'] . "','" . $_REQUEST['roomgrcid'] . "','RMS','" . $_REQUEST['givenadvance'] . "','" . User_id . "',dbo.YearPrefix())";

	  
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo $ins1;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
	    $sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		 $sq = "SELECT IDENT_CURRENT('Trans_Receipt_mas') id";
		$result = $this->db->query($sq);
		foreach ($result->result() as $row) {
			echo $row->id;
		}
	}
	public function ReservationAdvanceentrysave()
	{
		date_default_timezone_set('Asia/Kolkata');
		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$narration = "Reservation Adv-RES No." . $_REQUEST['Reservationnum'] . " from ";
		if ($_REQUEST['bank'] == '') {
			$bank = 0;
			$cardnumber = 0;
		} else {
			$bank = $_REQUEST['bank'];
			$cardnumber = $_REQUEST['cardnumber'];
		}

		$ins = "insert into Trans_reserveadd_mas (resadno,resid,cusid,totamt,resaddate,resno,userid,resaddtime)
	  values(dbo.Reservationaddvanceno(),'" . $_REQUEST['resid'] . "','" . $_REQUEST['cusid'] . "','" . $_REQUEST['givenadvance'] . "','" . $date . "','" . $_REQUEST['Reservationnum'] . "','" . User_id . "','" . $time . "')";
		$ins1 = "insert into Trans_reserveadd_det(typeid,resdetid,resid,paidadv,advance,resaddid,payid,bankid,chno,validdate,advancepost,cardtypeid)values('" . $_REQUEST['RoomType_Id'] . "','" . $_REQUEST['resid'] . "','" . $_REQUEST['resid'] . "','0','" . $_REQUEST['givenadvance'] . "',@Siden,'" . $_REQUEST['paymode'] . "','" . $bank . "','" . $cardnumber . "','" . $_REQUEST['validate'] . "','" . $_REQUEST['givenadvance'] . "','0')";

		$ins2 = "Insert into Trans_receipt_mas (Billno,Billid,Receiptno,ReceiptType,Amount,paymodeid,cancel,grcid,roomgrcid,rptdate,roomid,narration,customerid,bank,cardnumber,ADJUSTAMOUT,userid,rpttime,billremark,resdetid)
	  values((select top 1 resadno from trans_reserveadd_mas order by resaddid desc),@Siden,dbo.ReserveAdvancereceiptno(),'A','" . $_REQUEST['givenadvance'] . "','" . $_REQUEST['paymode'] . "','0','0','0','" . $date . "','" . $_REQUEST['Room_Id'] . "','" . $narration . "','" . $_REQUEST['cusid'] . "','" . $bank . "','" . $cardnumber . "','" . $_REQUEST['givenadvance'] . "','" . User_id . "','" . $time . "','" . $_REQUEST['advanceremark'] . "',@siden2)";
		$ins3 = "Insert into Trans_Advancereceipt_mas (receiptid,amount,roomgrcid,type,balanceamount,userid)
	  values(@siden3,'" . $_REQUEST['givenadvance'] . "','" . $_REQUEST['resid'] . "','RES','" . $_REQUEST['givenadvance'] . "','" . User_id . "')";

		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo "Declare @Siden2 INT; ";
		echo "Declare @Siden3 INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo $ins1;
		echo "set @Siden2=@@identity; ";
		echo $ins2;
		echo "set @Siden3=@@identity; ";
		echo $ins3;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		$sq = "SELECT IDENT_CURRENT('Trans_Receipt_mas') id";
		$result = $this->db->query($sq);
		foreach ($result->result() as $row) {
			echo $row->id;;
		}
	}
	public function temptarriffupdate()
	{

		date_default_timezone_set('Asia/Kolkata');
		$qry = "exec  Get_Temp_roomdet_det " . Hotel_Id . "," . $_REQUEST['Roomid'];
		$res = $this->db->query($qry);
		foreach ($res->result() as $row) {
			$id = $row->roomrentid;
			$single = $_REQUEST[$id . "single"];
			$double = $_REQUEST[$id . "double"];
			$triple = $_REQUEST[$id . "triple"];
			$quartertriple = $_REQUEST[$id . "quartertriple"];
			$extrabed = $_REQUEST[$id . "extrabed"];
			if ($extrabed == '') {
				$extrabed = 0;
			}
			$up = "update Temp_trans_roomdet_det_rent set singlerent='" . $single . "',Doublerent='" . $double . "',Triplerent='" . $triple . "',Quartertriplerent='" . $quartertriple . "',extraadultcharges='" . $extrabed . "' where roomrentid='" . $id . "'";
			$upres = $this->db->query($up);
		}
		echo "Tariffedit updated";
	}
	public function tarriffupdate_old()
	{

		date_default_timezone_set('Asia/Kolkata');
		$qry = "select * from trans_roomdet_det_rent where grcid=" . $_REQUEST['grcid'];
		$res = $this->db->query($qry);
		foreach ($res->result() as $row) {
			$id = $row->roomrentid;
			$single = $_REQUEST[$id . "single"];
			$double = $_REQUEST[$id . "double"];
			$triple = $_REQUEST[$id . "triple"];
			$quartertriple = $_REQUEST[$id . "quartertriple"];
			$extrabed = $_REQUEST[$id . "extrabed"];
			if ($extrabed == '') {
				$extrabed = 0;
			}
			$up = "update trans_roomdet_det_rent set singlerent='" . $single . "',Doublerent='" . $double . "',Triplerent='" . $triple . "',Quartertriplerent='" . $quartertriple . "',extraadultcharges='" . $extrabed . "' where roomrentid='" . $id . "'";
			$upres = $this->db->query($up);
		}
		echo "Tariffedit updated";
	}

	public function tarriffupdate()
	{
		date_default_timezone_set('Asia/Kolkata');
	
		 $qry = "SELECT * FROM trans_roomdet_det_rent WHERE roomgrcid = ?";
		 $res = $this->db->query($qry, [$_REQUEST['tariffroomgrcid']]);

		
	
		foreach ($res->result() as $row) {
	
		 	$id = $row->roomrentid;
	
			 $single = isset($_REQUEST[$id . "single"]) ? $_REQUEST[$id . "single"] : 0;
			$double = isset($_REQUEST[$id . "double"]) ? $_REQUEST[$id . "double"] : 0;
			$triple = isset($_REQUEST[$id . "triple"]) ? $_REQUEST[$id . "triple"] : 0;
			$quartertriple = isset($_REQUEST[$id . "quartertriple"]) ? $_REQUEST[$id . "quartertriple"] : 0;
			$extrabed = isset($_REQUEST[$id . "extrabed"]) ? $_REQUEST[$id . "extrabed"] : 0;
	
			 $update = "
				UPDATE trans_roomdet_det_rent
				SET 
					singlerent = '".$single."', 
					Doublerent = '".$double."', 
					Triplerent = '".$triple."', 
					Quartertriplerent = '".$quartertriple."', 
					extraadultcharges ='".$extrabed."' 
				WHERE roomrentid = '".$id."'
			";
	
			$this->db->query($update);
		}
	
		echo "Tariffedit updated";
	}
	
	public function tempguestupdate()
	{

		date_default_timezone_set('Asia/Kolkata');
		$sql = "select * from temp_customer where Mobile ='" . $_REQUEST['gmobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$ins = "insert into Temp_Customer (Mobile,HomeAddress1,HomeAddress2,HomeAddress3,Homepincode,Nationality,ResidentialPhone,
		WorkAddress1,WorkAddress2,WorkAddress3,Workpincode,WorkCityid,WorPhone,gender,Profession,Birthdate,Weddingdate,
		Likes,Dislikes,Preffered_Room,Hotel_Commends,passportno,Passport_issueplace,Passport_issuedate,Passport_Expirydate,VISA_No,VISA_Issueplace,
		VISA_Issuedate,VISA_Expirydate,Id_Documenttype,Id_Documentno) values('" . $_REQUEST['gmobile'] . "','" . $_REQUEST['address1'] . "','" . $_REQUEST['address2'] . "','" . $_REQUEST['address3'] . "','" . $_REQUEST['pincode'] . "','" . $_REQUEST['Nationid'] . "','" . $_REQUEST['phone'] . "',
		'" . $_REQUEST['workaddress1'] . "','" . $_REQUEST['workaddress2'] . "','" . $_REQUEST['workaddress3'] . "','" . $_REQUEST['workpincode'] . "','" . $_REQUEST['workcity'] . "','" . $_REQUEST['workphone'] . "','" . $_REQUEST['gender'] . "','" . $_REQUEST['profession'] . "','" . $_REQUEST['dob'] . "','" . $_REQUEST['anniversarydate'] . "','" . $_REQUEST['likes'] . "',
		'" . $_REQUEST['dislikes'] . "','" . $_REQUEST['preferredroom'] . "','" . $_REQUEST['hotelcommends'] . "','" . $_REQUEST['passportno'] . "','" . $_REQUEST['issueplace'] . "','" . $_REQUEST['dateofissue'] . "','" . $_REQUEST['expirydate'] . "','" . $_REQUEST['visano'] . "','" . $_REQUEST['visaissueplace'] . "','" . $_REQUEST['visadateofissue'] . "','" . $_REQUEST['visaexpirydate'] . "',
		'" . $_REQUEST['Id_Documenttype'] . "','" . $_REQUEST['Id_Documentno'] . "')";
			$res = $this->db->query($ins);
			// echo "1";
		} else {
			$up = "Update Mas_Customer set HomeAddress1='" . $_REQUEST['address1'] . "',HomeAddress2='" . $_REQUEST['address2'] . "',HomeAddress3='" . $_REQUEST['address3'] . "',Homepincode='" . $_REQUEST['pincode'] . "',Nationality='" . $_REQUEST['Nationality'] . "',ResidentialPhone='" . $_REQUEST['phone'] . "',WorkAddress1='" . $_REQUEST['workaddress1'] . "',
		WorkAddress2='" . $_REQUEST['workaddress2'] . "',WorkAddress3='" . $_REQUEST['workaddress3'] . "',Workpincode='" . $_REQUEST['workpincode'] . "',WorkCityid='" . $_REQUEST['workcity'] . "',WorPhone='" . $_REQUEST['workphone'] . "',gender='" . $_REQUEST['gender'] . "',Profession='" . $_REQUEST['profession'] . "',Birthdate='" . $_REQUEST['dob'] . "',Weddingdate='" . $_REQUEST['anniversarydate'] . "',
		Likes='" . $_REQUEST['likes'] . "',Dislikes='" . $_REQUEST['dislikes'] . "',Preffered_Room='" . $_REQUEST['preferredroom'] . "',Hotel_Commends='" . $_REQUEST['hotelcommends'] . "',passportno='" . $_REQUEST['passportno'] . "',Passport_issueplace='" . $_REQUEST['issueplace'] . "',Passport_issuedate='" . $_REQUEST['dateofissue'] . "',Passport_Expirydate='" . $_REQUEST['expirydate'] . "',VISA_No='" . $_REQUEST['visano'] . "',
		VISA_Issueplace='" . $_REQUEST['visaissueplace'] . "',VISA_Issuedate='" . $_REQUEST['visadateofissue'] . "',VISA_Expirydate='" . $_REQUEST['visaexpirydate'] . "',Id_Documenttype='" . $_REQUEST['Id_Documenttype'] . "',Id_Documentno='" . $_REQUEST['Id_Documentno'] . "' where Mobile ='" . $_REQUEST['gmobile'] . "'";
		$res = $this->db->query($up);
		// echo '2';
		}
		

		echo "Guest Details Updated";
	}
	public function ResCheckinsave()
	{

		date_default_timezone_set('Asia/Kolkata');

		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuningCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Lastname'] . "','1','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email_ID'] . "','" . $_REQUEST['City_id'] . "','" . $_REQUEST['State_id'] . "','" . $_REQUEST['Country_id'] . "','" . $_REQUEST['Middlename'] . "'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
		}
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$ins = '';
		$ins4 = '';
		$ins5 = '';
		$ins6 = '';
		$ins9 = '';

		$Company_Id = $_REQUEST['Company_Id'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}
		 $rowcount =  $_REQUEST['rowcount'];

		$status = '';

		$sql2 = " SELECT max(roomgrcid) as roomgrcid FROM Trans_Roomdet_det";
		$res2 = $this->db->query($sql2);
		foreach ($res2->result_array() as $row2) {
			// if($i= 0){
				$roomgrcid = $row2['roomgrcid'] ;
			// } else{
			// 	$roomgrcid = $row2['roomgrcid'];
				
			// }
			
		}

		for ($i = 0; $i < $rowcount; $i++) {

			$Indate = str_replace('/', '-', $_REQUEST['Indate'][$i]);
			$Indate = date('Y/m/d', strtotime($Indate));
			$Indatee = date('Y/m/d', strtotime($Indate));
			$Indate1 = date('m/d/Y', strtotime($Indate));
			$todate = str_replace('/', '-', $_REQUEST['todate'][$i]);
			$todate = date('Y/m/d', strtotime($todate));
			$RateCode = $_REQUEST['RateCode'][$i];

			$delete = "Delete temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['RoomNo'][$i] . "'";
			$sql = $this->db->query($delete);
			while ($Indatee <= $todate) {

				$sql6 = "SELECT * FROM Mas_RatePlan RP 
				 INNER JOIN Mas_RatePlan_Det RD on RD.RatePlan_Id=RP.RatePlan_Id
				 INNER JOIN Mas_Plantype PT on PT.PlanType_Id=Rp.PlanType_Id
				 INNER JOIN Mas_Roomtype RT on RT.RoomType_Id=RP.RoomType_Id
				 INNER JOIN Mas_Room RM on RM.RoomType_Id =RT.RoomType_Id
				 where RM.Room_Id ='" . $_REQUEST['RoomNo'][$i] . "' Order by PT.PlanType_Id";
				$res6 = $this->db->query($sql6);
				$data = $res6->result();
				foreach ($res6->result_array() as $row6) {

					$Adults = $row6['Adults'];
					$Extrabedcount = $row6['Extrabedcount'];
					$singlerent = $row6['Single'];
					$Doublerent = $row6['Doubles'];
					$Triplerent = $row6['Triple'];
					$Quartertriplerent = $row6['Quadruple'];
					$ins3 = "Insert into temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
				values('" . $Indatee . "','" . $_REQUEST['RoomNo'][$i] . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','I','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $row6['Extrabedamount'] . "','" . User_id . "',dbo.GrcNo(),'" . Hotel_Id . "')";
					$result = $this->db->query($ins3);
				}
				$Indatee = date("Y/m/d", strtotime("+1 day", strtotime($Indatee)));
			}


			$ins6 = $ins6 . "Insert into Trans_Checkin_mas (Grcno,CheckinDate,CheckinTime,ExpDate,ExpTime,Noadults,Nochilds,NoofRooms,userid,yearprefix)
			values(dbo.GrcNo(),'" . $Indate . "',convert(VARCHAR,getdate(),108),'" . $todate . "',convert(VARCHAR,getdate(),108),'" . $_REQUEST['Adults'][$i] . "','" . $_REQUEST['Child'][$i] . "','1','" . User_id . "',dbo.YearPrefix())";
			$checkinrooms = 0;
			$residquery = "select mas.Resid from Trans_Reserve_Mas mas 
			inner join Trans_Reserve_det det on mas.Resid=det.resid 
			where mas.ResNo='" . $_REQUEST['ResNo'] . "' and det.typeid='" . $_REQUEST['roomtype'][$i] . "' and det.fromdate = '" . $Indate . "' ";
			$residarr = $this->db->query($residquery);
			$resid = $residarr->row_array(); 

			$che = " select isnull(checkinrooms,0) as checkinrooms, * from  trans_reserve_det trdet inner join trans_reserve_mas trmas on trmas.resid = trdet.resid  where trmas.resno='" . $_REQUEST['ResNo'] . "' and trdet.fromdate = '" . $Indate . "' and typeid='" . $_REQUEST['roomtype'][$i] . "'";
			$exec = $this->db->query($che);
			foreach ($exec->result_array() as $ro)
			 {

				$noforooms = $ro['noofrooms'];
				if ($noforooms >= $ro['checkinrooms']) {
					if ($ro['typeid'] == $_REQUEST['roomtype'][$i]) {
						$checkinrooms = $ro['checkinrooms'] + 1;
					}
				}

				// if ($checkinrooms == $ro['noofrooms']) {
				// 	$status = 'Y';
				// } else {
				// 	$status = '';
				// }
			}


			// $ins = $ins . "update Trans_Reserve_det set stat='" . $status . "', checkinrooms='" . $checkinrooms . "'
			// where resid=(select mas.Resid from Trans_Reserve_Mas mas 
			// inner join Trans_Reserve_det det on mas.Resid=det.resid 
			// where mas.ResNo='" . $_REQUEST['ResNo'] . "' and det.typeid='" . $_REQUEST['roomtype'][$i] . "') and typeid='" . $_REQUEST['roomtype'][$i] . "' ";

			// $ins = $ins . "update Trans_Reserve_det1 set  noofrooms=isnull(noofrooms,0) - '" . $checkinrooms . "'
			// where refresdetid=(select det.Resdetid from Trans_Reserve_Mas mas 
			// inner join Trans_Reserve_det det on mas.Resid=det.resid 
			// where mas.ResNo='" . $_REQUEST['ResNo'] . "' and det.typeid='" . $_REQUEST['roomtype'][$i] . "') and typeid='" . $_REQUEST['roomtype'][$i] . "' ";

		
			$sql3 = "SELECT * FROM Mas_Room rm
				Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
				where rm.RoomType_Id='" . $_REQUEST['roomtype'][$i] . "'";
			$res3 = $this->db->query($sql3);
			foreach ($res3->result_array() as $row3) {
				$Room_id = $_REQUEST['RoomNo'][$i];
				$RoomType_Id = $row3['RoomType_Id'];
				$Adults = $row3['Adults'];
				$Extrabedamount = $row3['Extrabedamount'];
			}
			$sql4 = "SELECT * FROM temp_trans_roomdet_det_rent where roomid='" . $Room_id . "'";
			$res4 = $this->db->query($sql4);
			foreach ($res4->result_array() as $row4) {
				if ($Adults >= $_REQUEST['Adults'][$i]) {
					$Extrabed = 0;
					$guestcharge = 0;
					if ($_REQUEST['Adults'][$i] == 1) {
						$RoomRent = $row4['singlerent'];
						$actRoomRent = $row4['actsinglerent'];
					}
					if ($_REQUEST['Adults'][$i] == 2) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					}
					if ($_REQUEST['Adults'][$i] == 3) {
						if ($row4['Triplerent'] == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$RoomRent = $row4['Triplerent'];
							$actRoomRent = $row4['acttriplerent'];
						}
					}
					if ($_REQUEST['Adults'][$i] >= 4) {
						if ($row4['Quartertriplerent'] == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$actRoomRent = $row4['actquartertriplerent'];
						}
					}
				} else {
					$Extrabed = $_REQUEST['Adults'][$i] - $Adults;
					$guestcharge = $Extrabedamount;
					if ($Adults == 1) {
						$RoomRent = $row4['singlerent'];
						$actRoomRent = $row4['actsinglerent'];
					}
					if ($Adults == 2) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					}
					if ($Adults == 3) {
						if ($Adults == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$RoomRent = $row4['Triplerent'];
							$actRoomRent = $row4['acttriplerent'];
						}
					}
					if ($Adults >= 4) {
						if ($row4['Quartertriplerent'] == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$RoomRent = $row4['Quartertriplerent'];
							$actRoomRent = $row4['actquartertriplerent'];
						}
					}
				}
			}
			// $Discamt = 0;
			// $sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
			// $res5 = $this->db->query($sql5);
			// foreach ($res5->result_array() as $row5) {
			// 	$Taxid = $row5['Taxid'];
			// }

			$Discamt = 0;
			$sql5 = "SELECT dbo.Get_Taxid($RoomRent,$RoomRent,$RoomRent,$guestcharge,$Discamt,'$Indate1') AS Taxid";
			$res5 = $this->db->query($sql5);
			$Taxid = ($res5 && $res5->num_rows() > 0) ? $res5->row()->Taxid : 0;
	
			$res12 = $this->db->query("EXEC Get_TaxSetup '$Taxid'");
			$CGST = ($res12 && $res12->num_rows() > 0) ? $res12->row()->CGST : 0;
	
			$res11 = $this->db->query("SELECT NetTarriff FROM Mas_Plantype WHERE PlanType_Id='$RateCode'");
			$NetTarriff = ($res11 && $res11->num_rows() > 0) ? $res11->row()->NetTarriff : 0;
	
			$PerRoomRent = ($NetTarriff == '1') ? ($RoomRent * (100 / (100 + $CGST + $CGST))) : $RoomRent;


            $roomgrcid++;
			$ins6 = $ins6 . "INSERT INTO Trans_Roomdet_det (resno,grcid,Roomid,Noofpersons,roomgrcid,typeid,roomrent,depdate,deptime,guestcharge,Extrabed,tarrifftypeid,ratetypeid,Actroomrent,userid,Actrackrate,taxid,companyid,travelagentid,onlinebookingno,discper,discamount,planid,plancharges,male)
			values('" . $_REQUEST['ResNo'] . "',ident_current('Trans_checkin_mas'),'" . $Room_id . "','" . $_REQUEST['Adults'][$i] . "',
			'" . $roomgrcid . "','" . $RoomType_Id . "','" . $PerRoomRent . "','" . $todate . "',convert(VARCHAR,getdate(),108),
			'" . $guestcharge . "','" . $Extrabed . "','" . $RoomType_Id . "','" . $_REQUEST['RateCode'][$i] . "',
			'" . $RoomRent . "','" . User_id . "','" . $actRoomRent . "','" . $Taxid . "','" . $Company_Id . "',
			'" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'][$i] . "','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . $_REQUEST['foodplan'][$i] . "','0','" . $_REQUEST['Adults'][$i] . "')";

			$ins6 = $ins6 . "Insert Into Trans_RoomCustomer_det (grcid,Grcroomdetid,Customerid)
			Values(ident_current('Trans_checkin_mas'),ident_current('Trans_Roomdet_det'),'" . $Customer_Id . "')";

			$sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $Room_id . "'";
			$res6 = $this->db->query($sql6);
			foreach ($res6->result_array() as $row6) {
				$singlerent = $row6['singlerent'];
				$Doublerent = $row6['Doublerent'];
				$Triplerent = $row6['Triplerent'];
				$Quartertriplerent = $row6['Quartertriplerent'];
				$ChildRate = $row6['extrachildcharges'];
				if ($ChildRate == '') {
					$ChildRate = 0;
				}
				$ins4 .=  "Insert into trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,roomgrcid,grcid,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,extrachildcharges,noofpersons,userid)
		values('" . $Indate . "','" . $Room_id . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $roomgrcid . "',ident_current('Trans_checkin_mas'),'I','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $guestcharge . "','" . $ChildRate . "','" . $_REQUEST['Adults'][$i] . "','" . User_id . "')";
				$Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
			}
		}

		
		$select ="select RoomNo from mas_room where Room_Id = '".$Room_id."'";

		$roomnumber = $this->db->query($select)->row_array();
	  
	  
		$otherDB = $this->load->database('another_db', TRUE);
	  
	  
		$selroom = "
		SELECT mc.ControlType_Id as control, md.Device
		FROM mas_control mc
		INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
		INNER JOIN mas_device md ON mc.Device = md.Device
		WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
		
		$result = $otherDB->query($selroom)->result_array();

		foreach($result as $res){
			$control = $res['control'];
			$Device = $res['Device'];
			
			$process = "select Status_Id from mas_status where upper(status) = 'CHECKIN'";
	  
			$process_id = $otherDB->query($process)->row_array();
	  
			
			 $ins9 = "
			INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
			VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$roomgrcid."','Reservation Checkin','" . $Indate . "',convert(VARCHAR,getdate(),108),'".$_REQUEST['Firstname']."','".$_REQUEST['Firstname']."','0')";
	  
		}
	  

	  
	  

		 $transactionBlock = "
		BEGIN TRY
			BEGIN TRANSACTION
			DECLARE @Siden INT;
			$ins6
			$ins4
			$ins9
			SET @Siden = @@IDENTITY;
			DECLARE @Siden1 INT;
			SET @Siden1 = @@IDENTITY;
			IF @@ERROR <> 0 
				ROLLBACK TRANSACTION 
			ELSE 
				COMMIT TRANSACTION
		END TRY
		BEGIN CATCH
			ROLLBACK TRANSACTION
			SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;
		END CATCH
		";
		
		 $result = $this->db->query($transactionBlock);
		$this->db->close();
		$this->db->reconnect();
		
		if ($result) {
			$roomtypeid  = '';
			$status = '';
			for ($i = 0; $i < $rowcount; $i++) {

			 if($roomtypeid  != $_REQUEST['roomtype'][$i]) 
			 {

			
				
			    $reschek ="select count(*) as count,noofrooms from temp_trans_reservecheckin_log where typeid='" . $_REQUEST['roomtype'][$i] . "' 
			and Resid='" . $_REQUEST['Resid'] . "'  group by noofrooms ";

			$reschecqry = $this->db->query($reschek)->result_array();
			$this->db->close();
			$this->db->reconnect();


			foreach($reschecqry as $reschk){
				$rescount = $reschk['count'];

				if ($rescount == $reschk['noofrooms']) {
					$status = 'Y';
				} else {
					$status = '';
				}
	
	
					$ins5 = $ins5. "update Trans_Reserve_det set stat='" . $status . "', checkinrooms=isnull(checkinrooms,0) +'" . $rescount . "'
				where resid=(select mas.Resid from Trans_Reserve_Mas mas 
				inner join Trans_Reserve_det det on mas.Resid=det.resid 
				where mas.ResNo='" . $_REQUEST['ResNo'] . "' and det.typeid='" . $_REQUEST['roomtype'][$i] . "') and typeid='" . $_REQUEST['roomtype'][$i] . "' ";
	
				$ins5 = $ins5 . "update Trans_Reserve_det1 set  noofrooms=isnull(noofrooms,0) - '" . $rescount  . "'
				where refresdetid=(select det.Resdetid from Trans_Reserve_Mas mas 
				inner join Trans_Reserve_det det on mas.Resid=det.resid 
				where mas.ResNo='" . $_REQUEST['ResNo'] . "' and det.typeid='" . $_REQUEST['roomtype'][$i] . "') and typeid='" . $_REQUEST['roomtype'][$i] . "' ";
				$resexe = $this->db->query($ins5);
				$this->db->close();
				$this->db->reconnect();
			}

			

			}
            $roomtypeid = $_REQUEST['roomtype'][$i];

		}	
            
		
			
	



			$sql7 = '';
			$grc = "select det.roomgrcid from Trans_Checkin_mas mas
			inner join Trans_Roomdet_det det on mas.grcid=det.grcid 
			where mas.Grcid=IDENT_CURRENT('Trans_checkin_mas') ";
			$exe = $this->db->query($grc);
			$this->db->close();
			$this->db->reconnect();
			// foreach ($exe->result_array() as $row) {
			// 	$grcid = $row['grcid'];
			// }
			$inss = "update Trans_receipt_mas set  roomgrcid='" . $roomgrcid . "'  
			where Billid=(select det.Billid from trans_reserveadd_mas mas 
				inner join Trans_receipt_mas det on mas.resaddid=det.billid 
				where mas.resno ='" . $_REQUEST['ResNo'] . "' )";
				
			$exec = $this->db->query($inss);
			$this->db->close();
			$this->db->reconnect();
			 $inss1 = "update  Trans_Advancereceipt_mas set roomgrcid='" . $roomgrcid . "', type='RMS' where 
			receiptid=(select mas.Receiptid from trans_receipt_mas mas 
			inner join Trans_Advancereceipt_mas det on mas.Receiptid = det.receiptid
			inner join trans_reserveadd_mas admas on mas.Billid=admas.resaddid 
			where admas.resno = '" . $_REQUEST['ResNo'] . "' ) ";
			
			$exc = $this->db->query($inss1);
			$this->db->close();
			$this->db->reconnect();
			for ($i = 0; $i < $rowcount; $i++) {
				$date = date('Y-m-d', strtotime($_REQUEST['Indate'][$i]));
				$sql7 = " exec Exec_Temp_Trans_credit_entry   '" . $_REQUEST['RoomNo'][$i] . "', '" . $date . "'";
				$res7 = $this->db->query($sql7);
				$this->db->close();
				$this->db->reconnect();
			}

			// echo $ins;
			if ($res7) {

				$check = "select tdet.fromdate, tdet.typeid, tdet.todate, mas.resid from Trans_reserve_mas mas 
				inner join Trans_reserve_det tdet on tdet.resid = mas.resid
				where mas.resid= IDENT_CURRENT('Trans_reserve_mas')"; 
	  $checkqry = $this->db->query($check);
	  foreach ($checkqry->result_array() as $ress) {
		  $cid = $ress['fromdate'];
		  $typeid = $ress['typeid'];
		  $expcdate = $ress['todate'];
		  $resid = $ress['resid'];
		  $aa_date = date_create($cid);
		  $l_date = date_create($expcdate);
		  $diff = date_diff($aa_date, $l_date);
		  $difference = $diff->format("%a");
		  for ($i = 0; $i <= $difference; $i++) {
			  $currentDate = date("Y-m-d", strtotime("+$i day", strtotime($cid)));
			  $val = "exec roomavailability_validation '" . $currentDate . "','" . $typeid . "'";
			  $validationResult = $this->db->query($val);
			  $this->db->close();
			  $this->db->reconnect();
			  if ($validationResult) {
				  $insR = "exec Update_RoomAvailability '" . $currentDate . "', '" . $typeid . "'";
				  $execute = $this->db->query($insR);
				  $this->db->close();
				  $this->db->reconnect();
			  }
		  }
	  }
			echo '<script>
			alert("Reservation Checkin Success");
			window.location.href = "' . scs_index . 'Transaction/ReservationCheckin";
		</script>';
		exit;


			}
		} else {
			echo "Error";
		}
	}



	public function Checkinsave_old231125()
	{
		date_default_timezone_set('Asia/Kolkata');


		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";

		$res = $this->db->query($sql);
		$newname = '';
		$path = '';
		$numberofrow = $res->num_rows();
		if ($numberofrow != 0) {
			foreach ($res->result_array() as $rows) {
				$newname = $rows['Photopath'];
			}
		}


		if ($_FILES["fileToUpload"]["tmp_name"][0] != '') {
			 $curmonth = date('M Y');
			 $curYear = date('Y');
			 $curDate = date('d-m-Y');
			 $hotel_id =  $_SESSION['Hotel_Id'];
			 $path = "GuestProof/".$hotel_id . "/" . $curYear . "/" . $curmonth . "/" . $curDate;
			$files = array_filter($_FILES['fileToUpload']['name']);
			$total_count = count($_FILES['fileToUpload']['name']);

			for ($i = 0; $i < $total_count; $i++) {
				$j = $i;
				$j++;
				$extension = explode(".", $_FILES["fileToUpload"]["name"][$i]);
				$newname = '' . $_REQUEST['Mobile'] . "_$j." . $extension[1];
			
				$desdirc = $path . "/" . $newname;
				if (!file_exists($path)) {

					mkdir($path, 0777, true);
				}


				if (!file_exists($desdirc)) {
					move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $desdirc);
				} else {
					move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $desdirc);
				}
			}
		}


		if ($numberofrow == 0) {
			   $qry = " exec Exec_RuningCustomercheckin '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Lastname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email_ID'] . "','" . $_REQUEST['Address1'] . "','" . $_REQUEST['Address2'] . "','" . $_REQUEST['City_id'] . "','" . $_REQUEST['State_id'] . "','" . $_REQUEST['Country_id'] . "','" . $_REQUEST['Middlename'] . "','" . @$_REQUEST['Company_Id'] . "','" . @$_REQUEST['Id_Documenttype'] . "','" . @$_REQUEST['Id_Documentno'] . "','SAVE', '" . @$path . "'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		} else {
			$qry = " exec Exec_RuningCustomercheckin '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Lastname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email_ID'] . "','" . $_REQUEST['Address1'] . "','" . $_REQUEST['Address2'] . "','" . $_REQUEST['City_id'] . "','" . $_REQUEST['State_id'] . "','" . $_REQUEST['Country_id'] . "','" . $_REQUEST['Middlename'] . "','" . @$_REQUEST['Company_Id'] . "','" . @$_REQUEST['Id_Documenttype'] . "','" . @$_REQUEST['Id_Documentno'] . "','UPDATE','" . @$path . "'";
			$resq = $this->db->query($qry);	
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
		}
		$sql7 = "select * from temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res7 = $this->db->query($sql7);
		foreach ($res7->result_array() as $row7) {
			$upqry = "Update Mas_Customer set HomeAddress1='" . $row7['HomeAddress1'] . "',HomeAddress2='" . $row7['HomeAddress2'] . "',HomeAddress3='" . $row7['HomeAddress3'] . "',Homepincode='" . $row7['Homepincode'] . "',Nationality='" . $row7['Nationality'] . "',ResidentialPhone='" . $row7['ResidentialPhone'] . "',WorkAddress1='" . $row7['WorkAddress1'] . "',
		WorkAddress2='" . $row7['WorkAddress2'] . "',WorkAddress3='" . $row7['WorkAddress3'] . "',Workpincode='" . $row7['Workpincode'] . "',WorkCityid='" . $row7['WorkCityid'] . "',WorPhone='" . $row7['WorPhone'] . "',gender='" . $row7['gender'] . "',Profession='" . $row7['Profession'] . "',Birthdate='" . $row7['Birthdate'] . "',Weddingdate='" . $row7['Weddingdate'] . "',
		Likes='" . $row7['Likes'] . "',Dislikes='" . $row7['Dislikes'] . "',Preffered_Room='" . $row7['Preffered_Room'] . "',Hotel_Commends='" . $row7['Hotel_Commends'] . "',passportno='" . $row7['passportno'] . "',Passport_issueplace='" . $row7['Passport_issueplace'] . "',Passport_issuedate='" . $row7['Passport_issuedate'] . "',Passport_Expirydate='" . $row7['Passport_Expirydate'] . "',VISA_No='" . $row7['VISA_No'] . "',
		VISA_Issueplace='" . $row7['VISA_Issueplace'] . "',VISA_Issuedate='" . $row7['VISA_Issuedate'] . "',VISA_Expirydate='" . $row7['VISA_Expirydate'] . "',Id_Documenttype='" . $row7['Id_Documenttype'] . "',Id_Documentno='" . $row7['Id_Documentno'] . "' where Mobile ='" . $row7['Mobile'] . "'";
			$res = $this->db->query($upqry);
		}
		$sql8 = "delete temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res8 = $this->db->query($sql8);

		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$ins4 = '';
		$Indate = str_replace('/', '-', $_REQUEST['Indate']);
		$Indate = date('Y/m/d', strtotime($Indate));
		$Indate1 = date('m/d/Y', strtotime($Indate));
		$todate = str_replace('/', '-', $_REQUEST['todate']);
		$todate = date('Y/m/d', strtotime($todate));
		$Company_Id = $_REQUEST['Company_Id'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}

		$ins = "Insert into Trans_Checkin_mas (Grcno,CheckinDate,CheckinTime,ExpDate,ExpTime,Noadults,Nochilds,NoofRooms,userid,yearPrefix)
			values(dbo.GrcNo(),'" . $Indate . "',convert(VARCHAR,getdate(),108),'" . $todate . "',convert(VARCHAR,getdate(),108),'" . $_REQUEST['Adults'] . "','" . $_REQUEST['Child'] . "','1','" . User_id . "',dbo.YearPrefix())";


		$sql2 = " SELECT isnull(max(roomgrcid),0) as roomgrcid FROM Trans_Roomdet_det";
		$res2 = $this->db->query($sql2);
		foreach ($res2->result_array() as $row2) {
			$roomgrcid = $row2['roomgrcid'] + 1;
		}
		$sql3 = "SELECT * FROM Mas_Room rm
		Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
		where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
		$res3 = $this->db->query($sql3);
		foreach ($res3->result_array() as $row3) {
			$Room_id = $row3['Room_Id'];
			$RoomType_Id = $row3['RoomType_Id'];
			$Adults = $row3['Adults'];
			$Extrabedamount = $row3['Extrabedamount'];
		}

		$sql4 = "SELECT * FROM temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "' and Rentdate=(select DateofAudit from Night_Audit)";
		$res4 = $this->db->query($sql4);



		foreach ($res4->result_array() as $row4) {
			if ($Adults >= $_REQUEST['Adults']) {
				$Extrabed = 0;
				$guestcharge = 0;
				if ($_REQUEST['Adults'] == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($_REQUEST['Adults'] == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($_REQUEST['Adults'] == 3) {
					if ($row4['Triplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($_REQUEST['Adults'] >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Quartertriplerent'];
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			} else {
				$Extrabed = $_REQUEST['Adults'] - $Adults;
				$guestcharge = $Extrabedamount;
				if ($Adults == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($Adults == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($Adults == 3) {
					if ($Adults == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($Adults >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Quartertriplerent'];
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			}
		}


		$Discamt = 0;

		$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
		$res5 = $this->db->query($sql5);

		foreach ($res5->result_array() as $row5) {
			$Taxid = $row5['Taxid'];
		}


		$sql12 = "exec Get_TaxSetup '" . $Taxid . "'";
		$res12 = $this->db->query($sql12);
		foreach ($res12->result_array() as $row12) {
			$CGST = $row12['CGST'];
		}
		$sql11 = "select NetTarriff,PubTarriff from Mas_Plantype where PlanType_Id='" . $_REQUEST['RateCode'] . "'";
		$res11 = $this->db->query($sql11);
		foreach ($res11->result_array() as $row11) {
			$NetTarriff = $row11['NetTarriff'];
		}
		if (@$NetTarriff == '1') {
			$PerRoomRent = ($RoomRent * (100 / (100 + $CGST + $CGST)));
		} else {
			$PerRoomRent = $RoomRent;
		}


		$ins1 = $ins1 . "INSERT INTO Trans_Roomdet_det (grcid,Roomid,Noofpersons,roomgrcid,typeid,roomrent,depdate,deptime,guestcharge,Extrabed,tarrifftypeid,ratetypeid,Actroomrent,userid,Actrackrate,taxid,Child,male,female,companyid,travelagentid,onlinebookingno,discper,discamount,planid,plancharges,billingaddresscompany)
			values(@Siden,'" . $_REQUEST['Roomid'] . "','" . $_REQUEST['Adults'] . "','" . $roomgrcid . "','" . $RoomType_Id . "','" . $PerRoomRent . "','" . $todate . "',convert(VARCHAR,getdate(),108),'" . $guestcharge . "','" . $Extrabed . "','" . $RoomType_Id . "','" . $_REQUEST['RateCode'] . "','" . $RoomRent . "','" . User_id . "','" . $actRoomRent . "','" . $Taxid . "','" . $_REQUEST['Child'] . "','" . $_REQUEST['male'] . "','" . $_REQUEST['female'] . "','" . $Company_Id . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . $_REQUEST['foodplan'] . "','0','" . $_REQUEST['companyaddress'] . "')";

		$ins2 = $ins2 . "Insert Into Trans_RoomCustomer_det (grcid,Grcroomdetid,Customerid)
			Values(@Siden,@Siden1,'" . $Customer_Id . "')";

		$sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "'";
		$res6 = $this->db->query($sql6);
		foreach ($res6->result_array() as $row6) {
			$singlerent = $row6['singlerent'];
			$Doublerent = $row6['Doublerent'];
			$Triplerent = $row6['Triplerent'];
			$Quartertriplerent = $row6['Quartertriplerent'];
			$ChildRate = $row6['extrachildcharges'];
			if ($ChildRate == '') {
				$ChildRate = 0;
			}
			$ins3 = $ins3 . "Insert into trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,roomgrcid,grcid,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,extrachildcharges,noofpersons,userid)
		values('" . $Indate . "','" . $_REQUEST['Roomid'] . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $roomgrcid . "',@Siden,'I','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $guestcharge . "','" . $ChildRate . "','" . $_REQUEST['Adults'] . "','" . User_id . "')";
			$Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
		}


		$setqry = "select enablepower from extraoption";

		$set = $this->db->query($setqry)->row_array();

		if($set['enablepower'] == 1) {

   $select ="select RoomNo from mas_room where Room_Id = '".$_REQUEST['Roomid']."'";

  $roomnumber = $this->db->query($select)->row_array();


  $otherDB = $this->load->database('another_db', TRUE);


  $selroom = "
  SELECT mc.ControlType_Id as control, md.Device
  FROM mpower_beehives.dbo.mas_control mc
  INNER JOIN mpower_beehives.dbo.mas_Room mr ON mr.Room_Id = mc.Room_Id
  INNER JOIN mpower_beehives.dbo.mas_device md ON mc.Device = md.Device
  WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
  
  $result = $otherDB->query($selroom)->result_array();

  foreach($result as $res) {

$control = $res['control'];
$Device = $res['Device'];


$process = "select Status_Id from mas_status where upper(status) = 'CHECKIN'";

$process_id = $otherDB->query($process)->row_array();

$today = date('Y-m-d');
$nowtime = date('H:i:s');



	$ins4 .= "
	INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
	VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$roomgrcid."','checkin','".$today."','".$nowtime."','".$_REQUEST['Firstname']."','".$_REQUEST['Firstname']."','0')";
	
  }
}


		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo "Declare @Siden1 INT; ";
		echo $ins1;
		echo "set @Siden1=@@identity; ";
		echo $ins2;
		echo $ins3;
		echo $ins4;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		  $sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {
	 	$sql7 = " exec Exec_Temp_Trans_credit_entry   '" . $_REQUEST['Roomid'] . "', '" . $_REQUEST['Indate'] . "'";
			$res7 = $this->db->query($sql7);
			

			$check = "select room.roomgrcid,mas.CheckinDate, room.typeid, mas.ExpDate from Trans_Checkin_mas mas 
			inner join Trans_Roomdet_det room on  room.grcid = mas.Grcid
			where mas.Grcid= IDENT_CURRENT('Trans_checkin_mas')";
			$checkqry = $this->db->query($check);
			foreach ($checkqry->result_array() as $ress) {
				
				$cid = $ress['CheckinDate'];
				$typeid = $ress['typeid'];
				$expcdate = $ress['ExpDate'];
				$roomgrcid = $ress['roomgrcid'];
			}

			
			$aa_date = date_create($cid); 
			$l_date = date_create($expcdate);
			$diff = date_diff($aa_date, $l_date);
			$difference = $diff->format("%a");

			for ($i = 0; $i <= $difference; $i++) {
			
				  $val = "exec roomavailability_validation '".$cid."','".$typeid."'";
				
				
				$validationResult = $this->db->query($val);
				$this->db->close();
				$this->db->reconnect();

			

					if($validationResult){
						$insav = "exec Update_RoomAvailability   '" . $cid . "', '" . $typeid . "'";
					
						$execute = $this->db->query($insav);
						$this->db->close();
						$this->db->reconnect();
					}
						
				
			
				$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
				
				
			}

			// $aa_date = date_create($cid); 
			// $l_date = date_create($expcdate);
			// $diff = date_diff($aa_date, $l_date);
			// $difference = $diff->format("%a");
			// for ($i = 0; $i <= $difference; $i++) {
				
         
			// $insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";


			// 	$execute = $this->db->query($insR);

			// 	$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));


			
			// }
			$check = "select isnull(enablewhatsappsmsforcheckin,0) as checkin from extraoption";
			$check = $this->db->query($check);
			foreach ($check->result_array() as $r) {
				$enableCheckin = $r['checkin'];
			}
			if ($enableCheckin == 1) {
				$qry = "select mh.Company as Com,mh.city as hotelcity,mh.mobileno as hmobile, mc.Company as travelagent,* from Trans_checkin_mas ch 
					inner join Trans_Roomdet_det roomdet on roomdet.grcid=ch.Grcid
					inner join Trans_RoomCustomer_det det on det.grcroomdetid = roomdet.Grcroomdetid
					inner join mas_customer cus on cus.Customer_Id = det.Customerid
					left outer join mas_title t on t.Titleid = cus.Titelid
					inner join Mas_room room on room.Room_Id=roomdet.Roomid
					inner join Mas_RoomType mr on mr.RoomType_Id= room.RoomType_Id
					inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
					left outer join mas_company mc on mc.Company_Id  = (select CompanyType_Id FROM mas_company where CompanyType_Id =roomdet.travelagentid )
					where ch.Grcid = IDENT_CURRENT('Trans_checkin_mas')";
				$result = $this->db->query($qry);

				foreach ($result->result_array() as $row1) {
					$firstname = $row1['Firstname'];
					$lastname = $row1['Lastname'];
					$title = $row1['Title'];
					$name = $title . '.' . $firstname . $lastname;
					$roomno = $row1['RoomNo'];
					$roomType = $row1['RoomType'];
					$rent = $row1['roomrent'];
					$company = $row1['Com'];
					$hcity = $row1['hotelcity'];
					$hmobile = $row1['hmobile'];
					$mobile = $row1['Mobile'];
					$checkindate = date('d-m-Y', strtotime(substr($row1['CheckinDate'], 0, 10)));
					$checkintime = new dateTime($row1['CheckinTime']);
					$checkintime = $checkintime->format('H:i');
					$expcheckoutdate = date('d-m-Y', strtotime(substr($row1['ExpDate'], 0, 10)));
					$expcheckouttime = new dateTime($row1['ExpTime']);
					$expcheckouttime = $expcheckouttime->format('H:i');
					$travelagent = "";
					if ($row1['travelagent'] != NULL) {
						$travelagent = $row1['travelagent'];
					}
				}
				$temqury = "select Template,campaign from mas_smsmessage where  isnull(CheckinGust,0)='1'";
				$smsTemp = $this->db->query($temqury);
				$i = 1;
				$detmsg = '';
				foreach ($smsTemp->result_array() as $row) {

					$msg = $row['Template'];
					$campaignname = $row['campaign'];
					$smstype = 'GCIN';

					$string = $msg;
					$strlen = strlen($string);
					$ii = 0;
					$count = 0;
					while ($ii < $strlen) {
						$newstr = '';
						if ($string[$ii] == '*') {
							$jj = $ii;
							while ($string[$jj + 1] != '*' && $jj < $strlen) {
								$newstr .= $string[$jj + 1];
								$jj++;
							}
							$ii = $jj + 1;
							$count = $count + 1;
							// insert query here..
							$newstrvalue = '';

							if ('RoomNo' == $newstr) {
								$newstrvalue = $roomno;
							} elseif ('RoomType' == $newstr) {
								$newstrvalue = $roomType;
							} else if ('RoomRent' == $newstr) {
								$newstrvalue = $rent;
							} else if ('GuestName' == $newstr) {
								$newstrvalue = $name;
							} else if ('CheckinDate' == $newstr) {
								$newstrvalue = $checkindate;
							} else if ('CompanyName' == $newstr) {
								$newstrvalue = $company;
							} elseif ('CheckinTime' == $newstr) {
								$newstrvalue = $checkintime;
							} elseif ('CheckoutDate' == $newstr) {
								$newstrvalue = $expcheckoutdate;
							} elseif ('CheckoutTime' == $newstr) {
								$newstrvalue = $expcheckouttime;
							} elseif ('TravelAgent' == $newstr) {
								$newstrvalue = $travelagent;
							} elseif ('ContactNo' == $newstr) {
								$newstrvalue = $hmobile;
							} elseif ('HotelName' == $newstr) {
								$newstrvalue = $company . ',' . $hcity;
							}
							$detmsg = $detmsg . "
				insert into Outbox_smsval(msgid,smstype,variablename,Variableval,Smsval)
				values(ident_current('outbox'),'" . $smstype . "','" . $newstr . "',
				'" . $count . "', '" . $newstrvalue . "')";

							// echo $count;
							// echo $newstr;
						}
						$ii++;
					}

					$detmsg = $detmsg . "
				insert into Outbox_smsval(msgid,smstype,variablename,Variableval,Smsval)
				values(ident_current('outbox'),'" . $smstype . "','poweredby',
				'" . $count . "', 'Powered By - Microgenn PMS')";

					$msg = str_replace('*GuestName*', $name, $msg);
					$msg = str_replace('*HotelName*', $company . '-' . $hcity, $msg);
					$msg = str_replace('*ContactNo*',  $hmobile, $msg);
					$msg = str_replace('*RoomNo*', $roomno, $msg);
					$msg = str_replace('*RoomType*', $roomType, $msg);
					$msg = str_replace('*RoomRent*', $rent, $msg);
					$msg = str_replace('*CompanyName*', $company, $msg);
					$msg = str_replace('*CheckinDate*', $checkindate, $msg);
					$msg = str_replace('*CheckinTime*', $checkintime, $msg);
					$msg = str_replace('*CheckoutDate*', $expcheckoutdate, $msg);
					$msg = str_replace('*CheckoutTime*', $expcheckouttime, $msg);
					$msg = str_replace('*TravelAgent*', $travelagent, $msg);

					$inss = "insert into outbox (MobileNumber,SMSMessage,DateCreated,campaign)
					values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20),'" . $campaignname . "')";
					$execins = $this->db->query($inss . $detmsg);
					$this->db->close();
					$this->db->reconnect();
				}
			}


			$sqlgrc = "select rs.roomgrcid from Trans_checkin_mas m 
					inner join room_status rs on rs.grcid = m.grcid 
					where m.grcid=IDENT_CURRENT('Trans_checkin_mas')";
			$resgrc = $this->db->query($sqlgrc);
			foreach ($resgrc->result_array() as $rowgrc) {
				echo $rowgrc['roomgrcid'];
			}
		} else {
			echo "Error";
		}
	}


	public function Checkinsave()
	{
	date_default_timezone_set('Asia/Kolkata');

	

		$mobile = $_REQUEST['Mobile'] ?? '';
		$sql = "SELECT * FROM Mas_Customer WHERE Mobile='$mobile'";
		$res = $this->db->query($sql);
		$numberofrow = ($res) ? $res->num_rows() : 0;
	
		$path = '';
		$newname = '';
	
		// 🔹 File upload handling
		if (!empty($_FILES["fileToUpload"]["tmp_name"][0])) {
			$curmonth = date('M Y');
			$curYear  = date('Y');
			$curDate  = date('d-m-Y');
			$hotel_id = $_SESSION['Hotel_Id'];
			$path = "GuestProof/$hotel_id/$curYear/$curmonth/$curDate";
			if (!file_exists($path)) mkdir($path, 0777, true);
	
			$files = array_filter($_FILES['fileToUpload']['name']);
			foreach ($files as $i => $fileName) {
				$extension = pathinfo($fileName, PATHINFO_EXTENSION);
				$newname = $mobile . "_" . ($i + 1) . "." . $extension;
				$desdirc = $path . "/" . $newname;
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $desdirc);
			}
		}
	
	
		$qryType = ($numberofrow == 0) ? 'SAVE' : 'UPDATE';
		$qry = sprintf(
			"EXEC Exec_RuningCustomercheckin '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'",
			$_REQUEST['Firstname'] ?? '',
			$_REQUEST['Lastname'] ?? '',
			$_REQUEST['Title'] ?? '',
			$mobile,
			$_REQUEST['Email_ID'] ?? '',
			$_REQUEST['Address1'] ?? '',
			$_REQUEST['Address2'] ?? '',
			$_REQUEST['City_id'] ?? 0,
			$_REQUEST['State_id'] ?? 0,
			$_REQUEST['Country_id'] ?? 0,
			$_REQUEST['Middlename'] ?? '',
			$_REQUEST['Company_Id'] ?? 0,
			$_REQUEST['Id_Documenttype'] ?? 0,
			$_REQUEST['Id_Documentno'] ?? '',
			$qryType,
			$path
		);
		$this->db->query($qry);
		$this->db->close();
		$this->db->reconnect();
	

		$sql1 = "SELECT TOP 1 Customer_Id FROM Mas_Customer WHERE Mobile='$mobile'";
		$res1 = $this->db->query($sql1);
		$Customer_Id = ($res1 && $res1->num_rows() > 0) ? $res1->row()->Customer_Id : 0;
	
	
		$Indate = date('Y/m/d', strtotime(str_replace('/', '-', $_REQUEST['Indate'] ?? date('Y-m-d'))));
		$Indate1 = date('m/d/Y', strtotime($Indate));
		$todate = date('Y/m/d', strtotime(str_replace('/', '-', $_REQUEST['todate'] ?? date('Y-m-d'))));
		$Company_Id = $_REQUEST['Company_Id'] ?? 0;
		$User_Id = User_id;
		$totalRooms = $_REQUEST['count'];
	
	
		$sqlBatch = "
		BEGIN TRY
			BEGIN TRANSACTION
			DECLARE @Siden INT;
			DECLARE @Siden1 INT;
		";
	

		if ($totalRooms > 1) {
			$groupCheckinResult = $this->db->query("SELECT ISNULL(MAX(GROUPCHECKIN), 0) + 1 AS NextGroup FROM Trans_Checkin_mas")->row();
			$nextGroupCheckin = intval($groupCheckinResult->NextGroup);
		} else {
			$nextGroupCheckin = 0;
		}

		$sqlBatch .= "
		INSERT INTO Trans_Checkin_mas 
		(Grcno, CheckinDate, CheckinTime, ExpDate, ExpTime, Noadults, Nochilds, NoofRooms, userid, yearPrefix, GROUPCHECKIN)
		VALUES (dbo.GrcNo(), '$Indate', CONVERT(VARCHAR, GETDATE(), 108), '$todate', CONVERT(VARCHAR, GETDATE(), 108),
				'1', '0', '$totalRooms', '$User_Id', dbo.YearPrefix(), '$nextGroupCheckin');
		SET @Siden = SCOPE_IDENTITY();
		";
	
	
		$res2 = $this->db->query("SELECT ISNULL(MAX(roomgrcid),0) AS roomgrcid FROM Trans_Roomdet_det");
		$lastRoomGrcId = ($res2 && $res2->num_rows() > 0) ? $res2->row()->roomgrcid : 0;
	
		$totadults = 0;
		$Extrabed = 0;
		$guestcharge = 0;
		
		for ($i = 1; $i <= $totalRooms; $i++) {
			$RoomId   = $_REQUEST["RoomNo_$i"] ?? 0;
			$Adults   = $_REQUEST["Adults_$i"] ?? 1;
			$Child    = $_REQUEST["child_$i"] ?? 0;
			$Male     = $_REQUEST["male_$i"] ?? 0;
			$Female   = $_REQUEST["female_$i"] ?? 0;
			$RateCode = $_REQUEST["RateCode_$i"] ?? 0;
			$FoodPlan = $_REQUEST["foodplan"] ?? 0;
			$DiscPer  = $_REQUEST["discper"] ?? 0;
			$DiscAmt  = $_REQUEST["discamt"] ?? 0;
			$CompanyAddress = $_REQUEST['companyaddress'] ?? '';
			$TravelAgentId = $_REQUEST['travelagent_Id'] ?? 0;
			$BookingId = $_REQUEST['bookingid'] ?? '';

			$nofadlts = $Male + $Female;

	
			if (!$RoomId) continue;
	
			$lastRoomGrcId++;
			$roomgrcid = $lastRoomGrcId;

$roomgrcidList[] = $roomgrcid;

$totadults += $Adults;
	
		
			$res3 = $this->db->query("
				SELECT rm.RoomType_Id, rt.Adults, rt.Extrabedamount
				FROM Mas_Room rm
				INNER JOIN Mas_Roomtype rt ON rt.RoomType_Id = rm.RoomType_Id
				WHERE rm.Room_id='$RoomId'
			");
			if (!$res3 || $res3->num_rows() == 0) continue;
			$r3 = $res3->row_array();
			$RoomType_Id = $r3['RoomType_Id'];
			$RoomCapacity = $r3['Adults'];
			$Extrabedamount = $r3['Extrabedamount'];

			$seroomtypeqry = "select RoomType from mas_roomtype where RoomType_Id = '".$RoomType_Id."'";

			$seroomtype = $this->db->query($seroomtypeqry)->row_array();
	
			
			$res4 = $this->db->query("
				SELECT TOP 1 * FROM temp_trans_roomdet_det_rent 
				WHERE roomid='$RoomId' AND Rentdate=(SELECT DateofAudit FROM Night_Audit)
			");
			if (!$res4 || $res4->num_rows() == 0) continue;
			$r4 = $res4->row_array();
		
		
			// $Extrabed = ($RoomCapacity >= $Adults) ? 0 : ($Adults - $RoomCapacity);
			// $GuestCharge = ($RoomCapacity >= $Adults) ? 0 : $Extrabedamount;

			// $Extrabed = $totadults - $Adults;
			// $GuestCharge = $Extrabedamount;

			$cap = $Adults - $RoomCapacity;
			if($cap > 0 )
			{
             $Extrabed =  $cap;
			 $GuestCharge = $Extrabedamount;
			} 
			else
			{
				$Extrabed =  0;
			    $GuestCharge = 0;
			}
	
			$RoomRent = $r4['Doublerent'] ?? 0;
			$actRoomRent = $r4['actdoublerent'] ?? 0;
			if ($Adults == 1) {
				$RoomRent = $r4['singlerent'];
				$actRoomRent = $r4['actsinglerent'];
			} elseif ($Adults == 3) {
				$RoomRent = ($r4['Triplerent'] > 0) ? $r4['Triplerent'] : $r4['Doublerent'];
				$actRoomRent = ($r4['acttriplerent'] > 0) ? $r4['acttriplerent'] : $r4['actdoublerent'];
			}
	
		
			$Discamt = 0;
			$sql5 = "SELECT dbo.Get_Taxid($RoomRent,$RoomRent,$RoomRent,$GuestCharge,$Discamt,'$Indate1') AS Taxid";
			$res5 = $this->db->query($sql5);
			$Taxid = ($res5 && $res5->num_rows() > 0) ? $res5->row()->Taxid : 0;
	
			$res12 = $this->db->query("EXEC Get_TaxSetup '$Taxid'");
			$CGST = ($res12 && $res12->num_rows() > 0) ? $res12->row()->CGST : 0;
	
			$res11 = $this->db->query("SELECT NetTarriff FROM Mas_Plantype WHERE PlanType_Id='$RateCode'");
			$NetTarriff = ($res11 && $res11->num_rows() > 0) ? $res11->row()->NetTarriff : 0;
	
			$PerRoomRent = ($NetTarriff == '1') ? ($RoomRent * (100 / (100 + $CGST + $CGST))) : $RoomRent;
	
			$sqlBatch .= "
				INSERT INTO Trans_Roomdet_det 
				(grcid, Roomid, Noofpersons, roomgrcid, typeid, roomrent, depdate, deptime, guestcharge, Extrabed, 
				 tarrifftypeid, ratetypeid, Actroomrent, userid, Actrackrate, taxid, Child, male, female, companyid, 
				 travelagentid, onlinebookingno, discper, discamount, planid, plancharges, billingaddresscompany, GROUPCHECKIN, GRPCHKID)
				VALUES (@Siden, '$RoomId', '$nofadlts', '$roomgrcid', '$RoomType_Id', '$PerRoomRent', '$todate', CONVERT(VARCHAR,GETDATE(),108),
						'$GuestCharge', '$Extrabed', '$RoomType_Id', '$RateCode', '$RoomRent', '$User_Id', '$actRoomRent', '$Taxid', 
						'$Child', '$Male', '$Female', '$Company_Id', '$TravelAgentId', '$BookingId', '$DiscPer', '$DiscAmt', 
						'$FoodPlan', '0', '$CompanyAddress', '$nextGroupCheckin', @Siden);
				SET @Siden1 = SCOPE_IDENTITY();
	
				INSERT INTO Trans_RoomCustomer_det (grcid, Grcroomdetid, Customerid)
				VALUES (@Siden, @Siden1, '$Customer_Id');
			";
	
			
			$res6 = $this->db->query("SELECT * FROM temp_trans_roomdet_det_rent WHERE roomid='$RoomId'");
			if ($res6 && $res6->num_rows() > 0) {
				foreach ($res6->result_array() as $r6) {
					$ChildRate = $r6['extrachildcharges'] ?? 0;
					$sqlBatch .= "
						INSERT INTO trans_roomdet_det_rent 
						(Rentdate, roomid, singlerent, Doublerent, Triplerent, Quartertriplerent, roomgrcid, grcid, checkinrenttype, 
						actsinglerent, actdoublerent, acttriplerent, actquartertriplerent, extraadultcharges, extrachildcharges, 
						noofpersons, userid)
						VALUES ('{$r6['Rentdate']}', '{$r6['roomid']}', '{$r6['singlerent']}', '{$r6['Doublerent']}', '{$r6['Triplerent']}', 
								'{$r6['Quartertriplerent']}', '$roomgrcid', @Siden, 'I', 
								'{$r6['actsinglerent']}', '{$r6['actdoublerent']}', '{$r6['acttriplerent']}', '{$r6['actquartertriplerent']}', 
								'$GuestCharge', '$ChildRate', '$Adults', '$User_Id');
					";
				}
			}

			$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

			$set = $this->db->query($setqry)->row_array();

			if($set['Enablebeehivesroominventoryintergration'] == 1) {

				$select ="select RoomNo from mas_room where Room_Id = '".$RoomId."'"; 

			$roomnum = $this->db->query($select)->row_array();

			 $sqlBatch .= "INSERT INTO trans_roomstatus_det
			(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,updateflg)
			VALUES
			('".$roomnum['RoomNo']."','".$RoomId."','".$RoomType_Id."',@Siden,'".$roomgrcid."','".$seroomtype['RoomType']."','".$Indate."',convert(VARCHAR,getdate(),108),'".$todate."',convert(VARCHAR,getdate(),108),'CHECKIN','0'); ";

			}

	
			
// ------Power----

			$setqry = "select enablepower from extraoption";

		$set = $this->db->query($setqry)->row_array();

		if($set['enablepower'] == 1) {

   $select ="select RoomNo from mas_room where Room_Id = '".$RoomId."'";

  $roomnumber = $this->db->query($select)->row_array();


  $otherDB = $this->load->database('another_db', TRUE);


  $selroom = "
  SELECT mc.ControlType_Id as control, md.Device
  FROM mpower_beehives.dbo.mas_control mc
  INNER JOIN mpower_beehives.dbo.mas_Room mr ON mr.Room_Id = mc.Room_Id
  INNER JOIN mpower_beehives.dbo.mas_device md ON mc.Device = md.Device
  WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
  
  $result = $otherDB->query($selroom)->result_array();

  foreach($result as $res) {

$control = $res['control'];
$Device = $res['Device'];


$process = "select Status_Id from mas_status where upper(status) = 'CHECKIN'";

$process_id = $otherDB->query($process)->row_array();

$today = date('Y-m-d');
$nowtime = date('H:i:s');


	$sqlBatch .= "
	INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
	VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$roomgrcid."','checkin','".$today."','".$nowtime."','".$_REQUEST['Firstname']."','".$_REQUEST['Firstname']."','0')";


	
  }


	 $sqlBatch .= "update room_status set Pwcleaning = 0 , Pwvisiting = 0 , Pwmaintenance = 0,Pwondate = NULL,Pwoffdate = NULL,Pwontime = NULL,Pwofftime = NULL WHERE Roomid = '".$RoomId."' ";
}

// ------Power----


		}

		
	

		$sqlBatch .= "
		IF @@ERROR <> 0 ROLLBACK TRANSACTION 
		ELSE COMMIT TRANSACTION
		END TRY
		BEGIN CATCH
			ROLLBACK TRANSACTION
			SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;
		END CATCH;
		";
	
		$result = $this->db->query($sqlBatch);
		$this->db->close();
		$this->db->reconnect();
	
		if ($result) {
	
			
			for ($i = 1; $i <= $totalRooms; $i++) {
				$Roomnos = $_REQUEST["RoomNo_$i"];
				$IndateRoom = $_REQUEST['Indate'];

				$sqlExec = "EXEC Exec_Temp_Trans_credit_entry '$Roomnos', '$IndateRoom'";
	
		
				$res = @$this->db->simple_query($sqlExec);
			}


			$processedTypeIds = [];
			for ($i = 1; $i <= $totalRooms; $i++) {
				$RoomId = $_REQUEST["RoomNo_$i"];
				if ($RoomId == 0) continue;
	
				$roid = "SELECT RoomType_Id FROM mas_room WHERE Room_Id = '$RoomId'";
				$typeQry = $this->db->query($roid);
				$typeRow = $typeQry->row_array();
	
				if ($typeRow) {
					$typeid = $typeRow['RoomType_Id'];
					if (!in_array($typeid, $processedTypeIds)) {
						$processedTypeIds[] = $typeid;
	
						$cid = $_REQUEST['Indate'];
						$expcdate = $_REQUEST['Outdate'] ?? $cid;
	
						$aa_date = date_create($cid);
						$l_date = date_create($expcdate);
						$diff = date_diff($aa_date, $l_date);
						$difference = $diff->format("%a");
	
						$currentDate = $cid;
						for ($d = 0; $d <= $difference; $d++) {
							$insav = "EXEC Update_RoomAvailability '$currentDate', '$typeid'";
							$this->db->query($insav);
							$currentDate = date("Y-m-d", strtotime('+1 day', strtotime($currentDate)));
						}
					}
				}
			}
	
			echo json_encode([
				'status' => 'success',
				'roomgrcids' => $roomgrcidList
			]);
		} else {
			echo "Error during check-in";
		}
	}
	
	

	public function ReserveAmendmentsave()
	{

		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuningCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Lastname'] . "','1','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email_ID'] . "','" . $_REQUEST['City_id'] . "','" . $_REQUEST['State_id'] . "','" . $_REQUEST['Country_id'] . "','" . $_REQUEST['Middlename'] . "'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
		}
		$sql7 = "select * from temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res7 = $this->db->query($sql7);
		foreach ($res7->result_array() as $row7) {
			$upqry = "Update Mas_Customer set HomeAddress1='" . $row7['HomeAddress1'] . "',HomeAddress2='" . $row7['HomeAddress2'] . "',HomeAddress3='" . $row7['HomeAddress3'] . "',Homepincode='" . $row7['Homepincode'] . "',Nationality='" . $row7['Nationality'] . "',ResidentialPhone='" . $row7['ResidentialPhone'] . "',WorkAddress1='" . $row7['WorkAddress1'] . "',
		  WorkAddress2='" . $row7['WorkAddress2'] . "',WorkAddress3='" . $row7['WorkAddress3'] . "',Workpincode='" . $row7['Workpincode'] . "',WorkCityid='" . $row7['WorkCityid'] . "',WorPhone='" . $row7['WorPhone'] . "',gender='" . $row7['gender'] . "',Profession='" . $row7['Profession'] . "',Birthdate='" . $row7['Birthdate'] . "',Weddingdate='" . $row7['Weddingdate'] . "',
		  Likes='" . $row7['Likes'] . "',Dislikes='" . $row7['Dislikes'] . "',Preffered_Room='" . $row7['Preffered_Room'] . "',Hotel_Commends='" . $row7['Hotel_Commends'] . "',passportno='" . $row7['passportno'] . "',Passport_issueplace='" . $row7['Passport_issueplace'] . "',Passport_issuedate='" . $row7['Passport_issuedate'] . "',Passport_Expirydate='" . $row7['Passport_Expirydate'] . "',VISA_No='" . $row7['VISA_No'] . "',
		  VISA_Issueplace='" . $row7['VISA_Issueplace'] . "',VISA_Issuedate='" . $row7['VISA_Issuedate'] . "',VISA_Expirydate='" . $row7['VISA_Expirydate'] . "',Id_Documenttype='" . $row7['Id_Documenttype'] . "',Id_Documentno='" . $row7['Id_Documentno'] . "' where Mobile ='" . $row7['Mobile'] . "'";
			$res = $this->db->query($upqry);
		}
		$sql8 = "delete temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res8 = $this->db->query($sql8);
		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$Indate = str_replace('/', '-', $_REQUEST['Indate']);
		$Indate = date('Y/m/d', strtotime($Indate));
		$Indate1 = date('m/d/Y', strtotime($Indate));
		$todate = str_replace('/', '-', $_REQUEST['todate']);
		$todate = date('Y/m/d', strtotime($todate));
		$Company_Id = $_REQUEST['Company_Id'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}
		$sql3 = "SELECT * FROM Mas_Room rm
		  Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
		  where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
		$res3 = $this->db->query($sql3);
		foreach ($res3->result_array() as $row3) {
			$Room_id = $row3['Room_Id'];
			$RoomType_Id = $row3['RoomType_Id'];
			$Adults = $row3['Adults'];
			$Extrabedamount = $row3['Extrabedamount'];
		}
		$sql4 = "SELECT * FROM temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "'";
		$res4 = $this->db->query($sql4);
		foreach ($res4->result_array() as $row4) {
			if ($Adults >= $_REQUEST['Adults']) {
				$Extrabed = 0;
				$guestcharge = 0;
				if ($_REQUEST['Adults'] == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($_REQUEST['Adults'] == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($_REQUEST['Adults'] == 3) {
					if ($row4['Triplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($_REQUEST['Adults'] >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			} else {
				$Extrabed = $_REQUEST['Adults'] - $Adults;
				$guestcharge = $Extrabedamount;
				if ($Adults == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($Adults == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($Adults == 3) {
					if ($Adults == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($Adults >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Quartertriplerent'];
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			}
		}
		$ins = "Update Trans_reserve_mas set Reserveby='" . User_id . "',Communicate='P',cusid='" . $Customer_Id . "',totamt='" . $RoomRent . "',totrooms='1',stat='',userid='" . User_id . "',waitlist=0,duedate='" . $date . "',
		travelagentid='" . $_REQUEST['travelagent_Id'] . "',onlinebookingno='" . $_REQUEST['bookingid'] . "',totalrent='" . $RoomRent . "',age='',discper='" . $_REQUEST['discper'] . "',discount='" . $_REQUEST['discamt'] . "',muserid='" . User_id . "',Roomid='" . $_REQUEST['Roomid'] . "' where resid='" . $_REQUEST['Resid'] . "'";


		$sql2 = " SELECT max(roomgrcid) as roomgrcid FROM Trans_Roomdet_det";
		$res2 = $this->db->query($sql2);
		foreach ($res2->result_array() as $row2) {
			$roomgrcid = $row2['roomgrcid'] + 1;
		}


		$Discamt = 0;
		$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
		$res5 = $this->db->query($sql5);
		foreach ($res5->result_array() as $row5) {
			$Taxid = $row5['Taxid'];
		}


		$ins1 = $ins1 . "Update Trans_reserve_det set fromdate='" . $Indate . "',noofrooms='1',noofpax='" . $_REQUEST['Adults'] . "',resid='" . $_REQUEST['Resid'] . "',fromtime=convert(VARCHAR,getdate(),108),totime=convert(VARCHAR,getdate(),108),todate='" . $todate . "',advance='0',payid='0',typeid='" . $RoomType_Id . "',
		tarifftype='" . $RoomType_Id . "',ratetypeid='" . $_REQUEST['RateCode'] . "',planid='" . $_REQUEST['foodplan'] . "',plancharges='0',plandisc='0.00',roomrent='" . $RoomRent . "',totalroomrent='" . $RoomRent . "',taxid='" . $Taxid . "',actpax='" . $Adults . "' where resid='" . $_REQUEST['Resid'] . "'";
		$fromdate = $Indate;
		$sql6 = "select * from Trans_reserve_det1 where refresdetid='" . $_REQUEST['ResDetid'] . "'";
		$res6 = $this->db->query($sql6);
		foreach ($res6->result_array() as $row6) {
			$ins3 = $ins3 . "Update Trans_reserve_det1 set resdate='" . $Indate . "',typeid='" . $RoomType_Id . "',noofrooms='1',fromtime=convert(VARCHAR,getdate(),108),totime=convert(VARCHAR,getdate(),108),
		 	  fromdate='" . $Indate . "',todate='" . $Indate . "',ratetypeid='" . $_REQUEST['RateCode'] . "'  where reservedetid='" . $row6['reservedetid'] . "'";
			$Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
		}

		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo "Declare @Siden1 INT; ";
		echo $ins1;
		echo "set @Siden1=@@identity; ";
		echo $ins3;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {
			echo "Sucess";
		} else {
			echo "Error";
		}
	}
	public function Reservesave()
	{

		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuningCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Lastname'] . "','1','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email_ID'] . "','" . $_REQUEST['City_id'] . "','" . $_REQUEST['State_id'] . "','" . $_REQUEST['Country_id'] . "','" . $_REQUEST['Middlename'] . "'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
		}
		$sql7 = "select * from temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res7 = $this->db->query($sql7);
		foreach ($res7->result_array() as $row7) {
			$upqry = "Update Mas_Customer set HomeAddress1='" . $row7['HomeAddress1'] . "',HomeAddress2='" . $row7['HomeAddress2'] . "',HomeAddress3='" . $row7['HomeAddress3'] . "',Homepincode='" . $row7['Homepincode'] . "',Nationality='" . $row7['Nationality'] . "',ResidentialPhone='" . $row7['ResidentialPhone'] . "',WorkAddress1='" . $row7['WorkAddress1'] . "',
		WorkAddress2='" . $row7['WorkAddress2'] . "',WorkAddress3='" . $row7['WorkAddress3'] . "',Workpincode='" . $row7['Workpincode'] . "',WorkCityid='" . $row7['WorkCityid'] . "',WorPhone='" . $row7['WorPhone'] . "',gender='" . $row7['gender'] . "',Profession='" . $row7['Profession'] . "',Birthdate='" . $row7['Birthdate'] . "',Weddingdate='" . $row7['Weddingdate'] . "',
		Likes='" . $row7['Likes'] . "',Dislikes='" . $row7['Dislikes'] . "',Preffered_Room='" . $row7['Preffered_Room'] . "',Hotel_Commends='" . $row7['Hotel_Commends'] . "',passportno='" . $row7['passportno'] . "',Passport_issueplace='" . $row7['Passport_issueplace'] . "',Passport_issuedate='" . $row7['Passport_issuedate'] . "',Passport_Expirydate='" . $row7['Passport_Expirydate'] . "',VISA_No='" . $row7['VISA_No'] . "',
		VISA_Issueplace='" . $row7['VISA_Issueplace'] . "',VISA_Issuedate='" . $row7['VISA_Issuedate'] . "',VISA_Expirydate='" . $row7['VISA_Expirydate'] . "',Id_Documenttype='" . $row7['Id_Documenttype'] . "',Id_Documentno='" . $row7['Id_Documentno'] . "' where Mobile ='" . $row7['Mobile'] . "'";
			$res = $this->db->query($upqry);
		}
		$sql8 = "delete temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res8 = $this->db->query($sql8);

		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$Indate = str_replace('/', '-', $_REQUEST['Indate']);
		$Indate = date('Y/m/d', strtotime($Indate));
		$Indate1 = date('m/d/Y', strtotime($Indate));
		$todate = str_replace('/', '-', $_REQUEST['todate']);
		$todate = date('Y/m/d', strtotime($todate));
		$Company_Id = $_REQUEST['Company_Id'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}
		$sql3 = "SELECT * FROM Mas_Room rm
		Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
		where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
		$res3 = $this->db->query($sql3);
		foreach ($res3->result_array() as $row3) {
			$Room_id = $row3['Room_Id'];
			$RoomType_Id = $row3['RoomType_Id'];
			$Adults = $row3['Adults'];
			$Extrabedamount = $row3['Extrabedamount'];
		}
		$sql4 = "SELECT * FROM temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "'";
		$res4 = $this->db->query($sql4);
		foreach ($res4->result_array() as $row4) {
			if ($Adults >= $_REQUEST['Adults']) {
				$Extrabed = 0;
				$guestcharge = 0;
				if ($_REQUEST['Adults'] == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($_REQUEST['Adults'] == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($_REQUEST['Adults'] == 3) {
					if ($row4['Triplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($_REQUEST['Adults'] >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			} else {
				$Extrabed = $_REQUEST['Adults'] - $Adults;
				$guestcharge = $Extrabedamount;
				if ($Adults == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($Adults == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($Adults == 3) {
					if ($Adults == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($Adults >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Quartertriplerent'];
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			}
		}
		$ins = "Insert into Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totamt,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,totalrent,age,discper,discount,muserid,Roomid,isconfirm)
	       values(dbo.ResNo(),'" . User_id . "','P','" . $date . "','" . $Customer_Id . "','" . $RoomRent . "','1','','" . User_id . "','0','" . $date . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','" . $RoomRent . "','','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . User_id . "','" . $_REQUEST['Roomid'] . "',1)";
		//$ins="Insert into Trans_Checkin_mas (Grcno,CheckinDate,CheckinTime,ExpDate,ExpTime,Noadults,Nochilds,NoofRooms,userid)
		//	values(dbo.GrcNo(),'".$Indate."',convert(VARCHAR,getdate(),108),'".$todate."',convert(VARCHAR,getdate(),108),'".$_REQUEST['Adults']."','".$_REQUEST['Child']."','1','".User_id."')";


		$sql2 = " SELECT max(roomgrcid) as roomgrcid FROM Trans_Roomdet_det";
		$res2 = $this->db->query($sql2);
		foreach ($res2->result_array() as $row2) {
			$roomgrcid = $row2['roomgrcid'] + 1;
		}


		$Discamt = 0;
		$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
		$res5 = $this->db->query($sql5);
		foreach ($res5->result_array() as $row5) {
			$Taxid = $row5['Taxid'];
		}


		$ins1 = $ins1 . "Insert into Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
			values('" . $Indate . "','1','" . $_REQUEST['Adults'] . "',@Siden,convert(VARCHAR,getdate(),108),convert(VARCHAR,getdate(),108),'" . $todate . "','0','0','" . $RoomType_Id . "','" . $RoomType_Id . "','" . $_REQUEST['RateCode'] . "','" . $_REQUEST['foodplan'] . "','0','0.00','" . $RoomRent . "','" . $RoomRent . "','" . $Taxid . "','" . $Adults . "')";
		$fromdate = $Indate;
		$sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "'";
		$res6 = $this->db->query($sql6);
		foreach ($res6->result_array() as $row6) {
			$singlerent = $row6['singlerent'];
			$Doublerent = $row6['Doublerent'];
			$Triplerent = $row6['Triplerent'];
			$Quartertriplerent = $row6['Quartertriplerent'];
			$ChildRate = $row6['extrachildcharges'];
			if ($ChildRate == '') {
				$ChildRate = 0;
			}
			$ins3 = $ins3 . "	Insert into Trans_reserve_det1(resdate,typeid,noofrooms,fromtime,totime,refresdetid,fromdate,todate,ratetypeid)
		values('" . $Indate . "','" . $RoomType_Id . "','1',convert(VARCHAR,getdate(),108),convert(VARCHAR,getdate(),108),@Siden1,'" . $fromdate . "','" . $todate . "','" . $_REQUEST['RateCode'] . "')";
			$Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
		}

		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo "Declare @Siden1 INT; ";
		echo $ins1;
		echo "set @Siden1=@@identity; ";
		echo $ins3;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {

			$qry = "select mh.Company as Com,* from trans_reserve_mas rmas 
					inner join Trans_reserve_det rdet on rdet.resid=rmas.Resid
					inner join mas_customer cus on cus.Customer_Id = rmas.cusid
					inner join mas_title t on t.Titleid = cus.Titelid
					inner join Mas_room room on room.Room_Id=rmas.Roomid
					inner join Mas_RoomType mr on mr.RoomType_Id= room.RoomType_Id
					inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
					where rmas.Resid=IDENT_CURRENT('Trans_reserve_mas')";

			$result = $this->db->query($qry);
			foreach ($result->result_array() as $row1) {
				$firstname = $row1['Firstname'];
				$lastname = $row1['Lastname'];
				$title = $row1['Title'];
				$name = $title . '.' . $firstname . $lastname;
				$roomno = $row1['RoomNo'];
				$roomType = $row1['RoomType'];
				$rent = $row1['roomrent'];
				$company = $row1['Com'];
				$mobile = $row1['Mobile'];
				$resno = $row1['ResNo'];
				$resdate = date('d-m-Y', strtotime(substr($row1['Resdate'], 0, 10)));
			}

			$temqury = "select Template from mas_smsmessage where  isnull(reserveGuest,0)='1'";
			$smsTemp = $this->db->query($temqury);
			foreach ($smsTemp->result_array() as $row) {
				$msg = $row['Template'];
				$msg = str_replace('*CutomerName*', $name, $msg);
				$msg = str_replace('*RoomNo*', $roomno, $msg);
				$msg = str_replace('*RoomType*', $roomType, $msg);
				$msg = str_replace('*RoomRent*', $rent, $msg);
				$msg = str_replace('*CompanyName*', $company, $msg);
				$msg = str_replace('*ResNo*', $resno, $msg);
				$msg = str_replace('*Reserve Date*', $resdate, $msg);

				$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
			values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20))";
				$execins = $this->db->query($ins);
			}
			$temquy = "select Template from mas_smsmessage where  isnull(reserveMD,0)='1'";
			$smTemp = $this->db->query($temquy);
			foreach ($smTemp->result_array() as $ro) {
				$msgg = $ro['Template'];
				$msgg = str_replace('*CutomerName*', $name, $msgg);
				$msgg = str_replace('*RoomNo*', $roomno, $msgg);
				$msgg = str_replace('*RoomType*', $roomType, $msgg);
				$msgg = str_replace('*RoomRent*', $rent, $msgg);
				$msgg = str_replace('*ResNo*', $resno, $msgg);
				$msgg = str_replace('*Reserve Date*', $resdate, $msgg);

				$sle = "select * from mas_smsusers where usertype='500'";
				$exe = $this->db->query($sle);
				foreach ($exe->result_array() as $CMD) {
					$mdmobile = $CMD['mobileno'];
					$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
					values('" . $mdmobile . "','" . $msgg . "',convert(VARCHAR,getdate(),20)roomtypeguestadults)";
					$execins = $this->db->query($ins);
				}
			}
			echo "Sucess";
		} else {
			echo "Error";
		}
	}
	public function PostRent_Val()
	{
		$this->load->model('Transaction/PostRent');
		$this->PostRent->PostRent_Val();
	}
	public function roomtypegetroomnumber()
	{
		$sql = "select * from Mas_RoomType rt
		inner join Mas_Room rm on rm.RoomType_Id=rt.RoomType_Id
		where rt.RoomType_Id=" . $_REQUEST['type'];
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $rows) {
			echo "<option value=" . $rows['Room_Id'] . ">" . $rows['RoomNo'] . "</option>";
		}
	}
	public function roomtypegetPlanid()
	{
		$sql = "Select * from Mas_RoomType rt
		Inner join Mas_RatePlan RP on RP.RoomType_Id=rt.RoomType_Id
		Inner join Mas_PlanType PT on PT.PlanType_Id=RP.PlanType_Id
		where rt.RoomType_Id=" . $_REQUEST['type'];
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $rows) {
			echo "<option value=" . $rows['PlanType_Id'] . ">" . $rows['RateCode'] . "</option>";
		}
	}

	
	public function roomtypegettariff()
	{
		$sql = "Select * from Mas_RoomType rt
		Inner join Mas_RatePlan RP on RP.RoomType_Id=rt.RoomType_Id
		Inner join Mas_PlanType PT on PT.PlanType_Id=RP.PlanType_Id
		inner join Mas_RatePlan_Det RPD on RPD.RatePlan_Id=RP.RatePlan_Id
		where rt.RoomType_Id='" . $_REQUEST['type'] . "' and PT.PlanType_Id = '" . $_REQUEST['plantype'] . "'
		 AND RPD.FromDate <= '" . $_REQUEST['Arrivaldate'] . "' AND RPD.ToDate >= '" . $_REQUEST['Arrivaldate'] . "'
	
	";

	

	// AND RPD.FromDate <= '" . $_REQUEST['Arrivaldate'] . "' AND RPD.ToDate >='" . $_REQUEST['Departuredate'] . "'
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $rows) {
			if ($_REQUEST['pax'] <= $rows['Adults']) {
				if ($_REQUEST['pax'] == 1) {
					echo $rows['Single'];
				}
				if ($_REQUEST['pax'] == 2) {
					echo $rows['Doubles'];
				}
				if ($_REQUEST['pax'] == 3) {
					if ($rows['Triple'] == 0) {
						echo $rows['Doubles'];
					} else {
						echo $rows['Triple'];
					}
				}
				if ($_REQUEST['pax'] >= 4) {
					if ($rows['Quadruple'] == 0) {
						echo $rows['Doubles'];
					} else {
						echo $rows['Quadruple'];
					}
				}
			} else {
				$Extrabed = $_REQUEST['pax'] - $rows['Adults'];
				$guestcharge = $rows['Extrabedamount'];
				$Currentpax = $_REQUEST['pax'] - $Extrabed;
				if ($Currentpax == 1) {
					echo $rows['Single'];
				}
				if ($Currentpax == 2) {
					echo $rows['Doubles'] + $guestcharge;
				}
				if ($Currentpax == 3) {
					if ($rows['Triple'] == 0) {
						echo $rows['Doubles'] + $guestcharge;
					} else {
						echo $rows['Triple'] + $guestcharge;
					}
				}
				if ($Currentpax >= 4) {
					if ($rows['Quadruple'] == 0) {
						echo $rows['Doubles'] + $guestcharge;
					} else {
						echo $rows['Quadruple'] + $guestcharge;
					}
				}
			}
		}
	}


	public function roomtypegettariff_amendment()
	{
		$sql = "Select * from Mas_RoomType rt
		Inner join Mas_RatePlan RP on RP.RoomType_Id=rt.RoomType_Id
		Inner join Mas_PlanType PT on PT.PlanType_Id=RP.PlanType_Id
		inner join Mas_RatePlan_Det RPD on RPD.RatePlan_Id=RP.RatePlan_Id
		where rt.RoomType_Id='" . $_REQUEST['type'] . "' and PT.PlanType_Id = '" . $_REQUEST['plantype'] . "'
		
	
	";

	
	// AND RPD.FromDate <= '" . $_REQUEST['Arrivaldate'] . "' AND RPD.ToDate >='" . $_REQUEST['Departuredate'] . "'
	// AND RPD.FromDate <= '" . $_REQUEST['Arrivaldate'] . "' AND RPD.ToDate >='" . $_REQUEST['Departuredate'] . "'
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $rows) {
			if ($_REQUEST['pax'] <= $rows['Adults']) {
				if ($_REQUEST['pax'] == 1) {
					echo $rows['Single'];
				}
				if ($_REQUEST['pax'] == 2) {
					echo $rows['Doubles'];
				}
				if ($_REQUEST['pax'] == 3) {
					if ($rows['Triple'] == 0) {
						echo $rows['Doubles'];
					} else {
						echo $rows['Triple'];
					}
				}
				if ($_REQUEST['pax'] >= 4) {
					if ($rows['Quadruple'] == 0) {
						echo $rows['Doubles'];
					} else {
						echo $rows['Quadruple'];
					}
				}
			} else {
				$Extrabed = $_REQUEST['pax'] - $rows['Adults'];
				$guestcharge = $rows['Extrabedamount'];
				$Currentpax = $_REQUEST['pax'] - $Extrabed;
				if ($Currentpax == 1) {
					echo $rows['Single'];
				}
				if ($Currentpax == 2) {
					echo $rows['Doubles'] + $guestcharge;
				}
				if ($Currentpax == 3) {
					if ($rows['Triple'] == 0) {
						echo $rows['Doubles'] + $guestcharge;
					} else {
						echo $rows['Triple'] + $guestcharge;
					}
				}
				if ($Currentpax >= 4) {
					if ($rows['Quadruple'] == 0) {
						echo $rows['Doubles'] + $guestcharge;
					} else {
						echo $rows['Quadruple'] + $guestcharge;
					}
				}
			}
		}
	}

	public function roomtypegetadults()
	{
		$totalpax = 0;
		$sql = "select (Adults+Extrabedcount) as Totalcount from Mas_RoomType where RoomType_Id=" . $_REQUEST['type'];
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $rows) {
			$totalpax = $rows['Totalcount'];
		}
		for ($i = 0; $i <= $totalpax; $i++) {
			echo '<option  values=' . $i . '>' . $i . '</option>';
		}
	}

	public function rackRate()
	{
		/*$qry = "select * from Mas_PlanType mp inner join 
		Mas_RatePlan mr on mr.PlanType_Id = mp.PlanType_Id
		inner join Mas_RatePlan_Det md on md.RatePlan_Id = mr.RatePlan_Id
		inner join mas_roomType mroom on mroom.RoomType_Id = mr.RoomType_Id
		inner join mas_room  mas on mas.RoomType_Id = mr.RoomType_Id
		where mp.PlanType_Id= '".$_REQUEST['planid']."' and mas.Room_Id='".$_REQUEST['roomid']."'";*/

		//Ravi Changed to give Temporty solutions 10-03-2023
		$qry = "select * from Trans_Roomdet_det_rent Where Roomgrcid='" . $_REQUEST['roomgrcid'] . "'  and Rentdate=(select DateofAudit from Night_Audit)";
		$ex = $this->db->query($qry);

		foreach ($ex->result_array() as $roww) {
			// echo	$transup = "update Trans_roomdet_det_rent set singlerent='".$roww['Single']."', Doublerent='".$roww['Doubles']."',Triplerent='".$roww['Triple']."',
			// 	 actsinglerent='".$roww['Single']."',Quartertriplerent='".$roww['Quadruple']."',
			// 	 actdoublerent='".$roww['Doubles']."', acttriplerent='".$roww['Triple']."', 
			// 	 actquartertriplerent='".$roww['Quadruple']."', extraadultcharges='".$roww['Extrabedamount']."', 
			// 	 noofpersons='".$_REQUEST['pax']."' where roomid='".$_REQUEST['roomid']."' ";
			// 	 $exec = $this->db->query($transup);

			if ($_REQUEST['pax'] == 1) {
				$data['Actrackrate'] = $roww['singlerent'];
				$data['Extrabedamount'] = 0.00;
			} else if ($_REQUEST['pax'] == 2) {
				$data['Actrackrate'] = $roww['Doublerent'];
				$data['Extrabedamount'] = 0.00;
			} else if ($_REQUEST['pax'] == 3) {
				$data['Actrackrate'] = $roww['Triplerent'];
				$data['Extrabedamount'] = 0.00;
			} else if ($_REQUEST['pax'] >= 4) {
				if ($roww['Quartertriplerent'] == 0) {
					$data['Actrackrate'] = $roww['Triple'] + $roww['extraadultcharges'];
					$data['Extrabedamount'] = $roww['extraadultcharges'];
				} else {
					$data['Actrackrate'] = $roww['Quartertriplerent'];
				}
			}
			$roww_set[] = $data;
		}
		echo json_encode($roww_set);
	}

	public function GetCancelReservationGuestDetails()
	{
		$sql = " 	select mt.Title+'.'+cus.Firstname as Name,sum(mas.advamount) as Amount from trans_reservecancel_mas mas
		Inner join Trans_Reserve_mas rmas on rmas.Resid=mas.reserveid
		Inner join Mas_Customer cus on cus.Customer_Id=rmas.cusid
		 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
		 where rmas.resid='" . $_REQUEST['Resid'] . "'
		 Group By  mt.Title+'.'+cus.Firstname ";
		$res = $this->db->query($sql);
		foreach ($res->result() as $row) {
			$data['Name'] = $row->Name;
			$data['Amount'] = $row->Amount;
			$row_set[] = $data;
		}
		echo json_encode($row_set);
	}


public function Otheroption() {

    $banks = $this->Myclass->Bank_other(); 

    $options = '<option value="">--Bank--</option>';
    foreach ($banks as $bank) {
        $options .= '<option value="' . $bank['Bankid'] . '">' . $bank['bank'] . '</option>';
    }

    echo $options;
}

	public function UpiOptions()
	{
		$sql = "select * from mas_bank where isnull(isupi,0)<>0";
		$ex = $this->db->query($sql);

		echo '<option value="">--Bank--</option>';

		foreach ($ex->result_array() as $row) {

			echo '<option value="' . $row['Bankid'] . '"	 >' . $row['bank'] . '</option>';
		}
	}

	public function CompanyOptions()
	{
		$sql = "select mc.Company,Mc.Company_Id from mas_company mc
		inner join Mas_CompanyType mct on mc.CompanyType_Id=mct.CompanyType_Id
		where isnull(mc.inactive,'') <> 1";
		$ex = $this->db->query($sql);

		echo '<option value="0">--Bank--</option>';

		foreach ($ex->result_array() as $row) {

			echo '<option value="' . $row['Company_Id'] . '"	 >' . $row['Company'] . '</option>';
		}
	}
	public function UpiOptionSettle()
	{
		$sql = "select * from mas_bank where isnull(isupi,0)<>0";
		$ex = $this->db->query($sql);

		echo '<option value="0"	>--Bank--</option>';
		foreach ($ex->result_array() as $row) {

			echo '<option value="' . $row['Bankid'] . '"	 >' . $row['bank'] . '</option>';
		}
	}

	public function CompanyModeSettle()
	{

		$sql = "select mc.Company as bank,Mc.Company_Id as Bankid from mas_company mc
		inner join Mas_CompanyType mct on mc.CompanyType_Id=mct.CompanyType_Id
		where mct.CompanyType <> 'Travel Agent'";
		$ex = $this->db->query($sql);
	?>
		<select name="bank[]" class="scs-ctrl" id="bank_1">
			<option value="">--Company--</option>
			<?php
			foreach ($ex->result_array() as $row) {
			?>
				<option <?php if ($_REQUEST['id'] = $row['Bankid']) {
							echo "selected";
						} ?> value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank'] ?></option>
			<?php
			}
			?>
		</select>
	<?php
	}


	public function Upioption()
	{
		$sql = "select * from mas_bank where isnull(isupi,0)<>0";
		$ex = $this->db->query($sql);
	?>
		<select name="bank[]" class="m-ctrl" id="bank">
			<option value="">--Bank--</option>
			<?php
			foreach ($ex->result_array() as $row) {
				echo '<option value="' . $row['Bankid'] . '"	 >' . $row['bank'] . '</option>';
			}
			?>
		</select>
		<?php

	}


	public function CompanyModeSettleCredit()
	{

		$sql = "select * from mas_bank where isnull(isupi, 0) <>1";
		$ex = $this->db->query($sql);

		echo '<option value="">--Bank--</option>';
		foreach ($ex->result_array() as $row) {
		?>
			<option value="<?php echo $row["Bankid"] ?>"><?php echo $row["bank"] ?></option>
		<?php }

		echo '</select>';
	}



	public function CompanyModeSettleCreditt()
	{

		$sql = "select * from mas_bank where isnull(isupi, 0) <>1";
		$ex = $this->db->query($sql);

		echo '<option value="">--Bank--</option>';
		foreach ($ex->result_array() as $row) {
		?>
			<option value="<?php echo $row["Bankid"] ?>"><?php echo $row["bank"] ?></option>
		<?php }

		echo '</select>';
	}

	public function GetReservationGuestDetails()
	{
		$sql = " select mt.Title+'.'+cus.Firstname as Name, isnull(sum(rtmas.Amount),0) as Amount from Trans_Reserve_mas mas 
		Inner join Mas_Customer cus on cus.Customer_Id=mas.cusid
		inner join Trans_Reserve_Det  det on det.resid = mas.resid
		 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
		left outer join trans_reserveadd_mas rmas on rmas.resid=mas.resid
		left outer join Trans_Receipt_mas rtmas on rtmas.Billid=rmas.resaddid and rtmas.ReceiptType = 'A'
		where mas.resid='" . $_REQUEST['Resid'] . "' and isnull(rtmas.cancel,0)=0 
		Group By  mt.Title+'.'+cus.Firstname ";
		$res = $this->db->query($sql);
		foreach ($res->result() as $row) {
			$data['Name'] = $row->Name;
			$data['Amount'] = $row->Amount;
			$row_set[] = $data;
		}
		echo json_encode($row_set);
	}

public function Collection_Val()
{

	date_default_timezone_set('Asia/Kolkata');

    $date = date('Y-m-d');

    // Insert into Trans_BillPay_Mas first and run immediately
    $ins = "insert into Trans_BillPay_Mas (Creditno,Creditdate,SettleorCollection,ReciptNo,Customerid,userid,iselite,Updatetrans)
            values(dbo.ColNO(),'" . $date . "','C',dbo.ColNO(),'" . $_REQUEST['Companyid'] . "','" . User_id . "','0','1')";
    $this->db->query($ins);

    // Get last inserted Creditid
    $credit_id_row = $this->db->query("SELECT ident_current('Trans_BillPay_Mas') AS Creditid")->row();
    $credit_id = $credit_id_row->Creditid ?? null;
    if (!$credit_id) {
        echo "failed to get credit id";
        return;
    }

    // Insert each payment detail separately
    for ($i = 0; $i < $_REQUEST['counts']; $i++) {
        $paymode = $_REQUEST['paymode'][$i] ?? '';

        $sql = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = '" . $paymode . "'";
        $paymode_row = $this->db->query($sql)->row_array();
        $pay = $paymode_row['PayMode_Id'] ?? null;

        if (isset($_REQUEST['Amtt'][$i]) && $pay !== null) {
            $bank = $_REQUEST['bank'][$i] ?? '';
            $cardno = $_REQUEST['cardno'][$i] ?? '';
            $validate = $_REQUEST['validate'][$i] ?? '';
            $checkoutid = $_REQUEST['checkoutid'][$i] ?? '';

            $ins_det = "insert into Trans_Billpay_det (Paymodeid, Bankid, Amount, Cardname, Creditid, Updatetrans, Validdate, checkoutid)
                        values ('$pay', '$bank', '" . $_REQUEST['Amtt'][$i] . "', '$cardno', '$credit_id', '1', '$validate', '$checkoutid')";

            $this->db->query($ins_det);
        }
    }

    // Insert and update for each bill separately
    for ($i = 0; $i < $_REQUEST['countrow']; $i++) {
        $bal = $_REQUEST['Billamount'][$i] - ($_REQUEST['Amt'][$i] ?? 0);
        $paid = $_REQUEST['Paidamount'][$i] + ($_REQUEST['Amt'][$i] ?? 0);

        $ins_bill_det = "insert into Trans_Bill_Det (Checkoutid, Creditid, Billno, Billdate, Billamount, Balamount, Paidamount)
                         values ('" . $_REQUEST['checkoutid'][$i] . "', '$credit_id', '" . $_REQUEST['Billno'][$i] . "', '" . $_REQUEST['checkoutdate'][$i] . "',
                         '" . $_REQUEST['Billamount'][$i] . "', '$bal', '" . ($_REQUEST['Amt'][$i] ?? 0) . "')";

        $this->db->query($ins_bill_det);

        $upd_pay_det = "update trans_pay_det set paidamount = '$paid' where Checkoutid = '" . $_REQUEST['checkoutid'][$i] . "'";
        $this->db->query($upd_pay_det);
    }

    echo "success";
}


	public function Walkoutsave()
	{

		date_default_timezone_set('Asia/Kolkata');

		$sql = "exec Exec_Walkout_Save '" . $_REQUEST['Room_id'] . "','" . date("Y-m-d") . "','" . User_id . "'";
		$res = $this->db->query($sql);

		$qry = "select mh.Company as Com, * from Trans_checkout_mas cm
		inner join Trans_checkin_mas ch on ch.Grcid=cm.grcid
		inner join Trans_RoomCustomer_det det on det.grcid = ch.Grcid
		inner join mas_customer cus on cus.Customer_Id = det.Customerid
		inner join mas_title t on t.Titleid = cus.Titelid
		inner join Trans_Roomdet_det roomdet on roomdet.grcid=ch.Grcid
		inner join Mas_room room on room.Room_Id=roomdet.Roomid
		inner join Mas_RoomType mr on mr.RoomType_Id= room.RoomType_Id
		inner join Trans_checkout_mas outm on outm.grcid = ch.Grcid
		inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
		where cm.Checkoutid = IDENT_CURRENT('Trans_checkout_mas')";
		$result = $this->db->query($qry);
		foreach ($result->result_array() as $row1) {
			$firstname = $row1['Firstname'];
			$lastname = $row1['Lastname'];
			$title = $row1['Title'];
			$name = $title . '.' . $firstname . $lastname;
			$roomno = $row1['RoomNo'];
			$roomType = $row1['RoomType'];
			$rent = $row1['roomrent'];
			$company = $row1['Com'];
			$mobile = $row1['Mobile'];
			$checkintime = new dateTime($row1['CheckinTime']);
			$checkintime = $checkintime->format('H:i');
			$resno = $row1['Grcno'];
			$checkindate = date('Y-m-d', strtotime(substr($row1['CheckinDate'], 0, 10)));
			$billamount = $row1['totalamount'];
			$checkoutdate = date('Y-m-d', strtotime(substr($row1['Checkoutdate'], 0, 10)));
		}

		$temqury = "select Template from mas_smsmessage where  isnull(CheckoutGuest,0)='1'";
		$smsTemp = $this->db->query($temqury);
		foreach ($smsTemp->result_array() as $row) {
			$msg = $row['Template'];
			$msg = str_replace('*CutomerName*', $name, $msg);
			$msg = str_replace('*RoomNo*', $roomno, $msg);
			$msg = str_replace('*RoomType*', $roomType, $msg);
			$msg = str_replace('*RoomRent*', $rent, $msg);
			$msg = str_replace('*CompanyName*', $company, $msg);
			$msg = str_replace('*CheckiIntime*', $checkintime, $msg);
			$msg = str_replace('*ResNo*', $resno, $msg);
			$msg = str_replace('*Reserve Date*', $checkindate, $msg);
			$msg = str_replace('*Checkout Date*', $checkoutdate, $msg);
			$msg = str_replace('*Bill Amount*', $billamount, $msg);

			$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
			values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20))";
			$execins = $this->db->query($ins);
		}
		$temquy = "select Template from mas_smsmessage where  isnull(CheckoutMD,0)='1'";
		$smTemp = $this->db->query($temquy);
		foreach ($smTemp->result_array() as $ro) {
			$msgg = $ro['Template'];
			$msgg = str_replace('*CutomerName*', $name, $msgg);
			$msgg = str_replace('*RoomNo*', $roomno, $msgg);
			$msgg = str_replace('*RoomType*', $roomType, $msgg);
			$msgg = str_replace('*RoomRent*', $rent, $msgg);
			$msgg = str_replace('*CheckiIntime*', $checkintime, $msgg);
			$msgg = str_replace('*ResNo*', $resno, $msgg);
			$msgg = str_replace('*Reserve Date*', $checkindate, $msgg);
			$msgg = str_replace('*Checkout Date*', $checkoutdate, $msgg);
			$msgg = str_replace('*Bill Amount*', $billamount, $msgg);

			$sle = "select * from mas_smsusers where usertype='500'";
			$exe = $this->db->query($sle);
			foreach ($exe->result_array() as $CMD) {
				$mdmobile = $CMD['mobileno'];
				$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
					values('" . $mdmobile . "','" . $msgg . "',convert(VARCHAR,getdate(),20))";
				$execins = $this->db->query($ins);
			}
		}
		$sq = "SELECT IDENT_CURRENT('Trans_checkout_mas') id";
		$result = $this->db->query($sq);
		foreach ($result->result() as $row) {
			echo $row->id;;
		}
	}


	// Code changes by prakash on 01-05-2025
	public function Reservation_save()
	{

       date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuninggCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email'] . "','" . $_REQUEST['City_id'] . "', 'SAVE'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
			$cus = "update Mas_Customer set Firstname = '" . $_REQUEST['Firstname'] . "', Mobile='" . $_REQUEST['Mobile'] . "', Email_ID='" . $_REQUEST['Email'] . "', Cityid='" . $_REQUEST['City_id'] . "', Titelid='" . $_REQUEST['Title'] . "' where Customer_Id = '" . $Customer_Id . "'";
			$cuss = $this->db->query($cus);
		}

		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$ins = "Insert into Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,age,discper,discount,muserid,company,yearprefix,isconfirm)
	  values(dbo.ResNo(),'" . User_id . "','P','" . $date . "','" . $Customer_Id . "','" . $_REQUEST['roomcount'] . "','','" . User_id . "','" . $_REQUEST['ReservationMode'] . "','" . $_REQUEST['duedate'] . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . User_id . "',
	   '" . $_REQUEST['CompanyId'] . "',dbo.YearPrefix(),1)";

	   
		$EXE = $this->db->query($ins);
		$rowcount = $_REQUEST['rowcount'];

		for ($i = 0; $i < $rowcount; $i++) {
			$Indate = str_replace('/', '-', $_REQUEST['Indate'][$i]);
			$Indate = date('Y/m/d', strtotime($Indate));
			$Indatee = date('Y/m/d', strtotime($Indate));
			$Indate1 = date('m/d/Y', strtotime($Indate));
			$todate = str_replace('/', '-', $_REQUEST['todate'][$i]);
			$todate = date('Y/m/d', strtotime($todate));
			$Company_Id = $_REQUEST['CompanyId'];
			if ($Company_Id == '') {
				$Company_Id = 0;
			}
			$ARRtimee = $_REQUEST['FHr'][$i] . ':' . $_REQUEST['FMi'][$i];
			$Deptimee = $_REQUEST['THr'][$i] . ':' . $_REQUEST['TMi'][$i];

			 $delete = "Delete temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomtype_id'][$i] . "'";

			 $this->db->query($delete);

		


		    $sql6 = "select * From mas_rateplan_det rtpdet
                    inner join mas_rateplan rtmas on rtmas.rateplan_id = rtpdet.rateplan_id
                    inner join mas_plantype pltype on pltype.PlanType_Id = rtmas.PlanType_Id 
                    inner join Mas_RoomType rt on rt.RoomType_Id = rtmas.roomtype_id 
                    left outer join mas_foodplan fp on fp.foodplan_id = rtpdet.foodplan_id
                    where rt.roomtype_id = '".$_REQUEST['Roomtype_id'][$i]."' and pltype.PlanType_Id = '" . $_REQUEST['RateCode'][$i] . "' ";  

				$res6 = $this->db->query($sql6);
				$data = $res6->result();
				while ($Indatee <= $todate) {
	            
				foreach ($res6->result_array() as $row6) {
					$roomTypeId = $row6['RoomType_Id'];
					$Adults = $row6['Adults'];
					$Extrabedcount = $row6['AdultRate'];
					$singlerent = $row6['Single'];
					$Doublerent = $row6['Doubles'];
					$Triplerent = $row6['Triple'];
					$Quartertriplerent = $row6['Quadruple'];
					 $ins3 = "Insert into temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
			  values('" . $Indatee . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','R','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $row6['Extrabedamount'] . "','" . User_id . "',dbo.GrcNo(),'" . Hotel_Id . "')";
					$result = $this->db->query($ins3);
				}
				$Indatee = date("Y/m/d", strtotime("+1 day", strtotime($Indatee)));
			
			}

			$guestcharge = 0;
			// $roomTypeId = $_REQUEST['Roomtype_id'][$i] ?? null;

			// Commented by Deepan 

			// if ($roomTypeId) {
			// 	 $sql3 = "SELECT * FROM Mas_Room rm
			// 	 INNER JOIN Mas_Roomtype rt ON rt.RoomType_Id = rm.RoomType_Id
			// 	 WHERE rm.RoomType_Id = ?";
			// 	$res3 = $this->db->query($sql3, array($roomTypeId));
			// 	$row3 = $res3->row_array();
			// 	if (!empty($row3)) {
			// 	 	$Room_id = $row3['Room_Id'];
			// 		$Adults = $row3['Adults'];
			// 		$Extrabedamount = $row3['Extrabedamount'];
			// 	}

			// 	if ($Adults < $_REQUEST['Adults'][$i]) {
			// 		$guestcharge = $Extrabedamount;
			// 	}
			// }

			$RoomRent = $_REQUEST['Tariff'][$i] ?? 0;
			$Discamt = 0;
			$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
			$res5 = $this->db->query($sql5);
			foreach ($res5->result_array() as $row5) {
				$Taxid = $row5['Taxid'];
			}

			$ins1 = $ins1 . "Insert into Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
			values(CONVERT(VARCHAR, '" . $_REQUEST['Indate'][$i] . "', 103),'" . $_REQUEST['noofrooms'][$i] . "','" . $_REQUEST['Adults'][$i] . "',ident_current('Trans_reserve_mas'),
			convert(VARCHAR,'" . $ARRtimee . "',108),convert(VARCHAR,'" . $Deptimee . "',108),CONVERT(VARCHAR, '" . $_REQUEST['todate'][$i] . "', 103),'0','0',
			'" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['RateCode'][$i] . "','" . $_REQUEST['foodplan'][$i] . "',
			'0','0.00','" . $RoomRent . "','" . $RoomRent . "','" . $Taxid . "','" . $_REQUEST['Adults'][$i] . "')";

			if ($_REQUEST['flag'] == 1) {
				$check = "select isnull(checkinrooms,0) as checkinroom, isnull(cancelrooms,0) as cancel,
				* from Trans_reserveenquiry_det where resenqdetid='" . $_REQUEST['Enqdetresid'][$i] . "'";
				$exec = $this->db->query($check);
				$status = '';
				foreach ($exec->result_array() as $check) {
					$resdetid = $check['resenqdetid'];
					$checkinrooms = $check['checkinroom'];
					// echo $checkinrooms = settype($checkinrooms, 'int');
					//  $cancelrooms = $check['cancel'];
					// echo $cancelrooms = settype($cancelrooms, 'int');
					//  echo$noof = $check['noofrooms'];
					$totalcount = $check['noofrooms'] - $check['checkinroom'] - $check['cancel'] - $_REQUEST['noofrooms'][$i];
					if ($totalcount <= 0) {
						$status = 'Y';
					}
				}
				$sql = "update trans_reserveenquiry_det set checkinrooms='" . $_REQUEST['noofrooms'][$i] . "' , stat='" . $status . "' where resenqdetid='" . $_REQUEST['Enqdetresid'][$i] . "'";
				$exe = $this->db->query($sql);
				$sql1 = "update trans_reserveenquiry_mas set stat='Y' where Resenqid='" . $_REQUEST['Enqresid'][$i] . "'";
				$res = $this->db->query($sql1);
			}

			$fromdate = $Indate;
		   $sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $roomTypeId . "'";
			$res6 = $this->db->query($sql6);
	
			$currentDate = date("Y/m/d", strtotime($Indate));
$todate = date("Y/m/d", strtotime($todate));

// Fetch rents just once if needed
$row6 = $res6->row_array(); // If you expect only one row
$singlerent = $row6['singlerent'];
$Doublerent = $row6['Doublerent'];
$Triplerent = $row6['Triplerent'];
$Quartertriplerent = $row6['Quartertriplerent'];
$ChildRate = $row6['extrachildcharges'] ?: 0;

// Calculate number of days
$startDateObj = date_create($Indate);
$endDateObj = date_create($todate);
$interval = date_diff($startDateObj, $endDateObj);
$totalDays = $interval->format("%a");

for ($d = 0; $d <= $totalDays; $d++) {
    $nextDate = date("Y/m/d", strtotime("+$d day", strtotime($Indate)));

    if ($d == 0) {
        $fromTime = $ARRtimee;
        $toTime = "23:59";
    } elseif ($d == $totalDays) {
        $fromTime = "00:00";
        $toTime = $Deptimee;
    } else {
        $fromTime = "00:00";
        $toTime = "23:59";
    }

    $ins1 .= "INSERT INTO Trans_reserve_det1 (resdate, typeid, noofrooms, fromtime, totime, refresdetid, fromdate, todate, ratetypeid) 
    VALUES (
        '$nextDate',
        '" . $_REQUEST['Roomtype_id'][$i] . "',
        '" . $_REQUEST['noofrooms'][$i] . "',
        convert(VARCHAR,'$fromTime',108),
        convert(VARCHAR,'$toTime',108),
        IDENT_CURRENT('Trans_reserve_det'),
        '$currentDate',
        '$todate',
        '" . $_REQUEST['RateCode'][$i] . "'
    );";
}
			

 


		}

		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		// echo $ins;
		echo "set @Siden=@@identity; ";
		echo "Declare @Siden1 INT; ";
		echo $ins1;
		echo "set @Siden1=@@identity; ";
		echo $ins2;
		echo $ins3;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
	

		// $result = $this->db->query($ins1);
		// $this->db->close();
		// $this->db->reconnect();
		if ($result) {

			$check = "select isnull(enablewhatsappsmsforres,0) as res from extraoption";
			$check = $this->db->query($check);
			foreach ($check->result_array() as $r) {
				$enableRes = $r['res'];
			}
			if ($enableRes == 1) {
				$sql = "select det.roomrent,mas.resno,mas.resdate,mr.roomtype,mt.title+'.'+mc.Firstname+' '+mc.Lastname as guestname,
					mc.mobile as mob,( select company from mas_hotel where hotel_id='" . Hotel_Id . "') as companyname,
					mh.address as haddress,mh.mobileno as hmobile,mh.Pincode as pin, mh.address1 as haddress1,* from trans_reserve_mas mas
					inner join trans_reserve_det det on mas.Resid = det.resid
					inner join Mas_RoomType mr on mr.roomtype_id=det.typeid
					inner join mas_customer mc on mc.Customer_Id = mas.cusid
					inner join mas_title mt on mt.Titleid = mc.Titelid
					inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
					where mas.resid=ident_current('trans_reserve_mas')";
				$res = $this->db->query($sql);
				$roomrent = '';
				$roomtype = '';
				$resno = '';
				$name = '';
				$resdate = '';
				$formatter = ' , ';
				$noofadults = '';
				$noofrooms = '';
				$fromdate = '';
				$time = '';
				$todate = '';
				$count = 1;
				foreach ($res->result_array() as $row) {
					if ($count > 1) {

						$roomtype .= $formatter . $row['roomtype'];
						$roomrent .= $formatter . $row['roomrent'];
						$noofadults .= $formatter . $row['noofpax'];
						$noofrooms .= $formatter . $row['noofrooms'];
						$time .= $formatter . date('H:i', strtotime($row['fromtime']));
						$fromdate .= $formatter . date('d-m-Y', strtotime($row['fromdate']));
						$todate .= $formatter . date('d-m-Y', strtotime($row['todate']));
					} else {
						$roomrent = $row['roomrent'];
						$roomtype = $row['roomtype'];
						$resno = $row['resno'];
						$name = $row['guestname'];
						$mobile = $row['mob'];
						$company = $row['companyname'];
						$resdate = date('d-m-Y', strtotime($row['resdate']));
						$haddress = $row['haddress'];
						$hmobile = $row['hmobile'];
						$hpincode = $row['haddress1'] . '-' . $row['pin'];
						$noofadults = $row['noofpax'];
						$noofrooms = $row['noofrooms'];
						$time = date('H:i', strtotime($row['fromtime']));
						$fromdate = date('d-m-Y', strtotime($row['fromdate']));
						$todate = date('d-m-Y', strtotime($row['todate']));
					}

					$count++;
				}


				$temqury = "select Template,campaign from mas_smsmessage where  isnull(reserveGuest,0)='1'";
				$smsTemp = $this->db->query($temqury);
				$i = 1;
				$detmsg = '';
				foreach ($smsTemp->result_array() as $row) {

					$msg = $row['Template'];
					$smstype = 'GCRE';
					$campaignname = $row['campaign'];
					$string = $msg;
					$strlen = strlen($string);
					$ii = 0;
					$count = 0;
					while ($ii < $strlen) {
						$newstr = '';
						if ($string[$ii] == '*') {
							$jj = $ii;
							while ($string[$jj + 1] != '*' && $jj < $strlen) {
								$newstr .= $string[$jj + 1];
								$jj++;
							}
							$ii = $jj + 1;
							$count = $count + 1;
							// insert query here..
							$newstrvalue = '';

							if ('CustomerName' == $newstr) {
								$newstrvalue = $name;
							} elseif ('RoomType' == $newstr) {
								$newstrvalue = $roomtype;
							} else if ('noofrooms' == $newstr) {
								$newstrvalue = $noofrooms;
							} else if ('ResNo' == $newstr) {
								$newstrvalue = $resno;
							} elseif ('Reserve Date' == $newstr) {
								$newstrvalue = $resdate;
							} elseif ('noofpersons' == $newstr) {
								$newstrvalue = $noofadults;
							} elseif ('fromdate' == $newstr) {
								$newstrvalue = $fromdate;
							} elseif ('todate' == $newstr) {
								$newstrvalue = $todate;
							} elseif ('time' == $newstr) {
								$newstrvalue = $time;
							} elseif ('HotelAddress' == $newstr) {
								$newstrvalue = $haddress;
							} elseif ('HotelPinCode' == $newstr) {
								$newstrvalue = $hpincode;
							} elseif ('ContactNo' == $newstr) {
								$newstrvalue = $hmobile;
							}

							$detmsg = $detmsg . "
						insert into Outbox_smsval(msgid,smstype,variablename,Variableval,Smsval)
						values(ident_current('outbox'),'" . $smstype . "','" . $newstr . "',
						'" . $count . "', '" . $newstrvalue . "')";

							// echo $count;
							// echo $newstr;
						}
						$ii++;
					}

					$msg = str_replace('*CustomerName*', $name, $msg);
					$msg = str_replace('*RoomType*', $roomtype, $msg);
					$msg = str_replace('*ResNo*', $resno, $msg);
					$msg = str_replace('*Reserve Date*', $resdate, $msg);
					$msg = str_replace('*noofpersons*', $noofadults, $msg);
					$msg = str_replace('*noofrooms*', $noofrooms, $msg);
					$msg = str_replace('*fromdate*', $fromdate, $msg);
					$msg = str_replace('*todate*', $todate, $msg);
					$msg = str_replace('*time*', $time, $msg);
					$msg = str_replace('*HotelAddress*', $haddress, $msg);
					$msg = str_replace('*ContactNo*', $hmobile, $msg);
					$msg = str_replace('*HotelPinCode*', $hpincode, $msg);


					$inss = "insert into outbox (MobileNumber,SMSMessage,DateCreated,campaign)
					values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20),'" . $campaignname . "')";
					$execins = $this->db->query($inss . $detmsg);

					
					$this->db->close();
					$this->db->reconnect();
				}

			}

			
			// 	   $check = "select tdet.fromdate, tdet.typeid, tdet.todate,mas.resid from Trans_reserve_mas mas 
			// 		inner join Trans_reserve_det tdet on tdet.resdetid = mas.resid
			// 		where mas.resid= IDENT_CURRENT('Trans_reserve_det')";
			// $checkqry = $this->db->query($check);
			// foreach ($checkqry->result_array() as $ress) {
			// 	$cid = $ress['fromdate'];
			// 	$typeid = $ress['typeid'];
			// 	$expcdate = $ress['todate'];
			// 	$resid = $ress['resid'];
			// }


			

			// $aa_date = date_create($cid); 
			// $l_date = date_create($expcdate);
			// $diff = date_diff($aa_date, $l_date);
			// $difference = $diff->format("%a");

			// for ($i = 0; $i <= $difference; $i++) {
			
			// 	 $val = "exec roomavailability_validation '".$cid."','".$typeid."','".$resid."'";
				
				
			// 	$validationResult = $this->db->query($val);
			// 	$this->db->close();
			// 	$this->db->reconnect();
				

	
			// 	if ($validationResult) {
				
			// 		 $insR = "exec Update_RoomAvailability   '" . $cid . "', '" . $typeid . "'";
					
			// 		$execute = $this->db->query($insR);
					
			// 	$this->db->close();
			// 	$this->db->reconnect();
			// 	}
				
			
			// 	$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
			
				
			// }

			$check = "select tdet.fromdate, tdet.typeid, tdet.todate, mas.resid from Trans_reserve_mas mas 
			inner join Trans_reserve_det tdet on tdet.resid = mas.resid
			where mas.resid= IDENT_CURRENT('Trans_reserve_mas')"; 
  $checkqry = $this->db->query($check);
  foreach ($checkqry->result_array() as $ress) {
	  $cid = $ress['fromdate'];
	  $typeid = $ress['typeid'];
	  $expcdate = $ress['todate'];
	  $resid = $ress['resid'];
	  $aa_date = date_create($cid);
	  $l_date = date_create($expcdate);
	  $diff = date_diff($aa_date, $l_date);
	  $difference = $diff->format("%a");
	  for ($i = 0; $i <= $difference; $i++) {
		  $currentDate = date("Y-m-d", strtotime("+$i day", strtotime($cid)));
		  $val = "exec roomavailability_validation '" . $currentDate . "','" . $typeid . "'";
		  $validationResult = $this->db->query($val);
		  $this->db->close();
		  $this->db->reconnect();
		  if ($validationResult) {
			  $insR = "exec Update_RoomAvailability '" . $currentDate . "', '" . $typeid . "'";
			  $execute = $this->db->query($insR);
			  $this->db->close();
			  $this->db->reconnect();
		  }
	  }
  }
	

	
			echo "success";
		} else {
			echo "failed";
		}
	}



		public function Reservesaveoldold()
	{
		date_default_timezone_set('Asia/Kolkata');

		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuningCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Lastname'] . "','1','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email_ID'] . "','" . $_REQUEST['City_id'] . "','" . $_REQUEST['State_id'] . "','" . $_REQUEST['Country_id'] . "','" . $_REQUEST['Middlename'] . "'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
		}
		$sql7 = "select * from temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res7 = $this->db->query($sql7);
		foreach ($res7->result_array() as $row7) {
			$upqry = "Update Mas_Customer set HomeAddress1='" . $row7['HomeAddress1'] . "',HomeAddress2='" . $row7['HomeAddress2'] . "',HomeAddress3='" . $row7['HomeAddress3'] . "',Homepincode='" . $row7['Homepincode'] . "',Nationality='" . $row7['Nationality'] . "',ResidentialPhone='" . $row7['ResidentialPhone'] . "',WorkAddress1='" . $row7['WorkAddress1'] . "',
		WorkAddress2='" . $row7['WorkAddress2'] . "',WorkAddress3='" . $row7['WorkAddress3'] . "',Workpincode='" . $row7['Workpincode'] . "',WorkCityid='" . $row7['WorkCityid'] . "',WorPhone='" . $row7['WorPhone'] . "',gender='" . $row7['gender'] . "',Profession='" . $row7['Profession'] . "',Birthdate='" . $row7['Birthdate'] . "',Weddingdate='" . $row7['Weddingdate'] . "',
		Likes='" . $row7['Likes'] . "',Dislikes='" . $row7['Dislikes'] . "',Preffered_Room='" . $row7['Preffered_Room'] . "',Hotel_Commends='" . $row7['Hotel_Commends'] . "',passportno='" . $row7['passportno'] . "',Passport_issueplace='" . $row7['Passport_issueplace'] . "',Passport_issuedate='" . $row7['Passport_issuedate'] . "',Passport_Expirydate='" . $row7['Passport_Expirydate'] . "',VISA_No='" . $row7['VISA_No'] . "',
		VISA_Issueplace='" . $row7['VISA_Issueplace'] . "',VISA_Issuedate='" . $row7['VISA_Issuedate'] . "',VISA_Expirydate='" . $row7['VISA_Expirydate'] . "',Id_Documenttype='" . $row7['Id_Documenttype'] . "',Id_Documentno='" . $row7['Id_Documentno'] . "' where Mobile ='" . $row7['Mobile'] . "'";
			$res = $this->db->query($upqry);
		}
		$sql8 = "delete temp_customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res8 = $this->db->query($sql8);

		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$Indate = str_replace('/', '-', $_REQUEST['Indate']);
		$Indate = date('Y/m/d', strtotime($Indate));
		$Indate1 = date('m/d/Y', strtotime($Indate));
		$todate = str_replace('/', '-', $_REQUEST['todate']);
		$todate = date('Y/m/d', strtotime($todate));
		$Company_Id = $_REQUEST['Company_Id'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}
		$sql3 = "SELECT * FROM Mas_Room rm
		Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
		where rm.Room_id='" . $_REQUEST['Roomid'] . "'";
		$res3 = $this->db->query($sql3);
		foreach ($res3->result_array() as $row3) {
			$Room_id = $row3['Room_Id'];
			$RoomType_Id = $row3['RoomType_Id'];
			$Adults = $row3['Adults'];
			$Extrabedamount = $row3['Extrabedamount'];
		}
		$sql4 = "SELECT * FROM temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "'";
		$res4 = $this->db->query($sql4);
		foreach ($res4->result_array() as $row4) {
			if ($Adults >= $_REQUEST['Adults']) {
				$Extrabed = 0;
				$guestcharge = 0;
				if ($_REQUEST['Adults'] == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($_REQUEST['Adults'] == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($_REQUEST['Adults'] == 3) {
					if ($row4['Triplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($_REQUEST['Adults'] >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			} else {
				$Extrabed = $_REQUEST['Adults'] - $Adults;
				$guestcharge = $Extrabedamount;
				if ($Adults == 1) {
					$RoomRent = $row4['singlerent'];
					$actRoomRent = $row4['actsinglerent'];
				}
				if ($Adults == 2) {
					$RoomRent = $row4['Doublerent'];
					$actRoomRent = $row4['actdoublerent'];
				}
				if ($Adults == 3) {
					if ($Adults == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Triplerent'];
						$actRoomRent = $row4['acttriplerent'];
					}
				}
				if ($Adults >= 4) {
					if ($row4['Quartertriplerent'] == 0) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					} else {
						$RoomRent = $row4['Quartertriplerent'];
						$actRoomRent = $row4['actquartertriplerent'];
					}
				}
			}
		}
		$ins = "Insert into Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totamt,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,totalrent,age,discper,discount,muserid,Roomid,isconfirm)
	       values(dbo.ResNo(),'" . User_id . "','P','" . $date . "','" . $Customer_Id . "','" . $RoomRent . "','1','','" . User_id . "','0','" . $date . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','" . $RoomRent . "','','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . User_id . "','" . $_REQUEST['Roomid'] . "',1)";
		//$ins="Insert into Trans_Checkin_mas (Grcno,CheckinDate,CheckinTime,ExpDate,ExpTime,Noadults,Nochilds,NoofRooms,userid)
		//	values(dbo.GrcNo(),'".$Indate."',convert(VARCHAR,getdate(),108),'".$todate."',convert(VARCHAR,getdate(),108),'".$_REQUEST['Adults']."','".$_REQUEST['Child']."','1','".User_id."')";


		$sql2 = " SELECT max(roomgrcid) as roomgrcid FROM Trans_Roomdet_det";
		$res2 = $this->db->query($sql2);
		foreach ($res2->result_array() as $row2) {
			$roomgrcid = $row2['roomgrcid'] + 1;
		}


		$Discamt = 0;
		$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
		$res5 = $this->db->query($sql5);
		foreach ($res5->result_array() as $row5) {
			$Taxid = $row5['Taxid'];
		}


		$ins1 = $ins1 . "Insert into Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
			values('" . $Indate . "','1','" . $_REQUEST['Adults'] . "',@Siden,convert(VARCHAR,getdate(),108),convert(VARCHAR,getdate(),108),'" . $todate . "','0','0','" . $RoomType_Id . "','" . $RoomType_Id . "','" . $_REQUEST['RateCode'] . "','" . $_REQUEST['foodplan'] . "','0','0.00','" . $RoomRent . "','" . $RoomRent . "','" . $Taxid . "','" . $Adults . "')";
		$fromdate = $Indate;
		$sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomid'] . "'";
		$res6 = $this->db->query($sql6);
		foreach ($res6->result_array() as $row6) {
			$singlerent = $row6['singlerent'];
			$Doublerent = $row6['Doublerent'];
			$Triplerent = $row6['Triplerent'];
			$Quartertriplerent = $row6['Quartertriplerent'];
			$ChildRate = $row6['extrachildcharges'];
			if ($ChildRate == '') {
				$ChildRate = 0;
			}
			$ins3 = $ins3 . "	Insert into Trans_reserve_det1(resdate,typeid,noofrooms,fromtime,totime,refresdetid,fromdate,todate,ratetypeid)
		values('" . $Indate . "','" . $RoomType_Id . "','1',convert(VARCHAR,getdate(),108),convert(VARCHAR,getdate(),108),@Siden1,'" . $fromdate . "','" . $todate . "','" . $_REQUEST['RateCode'] . "')";
			$Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
		}

		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;
		echo "set @Siden=@@identity; ";
		echo "Declare @Siden1 INT; ";
		echo $ins1;
		echo "set @Siden1=@@identity; ";
		echo $ins3;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$sq = "" . $sqc . "";
		$result = $this->db->query($sq);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {

			$qry = "select mh.Company as Com,* from trans_reserve_mas rmas 
					inner join Trans_reserve_det rdet on rdet.resid=rmas.Resid
					inner join mas_customer cus on cus.Customer_Id = rmas.cusid
					inner join mas_title t on t.Titleid = cus.Titelid
					inner join Mas_room room on room.Room_Id=rmas.Roomid
					inner join Mas_RoomType mr on mr.RoomType_Id= room.RoomType_Id
					inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
					where rmas.Resid=IDENT_CURRENT('Trans_reserve_mas')";

			$result = $this->db->query($qry);
			foreach ($result->result_array() as $row1) {
				$firstname = $row1['Firstname'];
				$lastname = $row1['Lastname'];
				$title = $row1['Title'];
				$name = $title . '.' . $firstname . $lastname;
				$roomno = $row1['RoomNo'];
				$roomType = $row1['RoomType'];
				$rent = $row1['roomrent'];
				$company = $row1['Com'];
				$mobile = $row1['Mobile'];
				$resno = $row1['ResNo'];
				$resdate = date('d-m-Y', strtotime(substr($row1['Resdate'], 0, 10)));
			}

			$temqury = "select Template from mas_smsmessage where  isnull(reserveGuest,0)='1'";
			$smsTemp = $this->db->query($temqury);
			foreach ($smsTemp->result_array() as $row) {
				$msg = $row['Template'];
				$msg = str_replace('*CutomerName*', $name, $msg);
				$msg = str_replace('*RoomNo*', $roomno, $msg);
				$msg = str_replace('*RoomType*', $roomType, $msg);
				$msg = str_replace('*RoomRent*', $rent, $msg);
				$msg = str_replace('*CompanyName*', $company, $msg);
				$msg = str_replace('*ResNo*', $resno, $msg);
				$msg = str_replace('*Reserve Date*', $resdate, $msg);

				$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
			values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20))";
				$execins = $this->db->query($ins);
			}
			$temquy = "select Template from mas_smsmessage where  isnull(reserveMD,0)='1'";
			$smTemp = $this->db->query($temquy);
			foreach ($smTemp->result_array() as $ro) {
				$msgg = $ro['Template'];
				$msgg = str_replace('*CutomerName*', $name, $msgg);
				$msgg = str_replace('*RoomNo*', $roomno, $msgg);
				$msgg = str_replace('*RoomType*', $roomType, $msgg);
				$msgg = str_replace('*RoomRent*', $rent, $msgg);
				$msgg = str_replace('*ResNo*', $resno, $msgg);
				$msgg = str_replace('*Reserve Date*', $resdate, $msgg);

				$sle = "select * from mas_smsusers where usertype='500'";
				$exe = $this->db->query($sle);
				foreach ($exe->result_array() as $CMD) {
					$mdmobile = $CMD['mobileno'];
					$ins = "insert into outbox (MobileNumber,SMSMessage,DateCreated)
					values('" . $mdmobile . "','" . $msgg . "',convert(VARCHAR,getdate(),20)roomtypeguestadults)";
					$execins = $this->db->query($ins);
				}
			}
			echo "Sucess";
		} else {
			echo "Error";
		}
	}


	public function ReservationEdit_save()
{

	date_default_timezone_set('Asia/Kolkata');
	  $modeqry = "select ReservationMode_Id from mas_reservationmode where ReservationMode = '".$_REQUEST['ReservationMode']."'";
	 $mode = $this->db->query($modeqry)->row_array();
    $date = date("Y-m-d");
    $time = date("H:i:s");

    // Step 1: Check if customer exists
    $sql = "SELECT * FROM Mas_Customer WHERE Mobile='" . $_REQUEST['Mobile'] . "'";
    $res = $this->db->query($sql);
    $numberofrow = $res->num_rows();

    if ($numberofrow == 0) {
        $qry = "Exec_RuninggCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email'] . "','" . $_REQUEST['City_id'] . "', 'SAVE'";
        $this->db->query($qry);
        $this->db->close();
        $this->db->reconnect();
    }

    // Step 2: Get Customer_Id and update customer info
    $sql1 = "SELECT * FROM Mas_Customer WHERE Mobile='" . $_REQUEST['Mobile'] . "'";
    $res1 = $this->db->query($sql1);
    $Customer_Id = null;
    foreach ($res1->result_array() as $rows) {
        $Customer_Id = $rows['Customer_Id'];
        $cus = "UPDATE Mas_Customer SET Firstname = '" . $_REQUEST['Firstname'] . "', Mobile='" . $_REQUEST['Mobile'] . "', Email_ID='" . $_REQUEST['Email'] . "', Cityid='" . $_REQUEST['City_id'] . "', Titelid='" . $_REQUEST['Title'] . "' WHERE Customer_Id = '" . $Customer_Id . "';";
        $this->db->query($cus);
    }

    // Step 3: Backup existing reservation data to log tables and delete old reservation
    $sele = "SELECT * FROM trans_reserve_mas mas
             INNER JOIN Trans_Reserve_Det det ON mas.resid = det.resid 
             WHERE mas.ResNo='" . $_REQUEST['resno'] . "'";
    $exe = $this->db->query($sele);
    $no = $exe->num_rows();

    // Initialize transaction SQL string
    $transactionSql = "BEGIN TRY\nBEGIN TRANSACTION;\n";

    foreach ($exe->result_array() as $ro) {
        $resid = $ro['Resid'];
        $detid = $ro['resdetid'];

        for ($i = 0; $i < $no; $i++) {
            // Insert into Trans_reserve_mas_log
            $transactionSql .= "INSERT INTO Trans_reserve_mas_log(ResNo,Resid,Reserveby,Communicate,Resdate,cusid,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,age,discper,discount,muserid,company,yearprefix,isconfirm,Edituserid,Editdate,Edittime)
                VALUES ('" . $ro['ResNo'] . "','" . $ro['Resid'] . "','" . $ro['Reserveby'] . "','" . $ro['Communicate'] . "','" . $ro['Resdate'] . "','" . $ro['cusid'] . "','" . $ro['totrooms'] . "','','" . $ro['userid'] . "','" . $ro['waitlist'] . "','" . $_REQUEST['duedate'] . "','" . $ro['travelagentid'] . "','" . $ro['onlinebookingno'] . "','','" . $ro['discper'] . "','" . $ro['discount'] . "','" . $ro['muserid'] . "','" . $ro['company'] . "','" . $ro['yearprefix'] . "','1','" . User_id . "','" . $date . "','" . $time . "');\n";

            // Insert into Trans_reserve_det_log
            $transactionSql .= "INSERT INTO Trans_reserve_det_log(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
                VALUES ('" . $ro['fromdate'] . "','" . $ro['noofrooms'] . "','" . $ro['noofpax'] . "','" . $ro['resid'] . "','" . $ro['fromtime'] . "','" . $ro['totime'] . "','" . $ro['todate'] . "','0','0','" . $ro['typeid'] . "','" . $ro['tarifftype'] . "','" . $ro['ratetypeid'] . "','" . $ro['planid'] . "','0','0.00','" . $ro['roomrent'] . "','" . $ro['totalroomrent'] . "','" . $ro['taxid'] . "','" . $ro['actpax'] . "');\n";

            // Insert into Trans_reserve_det1_log for each related record
            $logdet = "SELECT * FROM trans_reserve_det1 WHERE refresdetid = '" . $ro['Resid'] . "'";
            $exelogdet = $this->db->query($logdet)->result_array();

            foreach ($exelogdet as $exlog) {
                $transactionSql .= "INSERT INTO Trans_reserve_det1_log (resdate, typeid, noofrooms, fromtime, totime, refresdetid, fromdate, todate, ratetypeid) 
                    VALUES ('" . $exlog['resdate'] . "','" . $exlog['typeid'] . "','" . $exlog['noofrooms'] . "','" . $exlog['fromtime'] . "','" . $exlog['totime'] . "','" . $exlog['refresdetid'] . "','" . $exlog['fromdate'] . "','" . $exlog['todate'] . "','" . $exlog['ratetypeid'] . "');\n";
            }

            // Delete old reservation details
            $transactionSql .= "DELETE FROM Trans_reserve_det1 WHERE refresdetid='" . $detid . "';\n";
            $transactionSql .= "DELETE FROM Trans_reserve_det WHERE resid='" . $resid . "';\n";
            $transactionSql .= "DELETE FROM Trans_reserve_mas WHERE ResNo='" . $_REQUEST['resno'] . "';\n";
        }
    }

    // Step 4: Insert new reservation master record
    $transactionSql .= "INSERT INTO Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,age,discper,discount,muserid,company,yearprefix)
        VALUES ('" . $_REQUEST['resno'] . "','" . User_id . "','P','" . $date . "','" . $Customer_Id . "','" . $_REQUEST['roomcount'] . "','','" . User_id . "','" . $mode['ReservationMode_Id'] . "','" . $_REQUEST['duedate'] . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . User_id . "','" . $_REQUEST['CompanyId'] . "',dbo.YearPrefix());\n";

    // Declare variable to hold new resid identity
    $transactionSql .= "DECLARE @NewResid INT = SCOPE_IDENTITY();\n";

    // Step 5: Loop through each room reservation detail and build insert statements
    $rowcount = $_REQUEST['rowcount'];

    for ($i = 0; $i < $rowcount; $i++) {
        $Indate = str_replace('/', '-', $_REQUEST['Indate'][$i]);
        $Indate = date('Y/m/d', strtotime($Indate));
        $todate = str_replace('/', '-', $_REQUEST['todate'][$i]);
        $todate = date('Y/m/d', strtotime($todate));
        $ARRtimee = $_REQUEST['FHr'][$i] . ':' . $_REQUEST['FMi'][$i];
        $Deptimee = $_REQUEST['THr'][$i] . ':' . $_REQUEST['TMi'][$i];

        // Delete temp room rent details for this room type (execute immediately outside transaction)
        $this->db->query("DELETE FROM temp_trans_roomdet_det_rent WHERE roomid='" . $_REQUEST['Roomtype_id'][$i] . "'");

        // Insert temp room rent details for each date in range (execute immediately outside transaction)
        $Indatee = $Indate;
        while ($Indatee <= $todate) {
            $sql6 = "SELECT * FROM Mas_RatePlan RP 
                INNER JOIN Mas_RatePlan_Det RD ON RD.RatePlan_Id=RP.RatePlan_Id
                INNER JOIN Mas_Plantype PT ON PT.PlanType_Id=RP.PlanType_Id
                INNER JOIN Mas_Roomtype RT ON RT.RoomType_Id=RP.RoomType_Id
                INNER JOIN Mas_Room RM ON RM.RoomType_Id=RT.RoomType_Id
                WHERE RM.Room_Id ='" . $_REQUEST['Roomtype_id'][$i] . "' ORDER BY PT.PlanType_Id";
            $res6 = $this->db->query($sql6);
            foreach ($res6->result_array() as $row6) {
                $ins3 = "INSERT INTO temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
                    VALUES ('" . $Indatee . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $row6['Single'] . "','" . $row6['Doubles'] . "','" . $row6['Triple'] . "','" . $row6['Quadruple'] . "','I','" . $row6['Single'] . "','" . $row6['Doubles'] . "','" . $row6['Triple'] . "','" . $row6['Quadruple'] . "','" . $row6['Extrabedamount'] . "','" . User_id . "',dbo.GrcNo(),'" . Hotel_Id . "');";
                $this->db->query($ins3);
            }
            $Indatee = date("Y/m/d", strtotime("+1 day", strtotime($Indatee)));
        }

        // Get room details
        $sql3 = "SELECT * FROM Mas_Room rm
                 INNER JOIN Mas_Roomtype rt ON rt.RoomType_Id=rm.RoomType_Id
                 WHERE rm.Room_id='" . $_REQUEST['Roomtype_id'][$i] . "'";
        $res3 = $this->db->query($sql3);
        $Room_id = null;
        $Adults = 0;
        $Extrabedamount = 0;
        foreach ($res3->result_array() as $row3) {
            $Room_id = $row3['Room_Id'];
            $Adults = $row3['Adults'];
            $Extrabedamount = $row3['Extrabedamount'];
        }

        // Get temp room rent details
        $sql4 = "SELECT * FROM temp_trans_roomdet_det_rent WHERE roomid='" . $Room_id . "'";
        $res4 = $this->db->query($sql4);

        $RoomRent = 0;
        $guestcharge = 0;
        foreach ($res4->result_array() as $row4) {
            if ($Adults >= $_REQUEST['Adults'][$i]) {
                if ($_REQUEST['Adults'][$i] == 1) {
                    $RoomRent = $row4['singlerent'];
                } elseif ($_REQUEST['Adults'][$i] == 2) {
                    $RoomRent = $row4['Doublerent'];
                } elseif ($_REQUEST['Adults'][$i] == 3) {
                    $RoomRent = ($row4['Triplerent'] == 0) ? $row4['Doublerent'] : $row4['Triplerent'];
                } else {
                    $RoomRent = ($row4['Quartertriplerent'] == 0) ? $row4['Doublerent'] : $row4['Quartertriplerent'];
                }
                $guestcharge = 0;
            } else {
                $Extrabed = $_REQUEST['Adults'][$i] - $Adults;
                $guestcharge = $Extrabedamount;
                if ($Adults == 1) {
                    $RoomRent = $row4['singlerent'];
                } elseif ($Adults == 2) {
                    $RoomRent = $row4['Doublerent'];
                } elseif ($Adults == 3) {
                    $RoomRent = ($Adults == 0) ? $row4['Doublerent'] : $row4['Triplerent'];
                } else {
                    $RoomRent = ($row4['Quartertriplerent'] == 0) ? $row4['Doublerent'] : $row4['Quartertriplerent'];
                }
            }
            break; // Use first row only
        }

        // Get tax id
        $Discamt = 0;
        $sql5 = "SELECT dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . date('m/d/Y', strtotime($Indate)) . "') AS Taxid";
        $res5 = $this->db->query($sql5);
        $Taxid = 0;
        foreach ($res5->result_array() as $row5) {
            $Taxid = $row5['Taxid'];
        }

        // Insert into Trans_reserve_det
		$transactionSql .= "DECLARE @NewResid".$i." INT" ;
        $transactionSql .= " INSERT INTO Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
            VALUES ('" . $Indate . "','" . $_REQUEST['noofrooms'][$i] . "','" . $_REQUEST['Adults'][$i] . "',@NewResid,
            CONVERT(VARCHAR, '" . $ARRtimee . "', 108), CONVERT(VARCHAR, '" . $Deptimee . "', 108), '" . $todate . "', '0', '0',
            '" . $_REQUEST['Roomtype_id'][$i] . "', '" . $_REQUEST['Roomtype_id'][$i] . "', '" . $_REQUEST['RateCode'][$i] . "', '" . $_REQUEST['foodplan'][$i] . "',
            '0', '0.00', '" . $RoomRent . "', '" . $RoomRent . "', '" . $Taxid . "', '" . $_REQUEST['Adults'][$i] . "');\n";
			     
		$transactionSql .= "set  @NewResid".$i." = @@Identity" ;

        // Insert into Trans_reserve_det1 for each day in range
        $startDateObj = date_create($Indate);
        $endDateObj = date_create($todate);
        $interval = date_diff($startDateObj, $endDateObj);
        $totalDays = $interval->format("%a");

        for ($d = 0; $d <= $totalDays; $d++) {
            $nextDate = date("Y/m/d", strtotime("+$d day", strtotime($Indate)));

            if ($d == 0) {
                $fromTime = $ARRtimee;
                $toTime = "23:59";
            } elseif ($d == $totalDays) {
                $fromTime = "00:00";
                $toTime = $Deptimee;
            } else {
                $fromTime = "00:00";
                $toTime = "23:59";
            }

            $transactionSql .= " INSERT INTO Trans_reserve_det1(resdate,typeid,noofrooms,fromtime,totime,refresdetid,fromdate,todate,ratetypeid)
                VALUES ('" . $nextDate . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['noofrooms'][$i] . "', CONVERT(VARCHAR, '" . $fromTime . "', 108), CONVERT(VARCHAR, '" . $toTime . "', 108),
               @NewResid".$i.", '" . $Indate . "', '" . $todate . "', '" . $_REQUEST['RateCode'][$i] . "');\n";
        }
    }

    // Step 6: Commit or rollback transaction
    $transactionSql .= "IF @@ERROR <> 0 ROLLBACK TRANSACTION;\n";
    $transactionSql .= "ELSE COMMIT TRANSACTION;\n";
    $transactionSql .= "END TRY\n";
    $transactionSql .= "BEGIN CATCH\n";
    $transactionSql .= "ROLLBACK TRANSACTION;\n";
    $transactionSql .= "SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;\n";
    $transactionSql .= "END CATCH;\n";


    $result = $this->db->query($transactionSql);
    $this->db->close();
    $this->db->reconnect();

    if ($result) {
        // Step 8: Room availability validation and update (unchanged)
        $resno = $_REQUEST['resno'];
        $prefix = $_REQUEST['prefix'];

        // $check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, tdet.resid FROM Trans_reserve_mas mas 
        //           INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid
        //           WHERE mas.resno= '" . $resno . "' AND mas.yearprefix = '" . $prefix . "'";

        // $checkqry = $this->db->query($check);
        // foreach ($checkqry->result_array() as $ress) {
        //     $cid = $ress['fromdate'];
        //     $typeid = $ress['typeid'];
        //     $expcdate = $ress['todate'];
        //     $resid = $ress['resid'];
        // }

        // $aa_date = date_create($cid);
        // $l_date = date_create($expcdate);
        // $diff = date_diff($aa_date, $l_date);
        // $difference = $diff->format("%a");

        // for ($i = 0; $i <= $difference; $i++) {
        //     $val = "exec roomavailability_validation '" . $cid . "','" . $typeid . "','" . $resid . "'";
		// 	$validationResult = $this->db->query($val);
        //     $this->db->close();
        //     $this->db->reconnect();

        //     if ($validationResult) {
        //         $insR = "exec Update_RoomAvailability '" . $cid . "', '" . $typeid . "'";
        //         $execute = $this->db->query($insR);
        //         $this->db->close();
        //         $this->db->reconnect();
        //     }

        //     $cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
        //     $this->db->close();
        //     $this->db->reconnect();
        // }


		$check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, tdet.resid FROM Trans_reserve_mas mas 
          INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid
          WHERE mas.resno= '" . $resno . "' AND mas.yearprefix = '" . $prefix . "'";

$checkqry = $this->db->query($check);

foreach ($checkqry->result_array() as $ress) {
    $cid = $ress['fromdate'];
    $typeid = $ress['typeid'];
    $expcdate = $ress['todate'];
    $resid = $ress['resid'];

    $aa_date = date_create($cid);
    $l_date = date_create($expcdate);
    $diff = date_diff($aa_date, $l_date);
    $difference = $diff->format("%a");

    for ($i = 0; $i <= $difference; $i++) {
        $currentDate = date("Y-m-d", strtotime("+$i day", strtotime($cid)));

        $val = "exec roomavailability_validation '" . $currentDate . "','" . $typeid . "'";
        $validationResult = $this->db->query($val);
        $this->db->close();
        $this->db->reconnect();

        if ($validationResult) {
            $insR = "exec Update_RoomAvailability '" . $currentDate . "', '" . $typeid . "'";
            $execute = $this->db->query($insR);
            $this->db->close();
            $this->db->reconnect();
        }
    }
}


     

        echo "success";
    } else {
        echo "failed";
    }
}


   // Reservation amendment validation and update
        // $checkres = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, tdet.resid FROM Trans_reserve_mas_log mas 
        //              INNER JOIN Trans_reserve_det_log tdet ON tdet.resid = mas.resid
        //              WHERE mas.resno= '" . $resno . "' AND mas.yearprefix = '" . $prefix . "'";

        // $checkqryres = $this->db->query($checkres);
        // foreach ($checkqryres->result_array() as $ress) {
        //     $cidr = $ress['fromdate'];
        //     $typeidr = $ress['typeid'];
        //     $expcdater = $ress['todate'];
        //     $residr = $ress['resid'];
        // }

        // $aa_dater = date_create($cidr);
        // $l_dater = date_create($expcdater);
        // $diffr = date_diff($aa_dater, $l_dater);
        // $differencer = $diffr->format("%a");

        // for ($i = 0; $i <= $differencer; $i++) {
        //     $val = "exec roomavailability_validation '" . $cidr . "','" . $typeidr . "','" . $residr . "'";
        //     $validationResult = $this->db->query($val);
        //     $this->db->close();
        //     $this->db->reconnect();

        //     if ($validationResult) {
        //         $insR = "exec Update_RoomAvailability_reservation '" . $cidr . "', '" . $typeidr . "', '" . $residr . "'";
        //         $execute = $this->db->query($insR);
        //         $this->db->close();
        //         $this->db->reconnect();
        //     }

        //     $cidr = date("Y-m-d", strtotime('+1 day', strtotime($cidr)));
        //     $this->db->close();
        //     $this->db->reconnect();
        // }

	


	public function ReservationEditold_save()
	{
		date_default_timezone_set('Asia/Kolkata');

		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuninggCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email'] . "','" . $_REQUEST['City_id'] . "', 'SAVE'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
			$cus = "update Mas_Customer set Firstname = '" . $_REQUEST['Firstname'] . "', Mobile='" . $_REQUEST['Mobile'] . "', Email_ID='" . $_REQUEST['Email'] . "', Cityid='" . $_REQUEST['City_id'] . "', Titelid='" . $_REQUEST['Title'] . "' where Customer_Id = '" . $Customer_Id . "'";
			$cuss = $this->db->query($cus);
		}

		 $sele = "select * from trans_reserve_mas mas
		inner join Trans_Reserve_Det det on mas.resid =det.resid 
		where mas.ResNo='" . $_REQUEST['resno'] . "'";




	

		

		$exe = $this->db->query($sele);


		$no = $exe->num_rows();
		foreach ($exe->result_array() as $ro) {
			$resid = $ro['Resid'];
			$detid = $ro['resdetid'];
			for ($i = 0; $i < $no; $i++) {

				 $tins = "Insert into Trans_reserve_mas_log(ResNo,Resid,Reserveby,Communicate,Resdate,cusid,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,age,discper,discount,muserid,company,yearprefix,isconfirm,Edituserid,Editdate,Edittime)
				values('".$ro['ResNo']."','".$ro['Resid']."','" . $ro['Reserveby'] . "','" . $ro['Communicate'] . "','" . $ro['Resdate'] . "','" . $ro['cusid'] . "','" . $ro['totrooms'] . "','','" . $ro['userid'] . "','" . $ro['waitlist'] . "','" . $ro['duedate'] . "','" . $ro['travelagentid'] . "','" . $ro['onlinebookingno'] . "','','" . $ro['discper'] . "','" . $ro['discount'] . "','" . $ro['muserid'] . "',
				'" . $ro['company'] . "','" . $ro['yearprefix'] . "','1','".User_id."','".$date."','".$time."')";

				$insexe = $this->db->query($tins);


				 $tins1 = "Insert into Trans_reserve_det_log(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
			values('".$ro['fromdate']."','" . $ro['noofrooms']. "','" . $ro['noofpax'] . "','" . $ro['resid'] . "',
			'".$ro['fromtime']."','".$ro['totime']."','".$ro['todate']."','0','0',
			'" . $ro['typeid'] . "','" . $ro['tarifftype'] . "','" . $ro['ratetypeid'] . "','" . $ro['planid'] . "',
			'0','0.00','" . $ro['roomrent'] . "','" . $ro['totalroomrent'] . "','" . $ro['taxid'] . "','" . $ro['actpax']. "')";

			$inexe1 = $this->db->query($tins1);



			
			$logdet = "select * from trans_reserve_det1  where refresdetid = '".$ro['Resid']."'";
    
			$exelogdet = $this->db->query($logdet)->result_array();

			foreach($exelogdet as $exlog){

				
			$tins2 = "INSERT INTO Trans_reserve_det1_log (resdate, typeid, noofrooms, fromtime, totime, refresdetid, fromdate, todate, ratetypeid) 
			VALUES (
				'".$exlog['resdate']."',
				'" . $exlog['typeid'] . "',
				'" . $exlog['noofrooms']. "',
				'" . $exlog['fromtime']. "',
				'" . $exlog['totime']. "',
				'" . $exlog['refresdetid']. "',
				'" . $exlog['fromdate']. "',
				'" . $exlog['todate']. "',
				'" . $exlog['ratetypeid']. "'
			);";
			$inexe2 = $this->db->query($tins2);
			}


				
		
		
			

				 $dele2 = "Delete from Trans_reserve_det1 where refresdetid='" . $detid . "'";
				$ex2 = $this->db->query($dele2);

				$dele1 = "Delete from Trans_reserve_det where resid='" . $resid . "'";
				$ex1 = $this->db->query($dele1);

				

				$dele = "Delete from Trans_reserve_mas where ResNo='" . $_REQUEST['resno'] . "'";
				$ex = $this->db->query($dele);
			
				
			}
		}


		ob_start();
		@session_start();
		$ins1 = '';
		$ins2 = '';
		$ins3 = '';
		$ins = "Insert into Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,age,discper,discount,muserid,company,yearprefix)
		values('" . $_REQUEST['resno'] . "','" . User_id . "','P','" . $date . "','" . $Customer_Id . "','" . $_REQUEST['roomcount'] . "','','" . User_id . "','" . $_REQUEST['ReservationMode'] . "','" . $_REQUEST['duedate'] . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . User_id . "',
		 '" . $_REQUEST['CompanyId'] . "',dbo.YearPrefix())";
		$EXE = $this->db->query($ins);
		$rowcount = $_REQUEST['rowcount'];

		for ($i = 0; $i < $rowcount; $i++) {
			$i;
			$Indate = str_replace('/', '-', $_REQUEST['Indate'][$i]);
			$Indate = date('Y/m/d', strtotime($Indate));
			$Indatee = date('Y/m/d', strtotime($Indate));
			$Indate1 = date('m/d/Y', strtotime($Indate));
			$todate = str_replace('/', '-', $_REQUEST['todate'][$i]);
			$todate = date('Y/m/d', strtotime($todate));
			$Company_Id = $_REQUEST['CompanyId'];
			if ($Company_Id == '') {
				$Company_Id = 0;
			}
			$ARRtimee = $_REQUEST['FHr'][$i] . ':' . $_REQUEST['FMi'][$i];

			$Deptimee = $_REQUEST['THr'][$i] . ':' . $_REQUEST['TMi'][$i];

			$delete = "Delete temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomtype_id'][$i] . "'";
			$this->db->query($delete);

			while ($Indatee <= $todate) {
				$sql6 = "SELECT * FROM Mas_RatePlan RP 
			 INNER JOIN Mas_RatePlan_Det RD on RD.RatePlan_Id=RP.RatePlan_Id
			 INNER JOIN Mas_Plantype PT on PT.PlanType_Id=Rp.PlanType_Id
			 INNER JOIN Mas_Roomtype RT on RT.RoomType_Id=RP.RoomType_Id
			 INNER JOIN Mas_Room RM on RM.RoomType_Id =RT.RoomType_Id
			 where RM.Room_Id ='" . $_REQUEST['Roomtype_id'][$i] . "' Order by PT.PlanType_Id";
				$res6 = $this->db->query($sql6);
				$data = $res6->result();
				foreach ($res6->result_array() as $row6) {
					$Adults = $row6['Adults'];
					$Extrabedcount = $row6['Extrabedcount'];
					$singlerent = $row6['Single'];
					$Doublerent = $row6['Doubles'];
					$Triplerent = $row6['Triple'];
					$Quartertriplerent = $row6['Quadruple'];

					$ins3 = "Insert into temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
					values('" . $Indatee . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','I','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $row6['Extrabedamount'] . "','" . User_id . "',dbo.GrcNo(),'" . Hotel_Id . "')";
					$result = $this->db->query($ins3);
					$Indatee = date("Y/m/d", strtotime("+1 day", strtotime($Indatee)));
				}
			}

			$sql3 = "SELECT * FROM Mas_Room rm
		Inner join Mas_Roomtype rt on rt.RoomType_Id=rm.RoomType_Id
		where rm.Room_id='" . $_REQUEST['Roomtype_id'][$i] . "'";
			$res3 = $this->db->query($sql3);
			foreach ($res3->result_array() as $row3) {
				$Room_id = $row3['Room_Id'];
				$RoomType_Id = $row3['RoomType_Id'];
				$Adults = $row3['Adults'];
				$Extrabedamount = $row3['Extrabedamount'];
			}
			$sql4 = "SELECT * FROM temp_trans_roomdet_det_rent where roomid='" . $Room_id . "'";
			$res4 = $this->db->query($sql4);

			foreach ($res4->result_array() as $row4) {

				if ($Adults >= $_REQUEST['Adults'][$i]) {
					$Extrabed = 0;
					$guestcharge = 0;
					if ($_REQUEST['Adults'][$i] == 1) {
						$RoomRent = $row4['singlerent'];
						$actRoomRent = $row4['actsinglerent'];
					}
					if ($_REQUEST['Adults'][$i] == 2) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					}
					if ($_REQUEST['Adults'][$i] == 3) {
						if ($row4['Triplerent'] == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$RoomRent = $row4['Triplerent'];
							$actRoomRent = $row4['acttriplerent'];
						}
					}
					if ($_REQUEST['Adults'][$i] >= 4) {
						if ($row4['Quartertriplerent'] == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$actRoomRent = $row4['actquartertriplerent'];
						}
					}
				} else {
					$Extrabed = $_REQUEST['Adults'][$i] - $Adults;
					$guestcharge = $Extrabedamount;
					if ($Adults == 1) {
						$RoomRent = $row4['singlerent'];
						$actRoomRent = $row4['actsinglerent'];
					}
					if ($Adults == 2) {
						$RoomRent = $row4['Doublerent'];
						$actRoomRent = $row4['actdoublerent'];
					}
					if ($Adults == 3) {
						if ($Adults == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$RoomRent = $row4['Triplerent'];
							$actRoomRent = $row4['acttriplerent'];
						}
					}
					if ($Adults >= 4) {
						if ($row4['Quartertriplerent'] == 0) {
							$RoomRent = $row4['Doublerent'];
							$actRoomRent = $row4['actdoublerent'];
						} else {
							$RoomRent = $row4['Quartertriplerent'];
							$actRoomRent = $row4['actquartertriplerent'];
						}
					}
				}
			}

			$sql2 = " SELECT max(roomgrcid) as roomgrcid FROM Trans_Roomdet_det";
			$res2 = $this->db->query($sql2);
			foreach ($res2->result_array() as $row2) {
				$roomgrcid = $row2['roomgrcid'] + 1;
			}


			$Discamt = 0;
			$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
			$res5 = $this->db->query($sql5);
			foreach ($res5->result_array() as $row5) {
				$Taxid = $row5['Taxid'];
			}
			$ins1 = '';

		  	$ins1 = $ins1 . "Insert into Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
			values('" . $Indate . "','" . $_REQUEST['noofrooms'][$i] . "','" . $_REQUEST['Adults'][$i] . "',ident_current('Trans_reserve_mas'),
			convert(VARCHAR,'" . $ARRtimee . "',108),convert(VARCHAR,'" . $Deptimee . "',108), '" . $todate . "','0','0',
			'" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['RateCode'][$i] . "','" . $_REQUEST['foodplan'][$i] . "',
			'0','0.00','" . $RoomRent . "','" . $RoomRent . "','" . $Taxid . "','" . $_REQUEST['Adults'][$i] . "')";

			$fromdate = $Indate;
			$sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $Room_id . "'";
			$res6 = $this->db->query($sql6);
			foreach ($res6->result_array() as $row6) {
				$singlerent = $row6['singlerent'];
				$Doublerent = $row6['Doublerent'];
				$Triplerent = $row6['Triplerent'];
				$Quartertriplerent = $row6['Quartertriplerent'];
				$ChildRate = $row6['extrachildcharges'];
				if ($ChildRate == '') {
					$ChildRate = 0;
				}

				$startDateObj = date_create($Indate);
$endDateObj = date_create($todate);
$interval = date_diff($startDateObj, $endDateObj);
$totalDays = $interval->format("%a");



for ($d = 0; $d <= $totalDays; $d++) {
    $nextDate = date("Y/m/d", strtotime("+$d day", strtotime($Indate)));

    if ($d == 0) {
        $fromTime = $ARRtimee;
        $toTime = "23:59";
    } elseif ($d == $totalDays) {
        $fromTime = "00:00";
        $toTime = $Deptimee;
    } else {
        $fromTime = "00:00";
        $toTime = "23:59";
    }

	
$ins1 .= "	Insert into Trans_reserve_det1(resdate,typeid,noofrooms,fromtime,totime,refresdetid,fromdate,todate,ratetypeid)
values('" . $nextDate . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['noofrooms'][$i] . "',convert(VARCHAR,'" . $fromTime . "',108),convert(VARCHAR,'" . $toTime . "',108),
ident_current('Trans_reserve_det'),'" . $fromdate . "','" . $todate . "','" . $_REQUEST['RateCode'][$i] . "')";



}



		

				// $Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
			}
		}

		$result = $this->db->query($ins1);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {

			  $resno = $_REQUEST['resno'];
			  $prefix = $_REQUEST['prefix'];
			
				   $check = "select tdet.fromdate, tdet.typeid, tdet.todate ,tdet.resid from Trans_reserve_mas mas 
					inner join Trans_reserve_det tdet on tdet.resid = mas.resid
					where mas.resno= '".$resno."' and mas.yearprefix = '".$prefix."' ";
			
			$checkqry = $this->db->query($check);
			foreach ($checkqry->result_array() as $ress) {
				// print_r($ress);
				$cid = $ress['fromdate'];
				$typeid = $ress['typeid'];
				$expcdate = $ress['todate'];
				$resid = $ress['resid'];
			}

			

		$aa_date = date_create($cid); 
		$l_date = date_create($expcdate);
		$diff = date_diff($aa_date, $l_date);
		$difference = $diff->format("%a");


		
		for ($i = 0; $i <= $difference; $i++) {
			
			$val = "exec roomavailability_validation '".$cid."','".$typeid."','".$resid."'";
			
	
			$validationResult = $this->db->query($val);
			$this->db->close();
			$this->db->reconnect();
			
			
			
			if ($validationResult) {
	 $insR = "exec Update_RoomAvailability  '" . $cid . "', '" . $typeid . "'";
				
				
			
				$execute = $this->db->query($insR);
				$this->db->close();
				$this->db->reconnect();
			}
			
			
			$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
			
			$this->db->close();
			$this->db->reconnect();
		}


		// rewservation ament


		$checkres = "select tdet.fromdate, tdet.typeid, tdet.todate ,tdet.resid from Trans_reserve_mas_log mas 
		inner join Trans_reserve_det_log tdet on tdet.resid = mas.resid
		where mas.resno= '".$resno."' and mas.yearprefix = '".$prefix."' ";

$checkqryres = $this->db->query($checkres);
foreach ($checkqryres->result_array() as $ress) {
	// print_r($ress);
	$cidr = $ress['fromdate'];
	$typeidr = $ress['typeid'];
	$expcdater = $ress['todate'];
	$residr = $ress['resid'];
}



$aa_dater = date_create($cidr); 
$l_dater = date_create($expcdater);
$diffr = date_diff($aa_dater, $l_dater);
$differencer = $diff->format("%a");



for ($i = 0; $i <= $differencer; $i++) {

$val = "exec roomavailability_validation '".$cidr."','".$typeidr."','".$residr."'";


$validationResult = $this->db->query($val);
$this->db->close();
$this->db->reconnect();



if ($validationResult) {
	
	$insR = "exec Update_RoomAvailability_reservation   '" . $cidr . "', '" . $typeidr . "','". $residr ."'";
	

	$execute = $this->db->query($insR);
	$this->db->close();
	$this->db->reconnect();
}


$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));

$this->db->close();
$this->db->reconnect();
}
		
			echo "success";
		} else {
			echo "failed";
		}
	}




	
		// 	$aa_date = date_create($cid); 
		// 	$l_date = date_create($expcdate);
		// 	$diff = date_diff($aa_date, $l_date);
		// 	$difference = $diff->format("%a");
		// 	for ($i = 0; $i <= $difference; $i++) {
		// 		//    $val = "exec roomavailability_validation '".$cid."','".$typeid."','".$resid."'";
				 
         
        //             $insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";


		// 		$execute = $this->db->query($insR);

		// 		$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
		// 						$this->db->close();
		// $this->db->reconnect();
		// 	}


// 	public function ReservationEdit_save()
// 	{

// 		$date = date("Y-m-d");
// 		$time = date("H:i:s");
// 		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
// 		$res = $this->db->query($sql);
// 		$numberofrow = $res->num_rows();
// 		if ($numberofrow == 0) {
// 			$qry = " Exec_RuninggCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email'] . "','" . $_REQUEST['City_id'] . "', 'SAVE'";
// 			$resq = $this->db->query($qry);
// 			$this->db->close();
// 			$this->db->reconnect();
// 		}

// 		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
// 		$res1 = $this->db->query($sql1);
// 		foreach ($res1->result_array() as $rows) {
// 			$Customer_Id = $rows['Customer_Id'];
// 			$cus = "update Mas_Customer set Firstname = '" . $_REQUEST['Firstname'] . "', Mobile='" . $_REQUEST['Mobile'] . "', Email_ID='" . $_REQUEST['Email'] . "', Cityid='" . $_REQUEST['City_id'] . "', Titelid='" . $_REQUEST['Title'] . "' where Customer_Id = '" . $Customer_Id . "'";
// 			$cuss = $this->db->query($cus);
// 		}

// 		ob_start();
// 		@session_start();
// 		$ins1 = '';
// 		$ins2 = '';
// 		$ins3 = '';
// 		$ins = "Insert into Trans_reserve_mas(ResNo,Reserveby,Communicate,Resdate,cusid,totrooms,stat,userid,waitlist,duedate,travelagentid,onlinebookingno,age,discper,discount,muserid,company,yearprefix,isconfirm)
// 	  values(dbo.ResNo(),'" . User_id . "','P','" . $date . "','" . $Customer_Id . "','" . $_REQUEST['roomcount'] . "','','" . User_id . "','" . $_REQUEST['ReservationMode'] . "','" . $_REQUEST['duedate'] . "','" . $_REQUEST['travelagent_Id'] . "','" . $_REQUEST['bookingid'] . "','','" . $_REQUEST['discper'] . "','" . $_REQUEST['discamt'] . "','" . User_id . "',
// 	   '" . $_REQUEST['CompanyId'] . "',dbo.YearPrefix(),1)";
// 		$EXE = $this->db->query($ins);
// 		$rowcount = $_REQUEST['rowcount'];

// 		for ($i = 0; $i < $rowcount; $i++) {
// 			$Indate = str_replace('/', '-', $_REQUEST['Indate'][$i]);
// 			$Indate = date('Y/m/d', strtotime($Indate));
// 			$Indatee = date('Y/m/d', strtotime($Indate));
// 			$Indate1 = date('m/d/Y', strtotime($Indate));
// 			$todate = str_replace('/', '-', $_REQUEST['todate'][$i]);
// 			$todate = date('Y/m/d', strtotime($todate));
// 			$Company_Id = $_REQUEST['CompanyId'];
// 			if ($Company_Id == '') {
// 				$Company_Id = 0;
// 			}
// 			$ARRtimee = $_REQUEST['FHr'][$i] . ':' . $_REQUEST['FMi'][$i];
// 			$Deptimee = $_REQUEST['THr'][$i] . ':' . $_REQUEST['TMi'][$i];

// 			 $delete = "Delete temp_trans_roomdet_det_rent where roomid='" . $_REQUEST['Roomtype_id'][$i] . "'";

// 			 $this->db->query($delete);

		


// 		    $sql6 = "select * From mas_rateplan_det rtpdet
//                     inner join mas_rateplan rtmas on rtmas.rateplan_id = rtpdet.rateplan_id
//                     inner join mas_plantype pltype on pltype.PlanType_Id = rtmas.PlanType_Id 
//                     inner join Mas_RoomType rt on rt.RoomType_Id = rtmas.roomtype_id 
//                     left outer join mas_foodplan fp on fp.foodplan_id = rtpdet.foodplan_id
//                     where rt.roomtype_id = '".$_REQUEST['Roomtype_id'][$i]."' and pltype.PlanType_Id = '" . $_REQUEST['RateCode'][$i] . "' ";  

// 				$res6 = $this->db->query($sql6);
// 				$data = $res6->result();
// 				while ($Indatee <= $todate) {
	            
// 				foreach ($res6->result_array() as $row6) {
// 					$roomTypeId = $row6['RoomType_Id'];
// 					$Adults = $row6['Adults'];
// 					$Extrabedcount = $row6['AdultRate'];
// 					$singlerent = $row6['Single'];
// 					$Doublerent = $row6['Doubles'];
// 					$Triplerent = $row6['Triple'];
// 					$Quartertriplerent = $row6['Quadruple'];
// 					 $ins3 = "Insert into temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
// 			  values('" . $Indatee . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','R','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $row6['Extrabedamount'] . "','" . User_id . "',dbo.GrcNo(),'" . Hotel_Id . "')";
// 					$result = $this->db->query($ins3);
// 				}
// 				$Indatee = date("Y/m/d", strtotime("+1 day", strtotime($Indatee)));
			
// 			}

// 			$guestcharge = 0;
// 			// $roomTypeId = $_REQUEST['Roomtype_id'][$i] ?? null;

// 			// Commented by Deepan 

// 			// if ($roomTypeId) {
// 			// 	 $sql3 = "SELECT * FROM Mas_Room rm
// 			// 	 INNER JOIN Mas_Roomtype rt ON rt.RoomType_Id = rm.RoomType_Id
// 			// 	 WHERE rm.RoomType_Id = ?";
// 			// 	$res3 = $this->db->query($sql3, array($roomTypeId));
// 			// 	$row3 = $res3->row_array();
// 			// 	if (!empty($row3)) {
// 			// 	 	$Room_id = $row3['Room_Id'];
// 			// 		$Adults = $row3['Adults'];
// 			// 		$Extrabedamount = $row3['Extrabedamount'];
// 			// 	}

// 			// 	if ($Adults < $_REQUEST['Adults'][$i]) {
// 			// 		$guestcharge = $Extrabedamount;
// 			// 	}
// 			// }

// 			$RoomRent = $_REQUEST['Tariff'][$i] ?? 0;
// 			$Discamt = 0;
// 			$sql5 = "select dbo.Get_Taxid('" . $RoomRent . "','" . $RoomRent . "','" . $RoomRent . "','" . $guestcharge . "','" . $Discamt . "','" . $Indate1 . "') as Taxid";
// 			$res5 = $this->db->query($sql5);
// 			foreach ($res5->result_array() as $row5) {
// 				$Taxid = $row5['Taxid'];
// 			}

// 			$ins1 = $ins1 . "Insert into Trans_reserve_det(fromdate,noofrooms,noofpax,resid,fromtime,totime,todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,roomrent,totalroomrent,taxid,actpax)
// 			values(CONVERT(VARCHAR, '" . $_REQUEST['Indate'][$i] . "', 103),'" . $_REQUEST['noofrooms'][$i] . "','" . $_REQUEST['Adults'][$i] . "',ident_current('Trans_reserve_mas'),
// 			convert(VARCHAR,'" . $ARRtimee . "',108),convert(VARCHAR,'" . $Deptimee . "',108),CONVERT(VARCHAR, '" . $_REQUEST['todate'][$i] . "', 103),'0','0',
// 			'" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['RateCode'][$i] . "','" . $_REQUEST['foodplan'][$i] . "',
// 			'0','0.00','" . $RoomRent . "','" . $RoomRent . "','" . $Taxid . "','" . $_REQUEST['Adults'][$i] . "')";

// 			if ($_REQUEST['flag'] == 1) {
// 				$check = "select isnull(checkinrooms,0) as checkinroom, isnull(cancelrooms,0) as cancel,
// 				* from Trans_reserveenquiry_det where resenqdetid='" . $_REQUEST['Enqdetresid'][$i] . "'";
// 				$exec = $this->db->query($check);
// 				$status = '';
// 				foreach ($exec->result_array() as $check) {
// 					$resdetid = $check['resenqdetid'];
// 					$checkinrooms = $check['checkinroom'];
// 					// echo $checkinrooms = settype($checkinrooms, 'int');
// 					//  $cancelrooms = $check['cancel'];
// 					// echo $cancelrooms = settype($cancelrooms, 'int');
// 					//  echo$noof = $check['noofrooms'];
// 					$totalcount = $check['noofrooms'] - $check['checkinroom'] - $check['cancel'] - $_REQUEST['noofrooms'][$i];
// 					if ($totalcount <= 0) {
// 						$status = 'Y';
// 					}
// 				}
// 				$sql = "update trans_reserveenquiry_det set checkinrooms='" . $_REQUEST['noofrooms'][$i] . "' , stat='" . $status . "' where resenqdetid='" . $_REQUEST['Enqdetresid'][$i] . "'";
// 				$exe = $this->db->query($sql);
// 				$sql1 = "update trans_reserveenquiry_mas set stat='Y' where Resenqid='" . $_REQUEST['Enqresid'][$i] . "'";
// 				$res = $this->db->query($sql1);
// 			}

// 			$fromdate = $Indate;
// 		   $sql6 = "select * from temp_trans_roomdet_det_rent where roomid='" . $roomTypeId . "'";
// 			$res6 = $this->db->query($sql6);
	
// 			$currentDate = date("Y/m/d", strtotime($Indate));
// $todate = date("Y/m/d", strtotime($todate));

// // Fetch rents just once if needed
// $row6 = $res6->row_array(); // If you expect only one row
// $singlerent = $row6['singlerent'];
// $Doublerent = $row6['Doublerent'];
// $Triplerent = $row6['Triplerent'];
// $Quartertriplerent = $row6['Quartertriplerent'];
// $ChildRate = $row6['extrachildcharges'] ?: 0;

// // Calculate number of days
// $startDateObj = date_create($Indate);
// $endDateObj = date_create($todate);
// $interval = date_diff($startDateObj, $endDateObj);
// $totalDays = $interval->format("%a");

// for ($d = 0; $d <= $totalDays; $d++) {
//     $nextDate = date("Y/m/d", strtotime("+$d day", strtotime($Indate)));

//     if ($d == 0) {
//         $fromTime = $ARRtimee;
//         $toTime = "23:59";
//     } elseif ($d == $totalDays) {
//         $fromTime = "00:00";
//         $toTime = $Deptimee;
//     } else {
//         $fromTime = "00:00";
//         $toTime = "23:59";
//     }

//     $ins1 .= "INSERT INTO Trans_reserve_det1 (resdate, typeid, noofrooms, fromtime, totime, refresdetid, fromdate, todate, ratetypeid) 
//     VALUES (
//         '$nextDate',
//         '" . $_REQUEST['Roomtype_id'][$i] . "',
//         '" . $_REQUEST['noofrooms'][$i] . "',
//         convert(VARCHAR,'$fromTime',108),
//         convert(VARCHAR,'$toTime',108),
//         IDENT_CURRENT('Trans_reserve_det'),
//         '$currentDate',
//         '$todate',
//         '" . $_REQUEST['RateCode'][$i] . "'
//     );";
// }
			

 


// 		}
	

// 		$result = $this->db->query($ins1);
// 		$this->db->close();
// 		$this->db->reconnect();
// 		if ($result) {

// 			$check = "select isnull(enablewhatsappsmsforres,0) as res from extraoption";
// 			$check = $this->db->query($check);
// 			foreach ($check->result_array() as $r) {
// 				$enableRes = $r['res'];
// 			}
// 			if ($enableRes == 1) {
// 				$sql = "select det.roomrent,mas.resno,mas.resdate,mr.roomtype,mt.title+'.'+mc.Firstname+' '+mc.Lastname as guestname,
// 					mc.mobile as mob,( select company from mas_hotel where hotel_id='" . Hotel_Id . "') as companyname,
// 					mh.address as haddress,mh.mobileno as hmobile,mh.Pincode as pin, mh.address1 as haddress1,* from trans_reserve_mas mas
// 					inner join trans_reserve_det det on mas.Resid = det.resid
// 					inner join Mas_RoomType mr on mr.roomtype_id=det.typeid
// 					inner join mas_customer mc on mc.Customer_Id = mas.cusid
// 					inner join mas_title mt on mt.Titleid = mc.Titelid
// 					inner join Mas_Hotel mh on mh.Hotel_Id='" . Hotel_Id . "'
// 					where mas.resid=ident_current('trans_reserve_mas')";
// 				$res = $this->db->query($sql);
// 				$roomrent = '';
// 				$roomtype = '';
// 				$resno = '';
// 				$name = '';
// 				$resdate = '';
// 				$formatter = ' , ';
// 				$noofadults = '';
// 				$noofrooms = '';
// 				$fromdate = '';
// 				$time = '';
// 				$todate = '';
// 				$count = 1;
// 				foreach ($res->result_array() as $row) {
// 					if ($count > 1) {

// 						$roomtype .= $formatter . $row['roomtype'];
// 						$roomrent .= $formatter . $row['roomrent'];
// 						$noofadults .= $formatter . $row['noofpax'];
// 						$noofrooms .= $formatter . $row['noofrooms'];
// 						$time .= $formatter . date('H:i', strtotime($row['fromtime']));
// 						$fromdate .= $formatter . date('d-m-Y', strtotime($row['fromdate']));
// 						$todate .= $formatter . date('d-m-Y', strtotime($row['todate']));
// 					} else {
// 						$roomrent = $row['roomrent'];
// 						$roomtype = $row['roomtype'];
// 						$resno = $row['resno'];
// 						$name = $row['guestname'];
// 						$mobile = $row['mob'];
// 						$company = $row['companyname'];
// 						$resdate = date('d-m-Y', strtotime($row['resdate']));
// 						$haddress = $row['haddress'];
// 						$hmobile = $row['hmobile'];
// 						$hpincode = $row['haddress1'] . '-' . $row['pin'];
// 						$noofadults = $row['noofpax'];
// 						$noofrooms = $row['noofrooms'];
// 						$time = date('H:i', strtotime($row['fromtime']));
// 						$fromdate = date('d-m-Y', strtotime($row['fromdate']));
// 						$todate = date('d-m-Y', strtotime($row['todate']));
// 					}

// 					$count++;
// 				}


// 				$temqury = "select Template,campaign from mas_smsmessage where  isnull(reserveGuest,0)='1'";
// 				$smsTemp = $this->db->query($temqury);
// 				$i = 1;
// 				$detmsg = '';
// 				foreach ($smsTemp->result_array() as $row) {

// 					$msg = $row['Template'];
// 					$smstype = 'GCRE';
// 					$campaignname = $row['campaign'];
// 					$string = $msg;
// 					$strlen = strlen($string);
// 					$ii = 0;
// 					$count = 0;
// 					while ($ii < $strlen) {
// 						$newstr = '';
// 						if ($string[$ii] == '*') {
// 							$jj = $ii;
// 							while ($string[$jj + 1] != '*' && $jj < $strlen) {
// 								$newstr .= $string[$jj + 1];
// 								$jj++;
// 							}
// 							$ii = $jj + 1;
// 							$count = $count + 1;
// 							// insert query here..
// 							$newstrvalue = '';

// 							if ('CustomerName' == $newstr) {
// 								$newstrvalue = $name;
// 							} elseif ('RoomType' == $newstr) {
// 								$newstrvalue = $roomtype;
// 							} else if ('noofrooms' == $newstr) {
// 								$newstrvalue = $noofrooms;
// 							} else if ('ResNo' == $newstr) {
// 								$newstrvalue = $resno;
// 							} elseif ('Reserve Date' == $newstr) {
// 								$newstrvalue = $resdate;
// 							} elseif ('noofpersons' == $newstr) {
// 								$newstrvalue = $noofadults;
// 							} elseif ('fromdate' == $newstr) {
// 								$newstrvalue = $fromdate;
// 							} elseif ('todate' == $newstr) {
// 								$newstrvalue = $todate;
// 							} elseif ('time' == $newstr) {
// 								$newstrvalue = $time;
// 							} elseif ('HotelAddress' == $newstr) {
// 								$newstrvalue = $haddress;
// 							} elseif ('HotelPinCode' == $newstr) {
// 								$newstrvalue = $hpincode;
// 							} elseif ('ContactNo' == $newstr) {
// 								$newstrvalue = $hmobile;
// 							}

// 							$detmsg = $detmsg . "
// 						insert into Outbox_smsval(msgid,smstype,variablename,Variableval,Smsval)
// 						values(ident_current('outbox'),'" . $smstype . "','" . $newstr . "',
// 						'" . $count . "', '" . $newstrvalue . "')";

// 							// echo $count;
// 							// echo $newstr;
// 						}
// 						$ii++;
// 					}

// 					$msg = str_replace('*CustomerName*', $name, $msg);
// 					$msg = str_replace('*RoomType*', $roomtype, $msg);
// 					$msg = str_replace('*ResNo*', $resno, $msg);
// 					$msg = str_replace('*Reserve Date*', $resdate, $msg);
// 					$msg = str_replace('*noofpersons*', $noofadults, $msg);
// 					$msg = str_replace('*noofrooms*', $noofrooms, $msg);
// 					$msg = str_replace('*fromdate*', $fromdate, $msg);
// 					$msg = str_replace('*todate*', $todate, $msg);
// 					$msg = str_replace('*time*', $time, $msg);
// 					$msg = str_replace('*HotelAddress*', $haddress, $msg);
// 					$msg = str_replace('*ContactNo*', $hmobile, $msg);
// 					$msg = str_replace('*HotelPinCode*', $hpincode, $msg);


// 					$inss = "insert into outbox (MobileNumber,SMSMessage,DateCreated,campaign)
// 					values('" . $mobile . "','" . $msg . "',convert(VARCHAR,getdate(),20),'" . $campaignname . "')";
// 					$execins = $this->db->query($inss . $detmsg);

					
// 					$this->db->close();
// 					$this->db->reconnect();
// 				}

// 			}

			
// 				   $check = "select tdet.fromdate, tdet.typeid, tdet.todate from Trans_reserve_mas mas 
// 					inner join Trans_reserve_det tdet on tdet.resdetid = mas.resid
// 					where mas.resid= IDENT_CURRENT('Trans_reserve_det')";
// 			$checkqry = $this->db->query($check);
// 			foreach ($checkqry->result_array() as $ress) {
// 				$cid = $ress['fromdate'];
// 				$typeid = $ress['typeid'];
// 				$expcdate = $ress['todate'];
// 			}

// 			$aa_date = date_create($cid); 
// 			$l_date = date_create($expcdate);
// 			$diff = date_diff($aa_date, $l_date);
// 			$difference = $diff->format("%a");
// 			for ($i = 0; $i <= $difference; $i++) {
         
// 			$insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";


// 				$execute = $this->db->query($insR);
// 					$this->db->close();
// 		$this->db->reconnect();

// 				$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
// 			}

	
// 			echo "success";
// 		} else {
// 			echo "failed";
// 		}
// 	}



	public function RessAmendment($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'RessAmendment', 'ID' => $ID, 'BUT' => $BUT);
	
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function AmendmentList($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'AmendmentList', 'ID' => $ID, 'BUT' => $BUT);
		$data['back'] = "Transaction/RoomStatusOnline";

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function Reservation_($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Reservation_', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function ReservationAdvances_save()
	{
		date_default_timezone_set('Asia/Kolkata');

			      $paymode = $_REQUEST['paymode'] ?? '';

$sql = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = '".$paymode."'";
$paymode_row = $this->db->query($sql)->row_array();

$pay = $paymode_row['PayMode_Id'] ?? null;

		if ($_REQUEST["resvalue"] == 'SAVE') {
			$qry = "exec Exec_ResAdvance '" . $_REQUEST['roomid1'] . "' ,'" . $_REQUEST['Amount'] . "','" . $pay . "','" . date('Y-m-d') . "','" . @$_REQUEST['bank'] . "','" . @$_REQUEST['cardnumber'] . "','" . @$_REQUEST['typeid'] . "','" . @$_REQUEST['validate'] . "'," . User_id . ",'" . $_REQUEST['Remark'] . "','" . $_REQUEST['idv'] . "','" . str_replace(" ", "", $_REQUEST['resvalue']) . "' ";
		} else {
			$qry = "exec Exec_ResAdvance '" . $_REQUEST['roomid1'] . "' ,'" . $_REQUEST['Amount'] . "','" . $pay . "','" . date('Y-m-d') . "','" . @$_REQUEST['bank'] . "','" . @$_REQUEST['cardnumber'] . "','" . @$_REQUEST['typeid'] . "','" . @$_REQUEST['validate'] . "'," . User_id . ",'" . $_REQUEST['Remark'] . "','" . $_REQUEST['idv'] . "','" . str_replace(" ", "", $_REQUEST['resvalue']) . "' ";
		}
		$res = $this->db->query($qry);
		if ($res) {
			foreach ($res->result_array() as $row) {
				echo $id = $row['id'];
			}
		} else {
			echo "failure";
		}
	}


	public function GetReservationGuestDetailsTypeid()
	{
		$sql = " select det.typeid,mr.RoomType from Trans_Reserve_mas mas 
		Inner join Mas_Customer cus on cus.Customer_Id=mas.cusid
		inner join Trans_Reserve_Det  det on det.resid = mas.resid
		inner join mas_roomtype mr on mr.RoomType_Id = det.typeid
		 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
		left outer join trans_reserveadd_mas rmas on rmas.resid=mas.resid
		left outer join Trans_Receipt_mas rtmas on rtmas.Billid=rmas.resaddid
		where mas.resid='" . $_REQUEST['Resid'] . "' and isnull(rtmas.cancel,0)=0
		group by  mr.RoomType,det.typeid ";
		$ress = $this->db->query($sql);

		echo '<option value="">--Room Type--</option>';
		foreach ($ress->result_array() as $row) {
			echo '<option value="' . $row['typeid'] . '"	selected >' . $row['RoomType'] . '</option>';
		}
	}

	public function GetReservationGuestDetailsAdvance()
	{
		$sql = " select sum(rtmas.Amount) as advance from Trans_Reserve_mas mas 
		Inner join Mas_Customer cus on cus.Customer_Id=mas.cusid
		inner join Trans_Reserve_Det  det on det.resid = mas.resid
		inner join mas_roomtype mr on mr.RoomType_Id = det.typeid
		 Inner join Mas_Title mt on mt.Titleid=cus.Titelid
		left outer join trans_reserveadd_mas rmas on rmas.resid=mas.resid
		left outer join Trans_Receipt_mas rtmas on rtmas.Billid=rmas.resaddid
		where mas.resid='" . $_REQUEST['Resid'] . "' and isnull(rtmas.cancel,0)=0
		and det.typeid='" . $_REQUEST['type'] . "'
		and rtmas.receipttype='A'
		group by  mr.RoomType,det.typeid ";
		$ress = $this->db->query($sql);
		foreach ($ress->result_array() as $row) {
			echo $amount = $row['advance'];
		}
	}


	public function toroomSettle()
{
	$sql = "SELECT mr.RoomNo AS bank, rs.Roomid AS Bankid 
	FROM room_status rs
	INNER JOIN mas_room mr ON rs.Roomid = mr.Room_Id
	WHERE rs.billsettle = 0 
	  AND isnull(rs.status,'') = 'Y' 
	  AND isnull(rs.notready,1) = 0 
	  AND isnull(rs.mblock,0) <> 1 
	  AND isnull(rs.foblock,0) <> 1";

    $ex = $this->db->query($sql);


    echo '<select name="toroom" id="toroom">';
    echo '<option value="">--To Room--</option>';

    foreach ($ex->result_array() as $row) {
        echo '<option value="' . $row["Bankid"] . '">' . $row["bank"] . '</option>';
    }

    echo '</select>';
}

	


	public function Checktoroomid()
	{


		$qry = "select * from trans_checkout_mas cm 
	inner join room_status rs on rs.roomid = cm.toroomid
	where rs.status <>'N' and rs.billsettle<>1 and Checkoutid='" . $_REQUEST['toroomid'] . "'";
		$res = $this->db->query($qry);
		$no = $res->num_rows();
		if ($no != 0) {
			echo $id = 1;
		} else {
			echo $id = 0;
		}
	}



	public function refundupdate()
	{
		$sql = "exec refundupdate '" . $_REQUEST['id'] . "'";
		$exe = $this->db->query($sql);
		if ($exe) {
			echo "success";
		} else {
			echo "failure";
		}
	}


	public function ResRoomCancel($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ResRoomCancel', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function ResRoomCancelList($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ResRoomCancelList', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function ReservetionRoomcancel()
	{
		$status = '';
		$checkinrooms = $_REQUEST['checkinrooms'];
		$cancelrooms = $_REQUEST['cancelrooms'];
		$noofrooms = $_REQUEST['total'];
		$resdetid = $_REQUEST['resdetid'];
		$reason = $_REQUEST['Reason'];
		$rooms = $_REQUEST['Rooms'];
		$totalCountRoom = $checkinrooms + $cancelrooms + $rooms;
		if ($noofrooms == $totalCountRoom) {
			$status = 'Y';
		}
		$sql = "update trans_reserve_det set cancelrooms='" . $rooms . "' , stat='" . $status . "', cancelreason='" . $reason . "' where resdetid='" . $resdetid . "'";

		$exe = $this->db->query($sql);
		if ($exe) {
			echo "Success";
		} else {
			echo "Error";
		}
	}

	public function ReservationEnquiry($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReservationEnquiry', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function EnquiryAmendment($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'EnquiryAmendment', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function ResEnquiry($ID = -1)
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ResEnquiry', 'ID' => $ID);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function EnquiryCancel($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'EnquiryCancel', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function ReservationEnquiry_save()
	{
		date_default_timezone_set('Asia/Kolkata');

		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuninggCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email'] . "','" . $_REQUEST['City_id'] . "', 'SAVE'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
			$cus = "update Mas_Customer set Firstname = '" . $_REQUEST['Firstname'] . "',
		  Mobile='" . $_REQUEST['Mobile'] . "', Email_ID='" . $_REQUEST['Email'] . "', 
		  Cityid='" . $_REQUEST['City_id'] . "', Titelid='" . $_REQUEST['Title'] . "' ,
		  HomeAddress1 ='" . $_REQUEST['Address'] . "', Homepincode='" . $_REQUEST['Pincode'] . "',
		  ResidentialPhone ='" . $_REQUEST['Phone'] . "',age='" . $_REQUEST['Age'] . "'
		  where Customer_Id = '" . $Customer_Id . "'";
			$cuss = $this->db->query($cus);
		}

		ob_start();
		@session_start();
		$ins1 = '';
		$rowcount = $_REQUEST['rowcount'];
		$Company_Id = $_REQUEST['CompanyId'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}


		$ins = "Insert into Trans_ReserveEnquiry_mas(ResEnqNo,Communicate,Resenqdate,cusid,totamt,remarks,
	  totrooms,userid,waitlist,bookerid,travelagentid,flightid,company,age,Reserveby,yearprefix
	  )values('" . $_REQUEST['resno'] . "','P','" . $date . "','" . $Customer_Id . "','0','" . $_REQUEST['Remarks'] . "',
	  '" . $_REQUEST['roomcount'] . "','" . User_id . "','0','0','0','0','" . $Company_Id . "','','" . $_REQUEST['ConPerson'] . "',dbo.YearPrefix())";
		$EXE = $this->db->query($ins);


		for ($i = 0; $i < $rowcount; $i++) {
			$ARRtimee = $_REQUEST['FHr'][$i] . ':' . $_REQUEST['FMi'][$i];

			$Deptimee = $_REQUEST['THr'][$i] . ':' . $_REQUEST['TMi'][$i];

			$ins1 = $ins1 . "Insert into Trans_ReserveEnquiry_det(fromdate,noofrooms,noofpax,resenqid,fromtime,totime,
		todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,actpax,roomrent)values(CONVERT(VARCHAR, '" . $_REQUEST['Indate'][$i] . "', 103),
		'" . $_REQUEST['noofrooms'][$i] . "','" . $_REQUEST['Adults'][$i] . "',ident_current('Trans_ReserveEnquiry_mas'),
		convert(VARCHAR,'" . $ARRtimee . "',108),convert(VARCHAR,'" . $Deptimee . "',108),CONVERT(VARCHAR, 
		'" . $_REQUEST['todate'][$i] . "', 103),'0','0','" . $_REQUEST['Roomtype_id'][$i] . "',
		'" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['RateCode'][$i] . "','" . $_REQUEST['foodplan'][$i] . "',
		'0','0.00','" . $_REQUEST['Adults'][$i] . "','" . $_REQUEST['Tariff'][$i] . "' )";
		}

		$result = $this->db->query($ins1);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {
			echo "success";
		} else {
			echo "failed";
		}
	}



	public function EnquiryAmendmentSave()
	{

		date_default_timezone_set('Asia/Kolkata');

		$date = date("Y-m-d");
		$time = date("H:i:s");
		$sql = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res = $this->db->query($sql);
		$numberofrow = $res->num_rows();
		if ($numberofrow == 0) {
			$qry = " Exec_RuninggCustomer '" . $_REQUEST['Firstname'] . "','" . $_REQUEST['Title'] . "','" . $_REQUEST['Mobile'] . "','" . $_REQUEST['Email'] . "','" . $_REQUEST['City_id'] . "', 'SAVE'";
			$resq = $this->db->query($qry);
			$this->db->close();
			$this->db->reconnect();
		}

		$sql1 = "select * from Mas_Customer where Mobile='" . $_REQUEST['Mobile'] . "'";
		$res1 = $this->db->query($sql1);
		foreach ($res1->result_array() as $rows) {
			$Customer_Id = $rows['Customer_Id'];
			$cus = "update Mas_Customer set Firstname = '" . $_REQUEST['Firstname'] . "',
		  Mobile='" . $_REQUEST['Mobile'] . "', Email_ID='" . $_REQUEST['Email'] . "', 
		  Cityid='" . $_REQUEST['City_id'] . "', Titelid='" . $_REQUEST['Title'] . "' ,
		  HomeAddress1 ='" . $_REQUEST['Address'] . "', Homepincode='" . $_REQUEST['Pincode'] . "',
		  ResidentialPhone ='" . $_REQUEST['Phone'] . "', age='" . $_REQUEST['Age'] . "'
		  where Customer_Id = '" . $Customer_Id . "'";
			$cuss = $this->db->query($cus);
		}


		$dele = "Delete from Trans_reserveenquiry_mas where Resenqid='" . $_REQUEST['resid'] . "'";
		$ex = $this->db->query($dele);
		$dele1 = "Delete from Trans_reserveenquiry_det where resenqid='" . $_REQUEST['resid'] . "'";
		$ex1 = $this->db->query($dele1);

		ob_start();
		@session_start();
		$ins1 = '';
		$rowcount = $_REQUEST['rowcount'];
		$Company_Id = $_REQUEST['CompanyId'];
		if ($Company_Id == '') {
			$Company_Id = 0;
		}


		$ins = "Insert into Trans_ReserveEnquiry_mas(ResEnqNo,Communicate,Resenqdate,cusid,totamt,remarks,
	  totrooms,userid,waitlist,bookerid,travelagentid,flightid,company,age,Reserveby,yearprefix
	  )values('" . $_REQUEST['resno'] . "','P','" . $date . "','" . $Customer_Id . "','0','" . $_REQUEST['Remarks'] . "',
	  '" . $_REQUEST['roomcount'] . "','" . User_id . "','0','0','0','0','" . $Company_Id . "','','" . $_REQUEST['ConPerson'] . "',dbo.YearPrefix())";
		$EXE = $this->db->query($ins);


		for ($i = 0; $i < $rowcount; $i++) {
			$ARRtimee = $_REQUEST['FHr'][$i] . ':' . $_REQUEST['FMi'][$i];

			$Deptimee = $_REQUEST['THr'][$i] . ':' . $_REQUEST['TMi'][$i];

			$ins1 = $ins1 . "Insert into Trans_ReserveEnquiry_det(fromdate,noofrooms,noofpax,resenqid,fromtime,totime,
		todate,advance,payid,typeid,tarifftype,ratetypeid,planid,plancharges,plandisc,actpax,roomrent)values(CONVERT(VARCHAR, '" . $_REQUEST['Indate'][$i] . "', 103),
		'" . $_REQUEST['noofrooms'][$i] . "','" . $_REQUEST['Adults'][$i] . "',ident_current('Trans_ReserveEnquiry_mas'),
		convert(VARCHAR,'" . $ARRtimee . "',108),convert(VARCHAR,'" . $Deptimee . "',108),CONVERT(VARCHAR, 
		'" . $_REQUEST['todate'][$i] . "', 103),'0','0','" . $_REQUEST['Roomtype_id'][$i] . "',
		'" . $_REQUEST['Roomtype_id'][$i] . "','" . $_REQUEST['RateCode'][$i] . "','" . $_REQUEST['foodplan'][$i] . "',
		'0','0.00','" . $_REQUEST['Adults'][$i] . "','" . $_REQUEST['Tariff'][$i] . "')";
		}

		$result = $this->db->query($ins1);
		$this->db->close();
		$this->db->reconnect();
		if ($result) {
			echo "success";
		} else {
			echo "failed";
		}
	}



	public function EnquiryCancelSave()
	{
		$status = '';

		$cancelrooms = $_REQUEST['total'];
		$resdetid = $_REQUEST['resenqdetid'];
		$reason = $_REQUEST['Reason'];
		$sql = "update trans_reserveenquiry_det set cancelrooms='" . $cancelrooms . "' , stat='Y', cancelreason='" . $reason . "' where resenqdetid='" . $resdetid . "'";
		$exe = $this->db->query($sql);

		$check = "select * from Trans_reserveenquiry_det where resenqid='" . $_REQUEST['resid'] . "' and isnull(stat, '')<>'Y'";
		$exec = $this->db->query($check);
		$no = $exec->num_rows();
		if ($no == 0) {
			$sql1 = "update trans_reserveenquiry_mas set stat='C' where Resenqid='" . $_REQUEST['resid'] . "'";
			$res = $this->db->query($sql1);
		}

		if ($exe) {
			echo "Success";
		} else {
			echo "Error";
		}
	}


	public function ReinstateCheckoutSave()
	{
		date_default_timezone_set('Asia/Kolkata');
		$checkoutid = $_REQUEST['checkoutid'];
		$guest = $_REQUEST['guest'];
		$reason = $_REQUEST['Reason'];
		$date = date('Y-m-d');
		$selqry = "select * from room_status where grcid = '".$_REQUEST['grcid']."'";
		$sel = $this->db->query($selqry)->result_array();

		$del = "";
		 $del1 = "";
		 $del2 = "";
		$sql = ""; 
		$sql1 = "";
		$rsdetqry = "";
		$ins9 = "";

		foreach($sel as $selrooms){

		$sql3 = "exec Exec_Temp_Trans_credit_entry   '" . $selrooms['Roomid'] . "', '" . $date . "'";
		$res3 = $this->db->query($sql3);
		$del .= "delete from trans_credit_entry where roomgrcid='" . $selrooms['roomgrcid'] . "'  
		and grcid='" . $selrooms['grcid'] . "' and creditdate='" . $date . "' and 
		Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead = 'SGST')";
		$del1 .= "delete from trans_credit_entry where roomgrcid='" . $selrooms['roomgrcid'] . "'  
		and grcid='" . $selrooms['grcid'] . "' and creditdate='" . $date . "' and 
		Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead = 'CGST')";
		$del2 .= "delete from trans_credit_entry where roomgrcid='" . $selrooms['roomgrcid'] . "'  
		and grcid='" . $selrooms['grcid'] . "' and creditdate='" . $date . "' and 
		Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead = 'ROOM RENT')";
		// $del_res = $this->db->query($del);
		// $del_res = $this->db->query($del1);
		// $del_res = $this->db->query($del2);
		$sql .= "update trans_checkout_mas set cancelflag='1' , 
		reason = '" . $reason . "' , canceluserid='" . User_id . "' where checkoutid='" . $checkoutid . "'";
		// $this->db->query($sql);
		$sql1 .= "update room_status set billsettle='0' where roomgrcid='" . $selrooms['roomgrcid'] . "'
		 and grcid='" . $selrooms['grcid'] . "'";
	


		 $setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

		 $set = $this->db->query($setqry)->row_array();
 
	 
 
		 if($set['Enablebeehivesroominventoryintergration'] == 1) {
 
			 $fromroomnoqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
			 inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
			 inner join room_status rs on rs.Roomid = mr.Room_Id
			 WHERE mr.Room_id = '".$selrooms['Roomid']."'";
 
			 $fromroomno = $this->db->query($fromroomnoqry)->row_array();
 
		   $rsdetqry .= "INSERT INTO trans_roomstatus_det
		 (fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,updateflg)
		 VALUES ('".$fromroomno['RoomNo']."','".$selrooms['Roomid']."','".$fromroomno['RoomType_Id']."','".$fromroomno['grcid']."','".$fromroomno['roomgrcid']."','".$fromroomno['RoomType']."','".date("Y-m-d") ."','".date("H:i:s") ."','','','CHECKOUT CANCEL/RE-CHECKIN','0'); ";
 
		 }
 

		 
	$setqry = "select enablepower from extraoption";

	$set = $this->db->query($setqry)->row_array();

	if($set['enablepower'] == 1) {
           
		
		 $select ="select RoomNo from mas_room where Room_Id = '".$selrooms['Roomid']."'";

		 $roomnumber = $this->db->query($select)->row_array();
	   
	   
		 $otherDB = $this->load->database('another_db', TRUE);
	   
	   
		 $selroom = "
		 SELECT mc.ControlType_Id as control, md.Device
		 FROM mas_control mc
		 INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
		 INNER JOIN mas_device md ON mc.Device = md.Device
		 WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
		 
		 $result = $otherDB->query($selroom)->result_array();

	
		 foreach($result as $res){

				   
			$control = $res['control'];
			$Device = $res['Device'];
			
			$process = "select Status_Id from mas_status where upper(status) = 'CHECKIN'";
		  
			$process_id = $otherDB->query($process)->row_array();
		  
			
			 $ins9 .= "
			INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
			VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$selrooms['roomgrcid']."','Reinstate Checkout','" . $date . "',convert(VARCHAR,getdate(),108),'".$guest."','".$guest."','0')";
		  
		 }

		}
	}


		    echo "BEGIN Try ";
			echo "BEGIN Transaction ";
			echo "BEGIN Tran ";
			// echo $sql3;
			echo $del;
			echo $del1;
			echo $del2;
			echo $sql;
			echo $sql1;
			echo $ins9;
			echo $rsdetqry;
			echo " If @@error<>0 Rollback Tran else Commit Tran ";
			echo "COMMIT ";
			echo "end try ";
			echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
			echo "END CATCH ";
			$sqc = ob_get_clean();
		 	$sq = "" . $sqc . "";
			$result = $this->db->query($sq);
			$this->db->close();
			$this->db->reconnect();

		
		if ($result) {
			
			$check = "select room.roomgrcid,mas.CheckinDate, room.typeid, mas.ExpDate from Trans_Checkin_mas mas 
			inner join Trans_Roomdet_det room on  room.grcid = mas.Grcid
			where mas.Grcid= IDENT_CURRENT('Trans_checkin_mas')";
			$checkqry = $this->db->query($check);
			foreach ($checkqry->result_array() as $ress) {
				
				$cid = $ress['CheckinDate'];
				$typeid = $ress['typeid'];
				$expcdate = $ress['ExpDate'];
				$roomgrcid = $ress['roomgrcid'];
			}

			
			$aa_date = date_create($cid); 
			$l_date = date_create($expcdate);
			$diff = date_diff($aa_date, $l_date);
			$difference = $diff->format("%a");

			for ($i = 0; $i <= $difference; $i++) {
			
				  $val = "exec roomavailability_validation '".$cid."','".$typeid."'";
				
				
				$validationResult = $this->db->query($val);
				$this->db->close();
				$this->db->reconnect();

				// foreach($validationResult->result_array() as $valid ){
				// 	$availrooms = $valid['Avail'];

					if($validationResult){
						$insav = "exec Update_RoomAvailability   '" . $cid . "', '" . $typeid . "'";
					
						$execute = $this->db->query($insav);
						$this->db->close();
						$this->db->reconnect();
					}
						
				
				// }

	
				
			
				$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
				
				
			}

			

			// for ($i = 0; $i <= $difference; $i++) {
			// $insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";
		    //   $execute = $this->db->query($insR);

			// 	$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
			// }
			echo "Success";

		} else {
			echo "Fail";
		}
	}

	public function ReinstateCheckout($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReinstateCheckout', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	public function ReinstateSettlement($ID = -1, $BUT = 'SAVE')
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'ReinstateSettlement', 'ID' => $ID, 'BUT' => $BUT);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}

	// public function ReinstateSettlementSave()
	// {

	//  	$checkoutid = $_REQUEST['checkoutid'];
	// 	$reason = $_REQUEST['Reason'];
	// 	$checkoutdate = $_REQUEST['checkoutdate'];		
	// 	$curDate = date('Y-m-d');
	// 	$actroomrent = 0;
	// 	$act = 0;
	// 	$net = 0;
	// 	$other = 0;
	//  	$check = "select * from room_status where Roomid='" . $_REQUEST['roomid'] . "' and status='Y' and  notready=0
	// 	and blocked=0 and mblock=0 and foblock=0";
	// 	$res = $this->db->query($check);
	// 	 $no = $res->num_rows();
	// 	if ($no == 0) {

	// 		  $sql = "update trans_checkout_mas set  reason = '" . $reason . "', canceluserid='" . User_id . "',reinstateuserid ='" . User_id . "', canceldate='" . date('Y-m-d') . "',canceltime='" . date('H:i:s') . "', reinstate='1' , cancelflag= '1', Settle = '0', reinstatedate='" . date('Y-m-d') . "' where checkoutid='" . $checkoutid . "'";
	// 		$this->db->query($sql);
	// 		$sql1 = "update room_status set notready='0', status='Y' , roomgrcid='" . $_REQUEST['roomgrcid'] . "', 
	// 		grcid='" . $_REQUEST['grcid'] . "', billsettle='0' where Roomid='" . $_REQUEST['roomid'] . "'";
	// 		$exec = $this->db->query($sql1);

	// 		if ($checkoutdate == $curDate) 
	// 		{
	// 			$qry = "select * from Trans_credit_entry where Roomid='" . $_REQUEST['roomid'] . "' and roomgrcid='" . $_REQUEST['roomgrcid'] . "' and  Creditheadid in (1,2,3) and creditdate = '".$curDate."' ";
	// 			$exe = $this->db->query($qry);
	// 			foreach ($exe->result_array() as $row) 
	// 			{
	// 				if ($row['Actroomrent'] != '') 
	// 				{
	// 					$actroomrent = $row['Actroomrent'];
	// 				}

	// 				if ($row['Nettarrifamount'] != '')
	// 				 {
	// 					$net = $row['Nettarrifamount'];
	// 				}

	// 				if ($row['otherAmount'] != '')
	// 				 {
	// 					$other = $row['otherAmount'];
	// 				}
	// 				if ($row['actrackrate'] != '') 
	// 				{
	// 					$act = $row['actrackrate'];
	// 				}

	// 				$ins = "insert into trans_credit_entry_log(CreditNo, CreditDate, Roomid, Grcid,Creditheadid,Amount,
	// 				roomgrcid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,groupno,Actroomrent,
	// 				Nettarrifamount,Ratetypeid,actrackrate,canceldate)values(dbo.Credit_Entry_Log_No(),'" . $row['CreditDate'] . "','" . $_REQUEST['roomid'] . "',
	// 				'" . $_REQUEST['grcid'] . "','" . $row['Creditheadid'] . "','" . $row['Amount'] . "','" . $_REQUEST['roomgrcid'] . "',
	// 				'" . $row['crtime'] . "','" . $other . "','" . User_id . "','" . $row['tarrifftype'] . "','" . $row['tarriffsetupid'] . "',
	// 				'" . $row['groupno'] . "','" . $actroomrent . "','" . $net . "','" . $row['Ratetypeid'] . "','" . $act . "',
	// 				'" . date('Y-m-d') . "')";
	// 				$this->db->query($ins);

	// 			 	$tempins = "insert into temp_trans_credit_entry(CreditNo, CreditDate, Roomid, Grcid,Creditheadid,Amount,
	// 				roomgrcid,otherAmount,UserID,groupno,Actroomrent,
	// 				Nettarrifamount,Ratetypeid,actrackrate)values(dbo.Credit_Entry_Log_No(),'" . $row['CreditDate'] . "','" . $_REQUEST['roomid'] . "',
	// 				'" . $_REQUEST['grcid'] . "','" . $row['Creditheadid'] . "','" . $row['Amount'] . "','" . $_REQUEST['roomgrcid'] . "',
	// 				'" . $other . "','" . User_id . "',
	// 				'" . $row['groupno'] . "','" . $actroomrent . "','" . $net . "','" . $row['Ratetypeid'] . "','" . $act . "',
	// 				)";
	// 				$this->db->query($tempins);


	// 				$del = "delete from trans_credit_entry where Roomid='" . $_REQUEST['roomid'] . "' and Grcid='" . $_REQUEST['grcid'] . "' and  Creditheadid ='" . $row['Creditheadid'] . "'";
	// 				$this->db->query($del);
	// 			}
	// 		}
	// 		$up = "update trans_pay_det set cancelflag=1 where checkoutid ='" . $checkoutid . "' ";
	// 		$this->db->query($up);
	// 		if ($exec) {
	// 			echo "success";
	// 		}
	// 	} else {
	// 		echo "Fail";
	// 	}
	// }








// NEW
// --------
	public function ReinstateSettlementSave(){

		date_default_timezone_set('Asia/Kolkata');

		$checkoutid = $_REQUEST['checkoutid'];
	    $reason = $_REQUEST['Reason'];
	    $guest = $_REQUEST['guest'];
		 $checkoutdate = $_REQUEST['checkoutdate'];
		 $curDate = date('Y-m-d');
		$actroomrent = 0;
		$act = 0;
		$net= 0;
		$other = 0;
		$check ="select * from room_status where Roomid='".$_REQUEST['roomid']."' and status='Y' and  notready=0
		and blocked=0 and mblock=0 and foblock=0";
		$res = $this->db->query($check);
		$no = $res->num_rows();

		$ins = '';
		$sql = '';
		// $sql3 = '';
		$sql1 = '';
		$ins3 = '';
		$del = '';
		if($no == 0){

			$sql = "update trans_checkout_mas set  reason = '".$reason."', canceluserid='".User_id."',reinstate='1' , Settle = '0', reinstatedate='".date('Y-m-d')."' where checkoutid='".$checkoutid."'";
			// $this->db->query($sql);
			$sql1 = "update room_status set notready='0', status='Y' , roomgrcid='".$_REQUEST['roomgrcid']."', 
			grcid='".$_REQUEST['grcid']."', billsettle='0' where Roomid='".$_REQUEST['roomid']."'";
			// $exec = $this->db->query($sql1);

			if($checkoutdate == $curDate){
				$qry = "select * from Trans_credit_entry where Roomid='".$_REQUEST['roomid']."' and Grcid='".$_REQUEST['grcid']."' and  Creditheadid in (1,2,3)";
				$exe = $this->db->query($qry);
				foreach($exe -> result_array() as $row){
					if($row['Actroomrent'] != ''){
						$actroomrent = $row['Actroomrent'];
					}

					if($row['Nettarrifamount'] != ''){
						$net = $row['Nettarrifamount'];
					}

					if($row['otherAmount'] != ''){
						$other = $row['otherAmount'];
					}
					if($row['actrackrate'] != ''){
						$act = $row['actrackrate'];
					}

					$ins .= "insert into trans_credit_entry_log(CreditNo, CreditDate, Roomid, Grcid,Creditheadid,Amount,
					roomgrcid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,groupno,Actroomrent,
					Nettarrifamount,Ratetypeid,actrackrate,canceldate)values(dbo.Credit_Entry_Log_No(),'".$row['CreditDate']."','".$_REQUEST['roomid']."',
					'".$_REQUEST['grcid']."','".$row['Creditheadid']."','".$row['Amount']."','".$_REQUEST['roomgrcid']."',
					'".$row['crtime']."','".$other."','".User_id."','".$row['tarrifftype']."','".$row['tarriffsetupid']."',
					'".$row['groupno']."','".$actroomrent."','".$net."','".$row['Ratetypeid']."','".$act."',
					'".date('Y-m-d')."')";
					// $this->db->query($ins);

					 $del .= "delete from trans_credit_entry where Roomid='".$_REQUEST['roomid']."' and Grcid='".$_REQUEST['grcid']."' and  Creditheadid ='".$row['Creditheadid']."'";
					// $this->db->query($del);
					
				}
			}

		
			 
	$setqry = "select enablepower from extraoption";

	$set = $this->db->query($setqry)->row_array();

	if($set['enablepower'] == 1) {
		
		
			$select ="select RoomNo from mas_room where Room_Id = '".$_REQUEST['roomid']."'";

			$roomnumber = $this->db->query($select)->row_array();
		  
		  
			$otherDB = $this->load->database('another_db', TRUE);
		  
		  
			$selroom = "
			SELECT mc.ControlType_Id as control, md.Device
			FROM mas_control mc
			INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
			INNER JOIN mas_device md ON mc.Device = md.Device
			WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
			
			$result = $otherDB->query($selroom)->result_array();

			$ins3 = '';
			foreach($result as $res){
		  
				$control = $res['control'];
				$Device = $res['Device'];
				
				$process = "select Status_Id from mas_status where upper(status) = 'CHECKIN'";
			  
				$process_id = $otherDB->query($process)->row_array();
			  
				
				 $ins3 .= "
				INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,customer,usersname,onoff)
				VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$_REQUEST['roomgrcid']."','Reinstate Settlement','" . $curDate . "',convert(VARCHAR,getdate(),108),'".$guest."','".$guest."','0')";
			  
			}

   
		}
		

			echo "BEGIN Try ";
			echo "BEGIN Transaction ";
			echo "BEGIN Tran ";
			// echo $sql3;
			echo $ins;
			echo $del;
			echo $sql;
			echo $sql1;
			echo $ins3;
			echo " If @@error<>0 Rollback Tran else Commit Tran ";
			echo "COMMIT ";
			echo "end try ";
			echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
			echo "END CATCH ";
			$sqc = ob_get_clean();
		 	$sq = "" . $sqc . "";
			$result = $this->db->query($sq);
			$this->db->close();
			$this->db->reconnect();

			$sql3 = "Exec exec_Temp_Trans_credit_entry   '" . $_REQUEST['roomid'] . "', '" .date('Y-m-d'). "'";
			$res3 = $this->db->query($sql3);


			$up ="update trans_pay_det set cancelflag=1 where checkoutid ='".$checkoutid ."' ";
			$this->db->query($up);
			if($result){

				$checkout = "select cmas.checkoutdate,room.typeid,room.depdate from  trans_checkout_mas cmas
						inner join Trans_Roomdet_det room on  room.roomgrcid = cmas.roomGrcid
						where cmas.roomgrcid= '".$_REQUEST['roomgrcid']."'";
			$checkqry = $this->db->query($checkout);
			foreach ($checkqry->result_array() as $ress) {
				$cid = $ress['checkoutdate'];
				$typeid = $ress['typeid'];
				$depdate = $ress['depdate'];
			}

		

			$aa_date = date_create($cid); 
			$l_date = date_create($depdate);
			$diff = date_diff($aa_date, $l_date);
			$difference = $diff->format("%a");
			for ($i = 0; $i <= $difference; $i++) {
			$insR = " exec Update_RoomAvailability   '" . $cid. "', '" . $typeid. "'";
		      $execute = $this->db->query($insR);

				$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
			}

				echo "success";
			}
		}else{
			echo "Fail";
		}
	
	}


	public function getingCustomerHistory()
	{
	date_default_timezone_set('Asia/Kolkata');
		$customerid = $_REQUEST['id'];
		$sql = "Guest__History '" . $customerid . "'";
		$res = $this->db->query($sql);
		$cancel = 0;
		$noshows = 0;
		$noofvisits = 0;
		$last = 0;
		$first = 0;
		$roomrent = 0;
		$roomno = 0;

		foreach ($res->result() as $row) {
			$cancel = $row->Cancel;
			$noshows = $row->Noshows;
			$noofvisits = $row->noofvisits;
			$last = date('d-m-Y', strtotime($row->laststayeddate));
			$first = date('d-m-Y', strtotime($row->firststayeddate));
			$roomrent = $row->roomrent;
			$roomno = $row->roomno;
		}
		$data = ['cancel' => $cancel, 'noshows' => $noshows, 'visits' => $noofvisits, 'first' => $first, 'last' => $last, 'roomrent' => $roomrent, 'roomno' => $roomno];
		echo json_encode($data);
	}


	public function getingCustomerHistoryList()
	{

	date_default_timezone_set('Asia/Kolkata');
		$customerid = $_REQUEST['id'];
		$sql = "Guest__History__List '" . $customerid . "'";
		$res = $this->db->query($sql);
		echo '    <tr>
				  <td>Room No</td>
				  <td>Arr.Date</td>
				  <td>Dep.Date</td>				
				  <td>Pax</td>
				  <td>Bill No</td>
				  <td>Bill Amount</td>
				  <td>Rent</td>
				  <td>Discount</td>
				  <td>DiscPer</td>			
				 </tr>';
		foreach ($res->result_array() as $row) {
			echo '
			     <tr>
					<td>' . $row['RoomNo'] . '</td>
					<td>' . date('d-m-Y', strtotime($row['checkindate'])) . '</td>
					<td>' . date('d-m-Y', strtotime($row['checkoutdate'])) . '</td>
					<td>' . $row['noofpersons'] . '</td>
					<td>' . $row['checkoutno'] . '</td>
					<td>' . $row['totalamount'] . '</td>
					<td>' . $row['roomrent'] . '</td>
					<td>' . $row['discount'] . '</td>
					<td>' . $row['discper'] . '</td>
			      </tr>';
		}
	}

	public function getratetyperoomrentt()
	{
	

		date_default_timezone_set('Asia/Kolkata');
		$roomid = $_REQUEST['Roomid'];
		$planid = $_REQUEST['planid'];
		$fromdate = date('Y/m/d', strtotime($_REQUEST['fromdate']));
		$todate = date('Y/m/d', strtotime($_REQUEST['todate']));
		$Indate = date('Y/m/d', strtotime($_REQUEST['fromdate']));

		$delete = "Delete temp_trans_roomdet_det_rent where roomid='" . $roomid . "'";
		$deleqry = $this->db->query($delete);
		while ($Indate <= $todate) {
			$sql6 = "SELECT * FROM Mas_RatePlan RP 
			INNER JOIN Mas_RatePlan_Det RD on RD.RatePlan_Id=RP.RatePlan_Id
			INNER JOIN Mas_Plantype PT on PT.PlanType_Id=Rp.PlanType_Id
			INNER JOIN Mas_Roomtype RT on RT.RoomType_Id=RP.RoomType_Id
			INNER JOIN Mas_Room RM on RM.RoomType_Id =RT.RoomType_Id
			where RM.Room_Id ='" . $roomid . "' and PT.PlanType_id='" . $planid . "' Order by PT.PlanType_Id";
			$res6 = $this->db->query($sql6);
			$data = $res6->result();
			foreach ($res6->result_array() as $row6) {
				$Adults = $row6['Adults'];
				$Extrabedcount = $row6['Extrabedcount'];
				$singlerent = $row6['Single'];
				$Doublerent = $row6['Doubles'];
				$Triplerent = $row6['Triple'];
				$Quartertriplerent = $row6['Quadruple'];
				$ins3 = "Insert into temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
			 values('" . $Indate . "','" . $roomid . "','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','I','" . $singlerent . "','" . $Doublerent . "','" . $Triplerent . "','" . $Quartertriplerent . "','" . $row6['Extrabedamount'] . "','" . User_id . "',dbo.GrcNo(),'" . Hotel_Id . "')";
				$result = $this->db->query($ins3);
			}
			$Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
		}

		echo '<thead>
			<tr style=" width:100%; border-top: 2px solid #333 !important; border-bottom:2px solid #333">
			 <td>S.No</td>
			 <td>Date</td>
			 <td>Single</td>
			 <td>Double</td>
			 <td>Triple</td>
			 <td>Quarter Triple</td>
			 <td>Extra bed</td>
			</tr>
		   </thead>';
		echo '<tbody>';
		$i = 1;
		$rent = "select * from temp_trans_roomdet_det_rent where Roomid='" . $roomid . "' order by Rentdate";
		$rentres = $this->db->query($rent);
		foreach ($rentres->result_array() as $rentrow) {
			if ($i == 1) {
				$firstid = $rentrow['roomrentid'];
				echo '<input type="hidden" name="firstid" id="firstid" value=' . $firstid . '>';
			}

			echo '<tr  style="width:100%">
			  <td  style="width:10%; padding:2px;">' . $i . '</td>
			  <td align="left" style="width:15%;padding:2px;"><input type="hidden" name="roomrentid" value="' . $rentrow['roomrentid'] . '">' . date('d/m/Y', strtotime($rentrow['Rentdate'])) . '</td>
			  <td style="width:15%; padding:2px; "><input style="border:hidden;  width:100px" name="' . $rentrow['roomrentid'] . 'single" id="' . $rentrow['roomrentid'] . 'single" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:100%;text-align:right" type="text" value="' . $rentrow['singlerent'] . '"></td>
			  <td style="width:15%; padding:2px;"><input  style="border:hidden;  width:100px"name="' . $rentrow['roomrentid'] . 'double" id="' . $rentrow['roomrentid'] . 'double" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:100%;text-align:right" type="text" value="' . $rentrow['Doublerent'] . '"></td>
			  <td style="width:15%; padding:2px;"><input style="border:hidden;width:100px" name="' . $rentrow['roomrentid'] . 'triple" id="' . $rentrow['roomrentid'] . 'triple" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:100%;text-align:right" type="text" value="' . $rentrow['Triplerent'] . '"></td>
			  <td style="width:15%; padding:2px;"><input style="border:hidden;  width:100px" name="' . $rentrow['roomrentid'] . 'quartertriple" id="' . $rentrow['roomrentid'] . 'quartertriple" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:100%;text-align:right" type="text" value="' . $rentrow['Quartertriplerent'] . '"></td>
			  <td style="width:10%; padding:2px;"><input style="border:hidden;  width:100px" name="' . $rentrow['roomrentid'] . 'extrabed" id="' . $rentrow['roomrentid'] . 'extrabed" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:100%;text-align:right" type="text" value="' . $rentrow['extraadultcharges'] . '"></td>
			 </tr>';

			$i++;
			$lastid = $rentrow['roomrentid'];
		}
		echo '
			<tr style="border-top:2px solid #333;">
			<td style="text-align: center;padding:2px;"><a onclick="Replicate(' . $lastid . ',' . $firstid . ')"class="btn btn-warning btn-sm">Replicate</a></td>
			<td></td>
			<td></td>			
			<td></td>
			<td></td>
			<td style="text-align: center;"><input type="submit"   class="btn btn-warning btn-sm"></td>		
			<td style="text-align: center;"><a onclick="closetariff()"class="btn btn-warning btn-sm">Cancel</a>	</td>			
		   </tr>';
		echo '</tbody>';
	}



	public function viewProof()
	{
		$sql = "select isnull(photopath,'') as photopath from mas_customer where customer_id='" . $_REQUEST['id'] . "'";
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $row) {
			echo $path = $row['photopath'];
		}
	}


	public function GuestImageSlider($ID = -1)
	{
		$ID = $_REQUEST['id'];
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'GuestImageSlider', 'ID' => $ID);
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function CashBook($ID = -1, $BUT = 'SAVE')
	{

		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'CashBook', 'ID' => $ID, 'BUT' => $BUT);
		if ($ID != -1) {
			$REC = $this->Myclass->Accname($ID);
			$data = array_merge($data, $REC[0]);
		}

		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
	}


	public function CashBook_Val()
{
	date_default_timezone_set('Asia/Kolkata');
   
	$count = $this->input->post('count');

	$user_id = User_id;


	$credittot = 0;
	$debittot  = 0;
	$total = 0;
	$detins = '';
	$credit = 0;
	$debit = 0;
	
	for ($i = 1; $i <= $count; $i++) {
		$head   = $this->input->post("Head_$i");
		 $type = $this->input->post("Type_$i");
		$debiter  = (float) $this->input->post("Debit_$i");
		$remark = $this->input->post("Remark_$i");


		$acc = "select CREDITORDEBIT from accname where ACCID = '".$head."'";
		$accqry = $this->db->query($acc)->row_array();

		$acid = "SELECT ACCNAME FROM ACCNAME WHERE ACCID= '".$head."' ";
		$acidqry = $this->db->query($acid)->row_array();


		if($type == 'Dr'){
			$debit  = $debiter;
		} else {
			$credit  = $debiter;

		}

	 	$debittot  += $debit;
	
		 $credittot += $credit;
		

		if ($credit <= 0 && $debit <= 0) {
			continue;
		}
	

		if ($credit > 0 && $debit > 0) {
			continue;
		}
		
		$amount = ($credit > 0) ? $credit : $debit;

		 $detins .= "insert into trans_cash_bookdet(Dailyid,Head,Amount,Debitorcredit,narr,userid,accid,yearprefix)
		values(@Siden, '".$acidqry['ACCNAME']."','".$amount."','".$accqry['CREDITORDEBIT']."','".$remark."','".$user_id."','".$head."',dbo.YearPrefix())";
		
	

	}
	
        $total = $credittot - $debittot;
	


	 $ins = "insert into Trans_cash_book(DailyNo, TotalAmount,Cashdate,userid,yearprefix)
		VALUES(dbo.CashbookNo(),'".$total."', '".date('Y-m-d')."','".$user_id."',dbo.YearPrefix())";

   
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;				
		echo "set @Siden=@@identity; ";
		echo $detins;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
	      $sqc = ob_get_clean();
		$result = $this->db->query($sqc);
		$this->db->close();
		$this->db->reconnect();

		if($result){
			echo '0';
		}
		else {
			echo '1';
		}
 
   
}



	
	
	
		
	public function headselect(){
		$id = $this->input->post('id');
	
		$qry = "SELECT CREDITORDEBIT FROM ACCNAME WHERE ACCID= '".$id."'";
		$exqry = $this->db->query($qry)->row_array();
	
		echo $exqry['CREDITORDEBIT'];
	
	
	}
	

	public function CashBook_View()
	{
		$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'CashBook');
		$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'] . "_View", $data);
	}

	public function CashBook_EntryDelete()
	{


		$sql = "delete from trans_cash_book where dailyid='" . $_REQUEST['id'] . "'";
		$sql1 = "delete from trans_cash_bookdet where dailyid='" . $_REQUEST['id'] . "'";
		$res = $this->db->query($sql, $sql1);
		if ($res) {

			echo "success";
		} else {
			echo "fail";
		}
	}


	/*public function PostRent_Val()
	{
	   $sql="select DateofAudit,* from night_audit";
	  $res=$this->db->query($sql);
	  foreach ($res->result_array() as $row)
		{ $auditdate=$row['DateofAudit']; } 
	  $creditdate=date('Y-m-d',strtotime($auditdate.'+1 days'));
	  $Res=$this->Myclass->Get_NightAuditrooms();
	  $up='';$ins='';
	  foreach($Res as $row)
	  {
		$sql1="select * from Trans_credit_entry where roomgrcid='".$row['roomgrcid']."' and Grcid='".$row['grcid']."' and CreditDate='".$creditdate."'";
		$res1=$this->db->query($sql1);
		$norow= $res1->num_rows();
		if($norow != 0)
		{
		 $del="delete from Trans_credit_entry where roomgrcid='".$row['roomgrcid']."' and Grcid='".$row['grcid']."' and CreditDate='".$creditdate."'";	
		 $res=$this->db->query($del);
		}
		
		$ins=$ins."Insert into Trans_credit_entry (CreditNo,Roomid,Grcid,CreditDate,Creditheadid,Amount,Atcheckin,roomgrcid,payid,Bankid,crtime,otherAmount,UserID,tarrifftype,tarriffsetupid,Ratetypeid)
				values(dbo.Credit_Entry_No(),'".$row['Roomid']."','".$row['grcid']."','".$creditdate."','1','".$row['roomrent']."','0','".$row['roomgrcid']."','0','0',convert(VARCHAR,getdate(),108),'".$row['roomrent']."','".User_id."','".$row['tarrifftypeid']."','".$row['taxid']."','".$row['ratetypeid']."')";
		  
		$up=$up."update Trans_roomdet_det_rent set nightauditcompleted=1 where roomgrcid='".$row['roomgrcid']."' and grcid='".$row['grcid']."' and Rentdate='".$creditdate."'";
		
		
      }
	  
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins;				
		echo "set @Siden=@@identity; ";
		echo $up;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$ran=rand().rand().rand(); 
		$sq = "Create Procedure #".$ran." as ".$sqc.""; 
		$result = $this->db->query($sq);
		$result = $this->db->query("exec #".$ran);
		$this->db->close();
		$this->db->reconnect();
		
		//echo "jdgfjd";
		
	 }*/



	public function WhatsappSmsSending()
	{

		$sql = "select top 1 * from outbox where isnull(smsflag,0)<>1 ";
		$res = $this->db->query($sql);
		$count = $res->num_rows();
		if ($count != 0) {

			foreach ($res->result_array() as $row) {
				$msgid = $row['msgid'];
				$mobile = $row['MobileNumber'];
				$campaignname = strtolower($row['campaign']);
			}

			$array = [];
			$sql1 = "select * from outbox_smsval where msgid='" . $msgid . "' order by Variableval asc";
			$res1 = $this->db->query($sql1);
			$no = $res1->num_rows();
			if ($no != 0) {

				foreach ($res1->result_array() as $row1) {
					if ($row1['Smsval'] == '') {
						$val = ' - ';
					} else {
						$val = $row1['Smsval'];
					}

					array_push($array, "\"$val\"");
				}


				// echo "Updated";

				$curl = curl_init();

				curl_setopt_array(
					$curl,
					array(
						CURLOPT_URL => 'https://backend.aisensy.com/campaign/t1/api',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => '{
					"apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0OTk1Y2M4OTdhMzA3MGI0OTNiYmMzOCIsIm5hbWUiOiJNaWNyb2dlbm4gU29mdHdhcmUgU29sdXRpb25zIDY3NTciLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjQ5OTVjYzg5N2EzMDcwYjQ5M2JiYzMzIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE2ODc3NzIzNjB9.ECouWCoPv4SC7PdjPXBJh--LPurnHrq7S0xR4D2Rj04",
					"campaignName": ' . "\"$campaignname\"" . ',
					"destination": ' . "\"$mobile\"" . ',
					"userName": "arun@microgenn.com",
					"source": "CloudFO",
					"templateParams": [
						' . implode(",", $array) . '
					],
					"tags": [
					],
					"attributes": {
					"attribute_name": "5"
					}
					}',
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json'
						),
					)
				);

				$response = curl_exec($curl);

				curl_close($curl);
				echo $response;

				if ($response == 'Success.') {
					$sql2 = "update outbox set smsflag=1 ,notsentflag=0, reason = '" . $response . "' where msgid='" . $msgid . "'";
					$res2 =  $this->db->query($sql2);
				} else {
					$result = json_decode($response, true);
					$rps = $result['errorMessage'];

					$sql3 = "update outbox set notsentflag=1 ,smsflag=1, reason = '" . $rps . "' where msgid='" . $msgid . "'";
					$res3 =  $this->db->query($sql3);
				}
			}
		} else {
			echo "No Records Available...";
		}
	}

	public function reserve_validation() {

	date_default_timezone_set('Asia/Kolkata');

		 $resno = $this->input->post('resno');
		 $prefix = $this->input->post('prefix');
		 $typeid = $this->input->post('roomtypeid');
		 $fromdate = $this->input->post('fromdate');
		 $todate = $this->input->post('todate');

		 $room = "select RoomType from mas_roomtype where RoomType_Id = '".$typeid."'";

		 $exec = $this->db->query($room)->row_array();
	
		
                $check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, mas.resid 
				  FROM Trans_reserve_mas mas 
				  INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid 
				  WHERE mas.resno = '".$resno."' and mas.yearprefix = '".$prefix."'";
		$checkqry = $this->db->query($check);
		$resid = null;
	
		foreach ($checkqry->result_array() as $ress) {
			$resid = $ress['resid'];
		}
	

		$aa_date = date_create($fromdate); 
		$l_date = date_create($todate);
		$diff = date_diff($aa_date, $l_date);
		$difference = $diff->format("%a");
		$froms = date('d-m-Y', strtotime($fromdate));
		for ($i = 0; $i <= $difference; $i++) {
				
			 $val = "EXEC roomavailability_validation '".$fromdate."',  '".$typeid."'";
			$exval = $this->db->query($val)->row_array();
		
	
			echo json_encode([
				'available' => isset($exval['Avail']) ? (int)$exval['Avail'] : 0,
				'room_type' => $exec['RoomType'],
				'date' => $froms
			]);
	
		  
	  
		  $fromdate = date("Y-m-d", strtotime('+1 day', strtotime($fromdate)));
		  
		  
	  }

	
		

	}



	public function reserve_amend_validation() {
	date_default_timezone_set('Asia/Kolkata');

		 $resno = $this->input->post('resno');
		 $prefix = $this->input->post('prefix');
		 $typeid = $this->input->post('roomtypeid');
		 $fromdate = $this->input->post('fromdate');
		 $todate = $this->input->post('todate');

		 $room = "select RoomType from mas_roomtype where RoomType_Id = '".$typeid."'";

		 $exec = $this->db->query($room)->row_array();
	
		
                $check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, mas.resid 
				  FROM Trans_reserve_mas mas 
				  INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid 
				  WHERE mas.resno = '".$resno."' and mas.yearprefix = '".$prefix."'";
		$checkqry = $this->db->query($check);
		$resid = null;
	
		foreach ($checkqry->result_array() as $ress) {
			$resid = $ress['resid'];
		}
	

		$aa_date = date_create($fromdate); 
		$l_date = date_create($todate);
		$diff = date_diff($aa_date, $l_date);
		$difference = $diff->format("%a");
		$froms = date('d-m-Y', strtotime($fromdate));
		for ($i = 0; $i <= $difference; $i++) {
				
			   $val = "EXEC RoomAvailability_reservation_validation '".$fromdate."',  '".$typeid."', '".$resid."'";
			$exval = $this->db->query($val)->row_array();
		
			echo json_encode([
				'available' => isset($exval['Avail']) ? (int)$exval['Avail'] : 0,
				'room_type' => $exec['RoomType'],
				'date' => $froms
			]);
	
		  
	  
		  $fromdate = date("Y-m-d", strtotime('+1 day', strtotime($fromdate)));
		  
		  
	  }



	}



	public function reserve_checkin_validation() {
	date_default_timezone_set('Asia/Kolkata');

		$Resid = $this->input->post('Resid');
		$prefix = $this->input->post('prefix');
		$typeid = $this->input->post('roomtypeid');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');

		$room = "select RoomType from mas_roomtype where RoomType_Id = '".$typeid."'";

		$exec = $this->db->query($room)->row_array();
   
	   
			   $check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, mas.resid 
				 FROM Trans_reserve_mas mas 
				 INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid 
				 WHERE mas.Resid = '".$Resid."' ";
	   $checkqry = $this->db->query($check);
	   $resid = null;
   
	   foreach ($checkqry->result_array() as $ress) {
		   $resid = $ress['resid'];
	   }
   

	   $aa_date = date_create($fromdate); 
	   $l_date = date_create($todate);
	   $diff = date_diff($aa_date, $l_date);
	   $difference = $diff->format("%a");
	   $froms = date('d-m-Y', strtotime($fromdate));
	   for ($i = 0; $i <= $difference; $i++) {
			   
			  $val = "EXEC RoomAvailability_reservation_validation '".$fromdate."',  '".$typeid."', '".$Resid."'";
		   $exval = $this->db->query($val)->row_array();
	   
		   echo json_encode([
			   'available' => isset($exval['Avail']) ? (int)$exval['Avail'] : 0,
			   'room_type' => $exec['RoomType'],
			   'date' => $froms
		   ]);
   
		 
	 
		 $fromdate = date("Y-m-d", strtotime('+1 day', strtotime($fromdate)));
		 
		 
	 }



   }


	public function room_validation() {
	date_default_timezone_set('Asia/Kolkata');

		$resno = $this->input->post('resno');
		$prefix = $this->input->post('prefix');
		$typeid = $this->input->post('roomtypeid');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');

		$room = "select RoomType from mas_roomtype where RoomType_Id = '".$typeid."'";

		$exec = $this->db->query($room)->row_array();
   
	   
			   $check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, mas.resid 
				 FROM Trans_reserve_mas mas 
				 INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid 
				 WHERE mas.resno = '".$resno."' and mas.yearprefix = '".$prefix."'";
	   $checkqry = $this->db->query($check);
	   $resid = null;
   
	   foreach ($checkqry->result_array() as $ress) {
		   $resid = $ress['resid'];
	   }
   

	   $aa_date = date_create($fromdate); 
	   $l_date = date_create($todate);
	   $diff = date_diff($aa_date, $l_date);
	   $difference = $diff->format("%a");
	   $froms = date('d-m-Y', strtotime($fromdate));
	   for ($i = 0; $i <= $difference; $i++) {
			   
			  $val = "EXEC roomavailability_validation '".$fromdate."',  '".$typeid."'";
		   $exval = $this->db->query($val)->row_array();
	   
   
		   echo json_encode([
			   'available' => isset($exval['Avail']) ? (int)$exval['Avail'] : 0,
			   'room_type' => $exec['RoomType'],
			   'date' => $froms
		   ]);
   
		 
		 $fromdate = date("Y-m-d", strtotime('+1 day', strtotime($fromdate)));
		 
		 
	 }

   
	   

   }
	

	// public function insert_room_data()
	// {
	// 	$roomtypeid = $this->input->post('roomtypeid');
	// 	$rooms      = $this->input->post('rooms');
	// 	$fromdate   = $this->input->post('fromdate');
	// 	$todate     = $this->input->post('todate');
	// 	$created_at = date('Y-m-d H:i:s');
	
	// 	// Escape and quote string values properly
	// 	$sql = "INSERT INTO tbl_booking_rooms 
	// 		(RoomType_Id, NoOfRooms, ArrivalDate, DepartureDate, CreatedAt)
	// 		VALUES (
	// 			'$roomtypeid', 
	// 			'$rooms', 
	// 			'$fromdate', 
	// 			'$todate', 
	// 			'$created_at'
	// 		)";
	
	// 	$exec = $this->db->query($sql);
	
	// 	if ($exec) {
	// 		echo "success";
	// 	} else {
	// 		echo "error";
	// 	}
	// }

	public function insert_room_data()
{
	date_default_timezone_set('Asia/Kolkata');

    $roomtypeid = $this->input->post('roomtypeid');
    $rooms      = (int)$this->input->post('rooms');
    $fromdate   = $this->input->post('fromdate');
    $todate     = $this->input->post('todate');
    $created_at = date('Y-m-d H:i:s');

    // Input validation
    if (empty($roomtypeid) || empty($rooms) || empty($fromdate) || empty($todate)) {
        http_response_code(400);
        echo "Missing required input fields.";
        return;
    }

    // Get latest reservation ID
    $check = "SELECT TOP 1 tdet.fromdate, tdet.typeid, tdet.todate, mas.resid 
              FROM Trans_reserve_mas mas 
              INNER JOIN Trans_reserve_det tdet ON tdet.resdetid = mas.resid 
              ORDER BY mas.resid DESC";

    $checkqry = $this->db->query($check);
    $resid = 0;
    if ($checkqry->num_rows() > 0) {
        $res = $checkqry->row_array();
        $resid = $res['resid'];
    }

    // Get total available rooms from SP
    $val = "EXEC roomavailability_validation '$fromdate', '$roomtypeid', '$resid'";
    $exval = $this->db->query($val)->row_array();
    $totalAvailable = isset($exval['Avail']) ? (int)$exval['Avail'] : 0;

    // Get already booked rooms from tbl_booking_rooms (overlapping date range)
    $bookedSql = "SELECT SUM(NoOfRooms) as booked_rooms 
                  FROM tbl_booking_rooms 
                  WHERE RoomType_Id = '$roomtypeid' 
                    AND (
                        (ArrivalDate <= '$todate' AND DepartureDate >= '$fromdate')
                    )";

    $bookedResult = $this->db->query($bookedSql)->row_array();
    $bookedRooms = isset($bookedResult['booked_rooms']) ? (int)$bookedResult['booked_rooms'] : 0;

    // Calculate remaining rooms
    $remainingRooms = $totalAvailable - $bookedRooms;

    // Validation
    if ($rooms > $remainingRooms) {
        http_response_code(400);
        echo "Only $remainingRooms rooms are available for this room type in the selected date range.";
        return;
    }

    // Insert new booking
    $sql = "INSERT INTO tbl_booking_rooms 
            (RoomType_Id, NoOfRooms, ArrivalDate, DepartureDate, CreatedAt)
            VALUES (
                '$roomtypeid', 
                '$rooms', 
                '$fromdate', 
                '$todate', 
                '$created_at'
            )";

    $exec = $this->db->query($sql);

    if ($exec) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Database error. Could not insert booking.";
    }
}


public function delete_booking()
{
    $booking_id = $this->input->post('booking_id');

    if (!$booking_id) {
        echo "Invalid booking ID";
        return;
    }

    // $this->db->where('BookingId', $booking_id);
    // $deleted = $this->db->delete('tbl_booking_rooms');
	$delete = "Delete from tbl_booking_rooms where BookingRoom_Id = '".$booking_id."'";
	$exec = $this->db->query($delete);

    if ($exec) {
        echo "success";
    } else {
        echo "Failed to delete from DB";
    }
}



public function getroomrent(){

	date_default_timezone_set('Asia/Kolkata');
	$roomid = $this->input->post('roomid');
	 $curdate = date('Y-m-d');
	  $qry = "select mas.single,mas.doubles,mas.triple,mas.Quadruple from mas_rateplan_det mas
	  inner join mas_roomtype mtyp  on mtyp.RoomType_Id =  mas.RatePlan_Id
	 where mtyp.RoomType_id = '".$roomid."'";

	 $room = "select RoomType from mas_roomtype where RoomType_Id ='".$roomid."'";

	  $exeqry = $this->db->query($qry)->row_array();

	  $roomtype = $this->db->query($room)->row_array();

	  $data  = [
		"Roomtype" => $roomtype['RoomType'],
		"single" => $exeqry['single'],
		"double" => $exeqry['doubles'],
		"triple" => $exeqry['triple'],
		"quartertriple" => $exeqry['Quadruple']

	  ];


	
	   header('Content-Type: application/json');
	   echo json_encode($data);


}


public function savepricingslab() {
	
 
   
    $slabName = $this->input->post('slabName');
    $roomtype = $this->input->post('roomtype');
    $singleRent = $this->input->post('singleRent');
    $doubleRent = $this->input->post('doubleRent');
    $tripleRent = $this->input->post('tripleRent');
    $quarterTripleRent = $this->input->post('quarterTripleRent');
	

   
    $from = $this->input->post('from'); 
    $to = $this->input->post('to'); 
    $increase = $this->input->post('increase'); 
    $decrease = $this->input->post('decrease');
    $discount = $this->input->post('discount');
    $bottomValue = $this->input->post('bottomValue'); 
    $topValue = $this->input->post('topValue'); 


    if (empty($slabName) || empty($roomtype)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Slab Name and Room Type are required.'
        ]);
        return;
    }

    if (!is_array($from) || !is_array($to) || empty($from) || empty($to)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid table data.'
        ]);
        return;
    }


    for ($i = 0; $i < count($from); $i++) {
        if (
            empty($from[$i]) || empty($to[$i]) || 
            $discount[$i] === '' || $bottomValue[$i] === '' || $topValue[$i] === ''
        ) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All table fields must be filled.'
            ]);
            return;
        }
    }


	$ins = "";
	$ins1 = [];

  
    if (!is_array($from) || !is_array($to)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid table data.'
        ]);
        return;
    }

 
    $rows = [];
    for ($i = 0; $i < count($from); $i++) {
         $rows[] = [
            'from' => $from[$i],
            'to' => $to[$i],
            'increase' => $increase[$i],
            'decrease' => $decrease[$i],
            'discount' => $discount[$i],
            'bottomValue' => $bottomValue[$i],
            'topValue' => $topValue[$i]
        ];

        
    }

	

	date_default_timezone_set('Asia/Kolkata'); 

	$currentDate = date('Y-m-d');          
	$currentTime = date('H:i:s');    

	 $old = "select * from pricingslab_mas where slabname = '".$slabName."'" ;

	$oldslab = $this->db->query($old)->row_array();

	if(!$oldslab){

		$ins = "insert into pricingslab_mas(slabname,createdate,createtime,createuserid,roomtype_id) 
		values('".$slabName."','".$currentDate."','".$currentTime."','".User_id."','".$roomtype."')";
	
		$exins = $this->db->query($ins);



	$get = "SELECT TOP 1 psid FROM pricingslab_mas ORDER BY psid DESC";

	$exeget = $this->db->query($get)->row_array();



	
	foreach ($rows as $row) {


		
		$from         = $row['from'];
		$to           = $row['to'];
		$discper      = $row['discount'];
		$topvalue     = $row['topValue'];
		$bottomvalue  = $row['bottomValue'];
		$increaseflg  = $row['increase'] ? 1 : 0;
		$decreaseflg  = $row['decrease'] ? 1 : 0;
	
		
		$ins1 = "
			INSERT INTO pricingslab_det1 (
				fromoccper,psid, tooccper, discper, topvalue, bottomvalue, increaseflg, decreaseflg
			) VALUES (
				'".$from."','".$exeget['psid']."', '".$to."', '".$discper."', '".$topvalue."', '".$bottomvalue."', '".$increaseflg."', '".$decreaseflg."'
			)";

			$exins1 = $this->db->query($ins1);
	
	}


		if($exins1){
			echo "success";
		} else{
			echo "failed";
		}
	} else{
		echo "sorry";
	}

    

}


// public function editpricingslab(){

	   
//     $slabName = $this->input->post('slabName');
//     $psid = $this->input->post('psid');
//     $roomtype = $this->input->post('roomtype');
//     $singleRent = $this->input->post('singleRent');
//     $doubleRent = $this->input->post('doubleRent');
//     $tripleRent = $this->input->post('tripleRent');
//     $quarterTripleRent = $this->input->post('quarterTripleRent');
	

//     $psdetid1 = $this->input->post('psdetid1');
//     $from = $this->input->post('from'); 
//     $to = $this->input->post('to'); 
//     $increase = $this->input->post('increase'); 
//     $decrease = $this->input->post('decrease');
//     $discount = $this->input->post('discount');
//     $bottomValue = $this->input->post('bottomValue'); 
//     $topValue = $this->input->post('topValue'); 


//     if (empty($slabName) || empty($roomtype)) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Slab Name and Room Type are required.'
//         ]);
//         return;
//     }

//     if (!is_array($from) || !is_array($to) || empty($from) || empty($to)) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Invalid table data.'
//         ]);
//         return;
//     }


//     for ($i = 0; $i < count($from); $i++) {
//         if (
//             empty($from[$i]) || empty($to[$i]) || 
//             $discount[$i] === '' || $bottomValue[$i] === '' || $topValue[$i] === ''
//         ) {
//             echo json_encode([
//                 'status' => 'error',
//                 'message' => 'All table fields must be filled.'
//             ]);
//             return;
//         }
//     }


// 	$ins = "";
// 	$ins1 = [];

  
//     if (!is_array($from) || !is_array($to)) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Invalid table data.'
//         ]);
//         return;
//     }

 
//     $rows = [];
//     for ($i = 0; $i < count($from); $i++) {
//          $rows[] = [
// 			'psdetid1' => $psdetid1[$i],
//             'from' => $from[$i],
//             'to' => $to[$i],
//             'increase' => $increase[$i],
//             'decrease' => $decrease[$i],
//             'discount' => $discount[$i],
//             'bottomValue' => $bottomValue[$i],
//             'topValue' => $topValue[$i]
//         ];

        
//     }

	

// 	date_default_timezone_set('Asia/Kolkata'); 

// 	$currentDate = date('Y-m-d');          
// 	$currentTime = date('H:i:s');    

// 	//   $old = "select * from pricingslab_det1 where fromoccper  = '".$from."'  and tooccper = '".$to."' " ;

// 	// $oldslab = $this->db->query($old)->result_array();

// 	// if($oldslab) {
   
// 	// 	$upd = "update pricingslab_mas set editdate = '".$currentDate."',edittime='".$currentTime."',edituserid = '".User_id."',
// 	// 	roomtype_id = '".$roomtype."' where psid = '".$psid."'";

	
// 	// 	$exins = $this->db->query($upd);
// 	// } else {
// 	// 		$ins = "insert into pricingslab_mas(slabname,editdate,edittime,edituserid,roomtype_id) 
// 	// 	values('".$slabName."','".$currentDate."','".$currentTime."','".User_id."','".$roomtype."')";
// 	// 	$exins = $this->db->query($ins);


// 	// }


	



// 	$get = "SELECT TOP 1 psid FROM pricingslab_mas ORDER BY psid DESC";

// 	$exeget = $this->db->query($get)->row_array();






	
// 	foreach ($rows as $row) {


// 		print_r($rows);


// 		// $psdetid1         = $row['psdetid1'];
		
// 		$froms         = $row['from'];
// 		$tos           = $row['to'];
// 		$discpers      = $row['discount'];
// 		$topvalues     = $row['topValue'];
// 		$bottomvalues = $row['bottomValue'];
// 		$increaseflgs  = $row['increase'] ? 1 : 0;
// 		$decreaseflgs  = $row['decrease'] ? 1 : 0;


	
		
// 		// $ins1 = "
// 		// 	INSERT INTO pricingslab_det1 (
// 		// 		fromoccper,psid, tooccper, discper, topvalue, bottomvalue, increaseflg, decreaseflg
// 		// 	) VALUES (
// 		// 		'".$from."','".$psid."', '".$to."', '".$discper."', '".$topvalue."', '".$bottomvalue."', '".$increaseflg."', '".$decreaseflg."'
// 		// 	)";

	

// 		$upd1 = "update pricingslab_det1 
// 		          set fromoccper = '".$froms."',
// 				  tooccper = '".$tos."',
// 				  discper = '".$discpers."',
// 				  topvalue = '".$topvalues."',
// 				  bottomvalue = '".$bottomvalues."',
// 				  increaseflg = '".$increaseflgs."',
// 				  decreaseflg = '".$decreaseflgs."'
// 				  where psid = '".$psid."'
// 				  " ;

// 			$exins1 = $this->db->query($upd1);
	
// 	}

// 	// $delete = "delete from pricingslab_det1 where  psid = '".$psid."'";

// 	// $exdlt = $this->db->query($delete);


// 		if($exins1){
// 			echo "success";
// 		} else{
// 			echo "failed";
// 		}
	

// }


public function editpricingslab() {
	date_default_timezone_set('Asia/Kolkata');

    $slabName = $this->input->post('slabName');
    $psdetid1 = $this->input->post('psdetid1'); // Expecting this to be an array
    $psid = $this->input->post('psid');
    $roomtype = $this->input->post('roomtype');
    $singleRent = $this->input->post('singleRent');
    $doubleRent = $this->input->post('doubleRent');
    $tripleRent = $this->input->post('tripleRent');
    $quarterTripleRent = $this->input->post('quarterTripleRent');
   
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $increase = $this->input->post('increase');
    $decrease = $this->input->post('decrease');
    $discount = $this->input->post('discount');
    $bottomValue = $this->input->post('bottomValue');
    $topValue = $this->input->post('topValue');

    if (empty($slabName) || empty($roomtype)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Slab Name and Room Type are required.'
        ]);
        return;
    }

    if (!is_array($from) || !is_array($to) || empty($from) || empty($to)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid table data.'
        ]);
        return;
    }

    for ($i = 0; $i < count($from); $i++) {
        if (
            empty($from[$i]) || empty($to[$i]) ||
            $discount[$i] === '' || $bottomValue[$i] === '' || $topValue[$i] === ''
        ) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All table fields must be filled.'
            ]);
            return;
        }
    }

    date_default_timezone_set('Asia/Kolkata');
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    $upd = "UPDATE pricingslab_mas 
            SET editdate = '" . $currentDate . "', 
                edittime = '" . $currentTime . "', 
                edituserid = '" . User_id . "',
                roomtype_id = '" . $roomtype . "' 
            WHERE psid = '" . $psid . "'";
    $this->db->query($upd);

    foreach ($from as $index => $froms) {
        $tos = $to[$index];
        $discpers = $discount[$index];
        $topvalues = $topValue[$index];
        $bottomvalues = $bottomValue[$index];
        $increaseflgs = $increase[$index] ? 1 : 0;
        $decreaseflgs = $decrease[$index] ? 1 : 0;

      
        $currentPsdetid1 = isset($psdetid1[$index]) ? $psdetid1[$index] : null;

        if ($currentPsdetid1 !== null && $currentPsdetid1 >= 0) {
        
            $upd1 = "UPDATE pricingslab_det1 
                      SET fromoccper = '" . $froms . "',
                          tooccper = '" . $tos . "',
                          discper = '" . $discpers . "',
                          topvalue = '" . $topvalues . "',
                          bottomvalue = '" . $bottomvalues . "',
                          increaseflg = '" . $increaseflgs . "',
                          decreaseflg = '" . $decreaseflgs . "'
                      WHERE psdetid1 = '" . $currentPsdetid1 . "'";

         $res =   $this->db->query($upd1);
        } else {
            // Insert a new record
            $ins1 = "INSERT INTO pricingslab_det1 (
                        psid, fromoccper, tooccper, discper, topvalue, bottomvalue, increaseflg, decreaseflg
                    ) VALUES (
                        '" . $psid . "', '" . $froms . "', '" . $tos . "', '" . $discpers . "', '" . $topvalues . "', 
                        '" . $bottomvalues . "', '" . $increaseflgs . "', '" . $decreaseflgs . "'
                    )";

          $res =   $this->db->query($ins1);
        }
    }

      if($res){
		echo "success";

	  } else{
		echo "failed";
	  }
}






// public function SendReservationErrorEmail() {
//     $form_data = $this->input->post('form_data');
//     $error_message = $this->input->post('error_message');

//     // Load email library
//     $this->load->library('email');

// 	$config = array(
//         'protocol'  => 'smtp',
//         'smtp_host' => 'mail.microgenn.in',
//         'smtp_port' => 587,
//         'smtp_user' => 'development5@microgenn.in',
//         'smtp_pass' => 'Mgenndevelop@123',
//         'mailtype'  => 'html',
//         'charset'   => 'utf-8',
//         'newline'   => "\r\n",
//         'smtp_timeout' => 30,
//         'wordwrap' => TRUE
//     );
//     // $config = array(
//     //     'protocol'      => 'smtp',
//     //     'smtp_host'     => 'webmail.microgenn.com',
//     //     'smtp_port'     => 465,
//     //     'smtp_user'     => 'development5@microgenn.in',
//     //     'smtp_pass'     => 'Mgenndevelop@123',
//     //     'smtp_crypto'   => 'ssl', // important: use 'ssl' or 'tls' depending on your SMTP
//     //     'mailtype'      => 'text',
//     //     'charset'       => 'utf-8',
//     //     'newline'       => "\r\n",
//     //     'smtp_timeout'  => 30,
//     //     'wordwrap'      => TRUE
//     // );

//     $this->email->initialize($config);


//     $this->email->from('development5@microgenn.in', 'Reservation System');
//     $this->email->to('development5@microgenn.in');  
//     $this->email->subject('Reservation Save Failed');

//     $message = "Reservation Save Failed.\n\n";
//     $message .= "Error Message: " . $error_message . "\n\n";
//     $message .= "Form Data:\n" . urldecode($form_data);

//     $this->email->message($message);

//     // Attempt to send
//     if ($this->email->send()) {
//         echo 'Email sent successfully.';
//     } else {
//         echo 'Failed to send email.';
//         // Log full error for debugging
//         log_message('error', 'Email failed: ' . print_r($this->email->print_debugger(['headers']), true));
//     }
// }


public function SendReservationSuccessEmail() {
    $form_data = $this->input->post('form_data');

    $this->load->library('email');

    $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'mail.microgenn.in',
        'smtp_port' => 587,
        'smtp_user' => 'development5@microgenn.in',
        'smtp_pass' => 'Mgenndevelop@123',
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'newline'   => "\r\n",
        'smtp_timeout' => 30,
        'wordwrap' => TRUE
    );

    $this->email->initialize($config);

    $this->email->from('development5@microgenn.in', 'Reservation System');
    $this->email->to('development5@microgenn.in');

    $this->email->subject('Reservation Saved Successfully');
    $message = "Reservation saved successfully.\n\nForm Data:\n" . urldecode($form_data);
    $this->email->message($message);
	if ($this->email->send()) {
		echo 'success';
	} else {
		echo 'fail<br><br>';
		echo nl2br($this->email->print_debugger(['headers']));
	}
}




public function Booklogicroutine(){
	$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'Booklogicroutine');
	$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);

}



public function getcity(){
	$city = $this->input->post('City');

	$cqry = "select * from mas_city where city = '".$city."'";

	if($cqry->num_rows() == 0){
		echo "success";
	} else{
		echo "error";
	}

}



public function dynamictariff() {
	date_default_timezone_set('Asia/Kolkata');

    $ratecode = $this->input->post("ratecode");
     $fromdate = $this->input->post('fromdate');
     $todate = $this->input->post('todate');
    $roomtype = $this->input->post('roomtype');
     $resno = $this->input->post('resno');



   
    $rent_query = "exec Check_ratetype '" . $fromdate . "','" . $todate . "','" . $roomtype . "', '" . $ratecode . "', 0";
    $rentres = $this->db->query($rent_query);
    $rentrows = $rentres->result_array();

	$del = "delete from Temp_trans_roomdet_det_rent where roomid ='".$roomtype."' and checkinrenttype ='R' and  ratetypeid ='".$ratecode."'";
	$delete = $this->db->query($del);

	foreach($rentrows as $rent){
   	$ins = "insert into Temp_trans_roomdet_det_rent (Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,hotelid,ratetypeid,GrcNo)
			values('".$rent['TheDate']."','".$rent['RoomType_Id']."','".$rent['Single']."','".$rent['Doubles']."','".$rent['Triple']."','".$rent['Quadruple']."','R','".$rent['Single']."','".$rent['Doubles']."','".$rent['Triple']."','".$rent['Quadruple']."','".$rent['AdultRate']."','".User_id."','".Hotel_Id."','".$rent['plantype_id']."','".$resno."')";
 
			$execup = $this->db->query($ins);
	}





	$sel = "select * from Temp_trans_roomdet_det_rent where roomid ='".$roomtype."' and checkinrenttype ='R' and  ratetypeid ='".$ratecode."'";

	$query = $this->db->query($sel)->result_array();

    $output = '';
    $firstid = null;
    $lastid = null;



        $i = 0;

		foreach($query as $resqry) {

        $firstid = ($firstid === null) ? $i : $firstid;

        $output .= '<tr>';
        $output .= '<td>' . ($i + 1) . '</td>';
        $output .= '<td><input type="text" name="' . $i . 'date" id="' . $i . 'date" value="' .substr($resqry['Rentdate'], 0, 10) . '" class="form-control" /></td>';
        $output .= '<td><input type="text" name="' . $i . 'single" id="' . $i . 'single" value="' . $resqry['singlerent']. '" class="form-control" /></td>';
        $output .= '<td><input type="text" name="' . $i . 'double" id="' . $i . 'double" value="' .$resqry['Doublerent']. '" class="form-control" /></td>';
        $output .= '<td><input type="text" name="' . $i . 'triple" id="' . $i . 'triple" value="' .$resqry['Triplerent'] . '" class="form-control" /></td>';
        $output .= '<td><input type="text" name="' . $i . 'quartertriple" id="' . $i . 'quartertriple" value="' . $resqry['Quartertriplerent']. '" class="form-control" /></td>';
        $output .= '<td><input type="text" name="' . $i . 'extrabed" id="' . $i . 'extrabed" value="' .$resqry['extraadultcharges']. '" class="form-control" /></td>';
        $output .= '</tr>';

        $lastid = $i;
		$i++;
       
		}


 
    $output .= '<tr style="border-top:2px solid #333;">';
    $output .= '<td style="text-align: center;padding:2px;">';
    $output .= '<a onclick="Replicate(' . $lastid . ', ' . $firstid . ')" class="btn btn-warning btn-sm">Replicate</a>';
    $output .= '</td>';
    $output .= '<td></td><td></td><td></td><td></td>';
    $output .= '<td style="text-align: center;">';
    $output .= '<input type="submit" class="btn btn-warning btn-sm">';
    $output .= '</td>';
    $output .= '<td style="text-align: center;">';
    $output .= '<a onclick="closetariff()" class="btn btn-warning btn-sm">Cancel</a>';
    $output .= '</td>';
    $output .= '</tr>';



    echo $output;
	
}


public function dynamictarrifupdate()
{

		date_default_timezone_set('Asia/Kolkata');


	 $fromdate = $this->input->post('fromdate');
	 $todate = $this->input->post('todate');
	 $roomtype = $this->input->post('roomtype');
	 $ratecode = $this->input->post('ratecode');
	 
	 
 

	$aa_date = date_create($fromdate); 
			$l_date = date_create($todate);
			$diff = date_diff($aa_date, $l_date);
			$difference = $diff->format("%a");

			for ($i = 0; $i <= $difference; $i++) {

				$date = $_REQUEST[$i . "date"];


$dateObj = DateTime::createFromFormat('d/m/Y', $date);


            if ($dateObj) {
    $formattedDate = $dateObj->format('Y-m-d');
             } else {
    $formattedDate = null; 
              }
				  $single = $_REQUEST[$i . "single"];
         $double = $_REQUEST[$i . "double"];
         $triple = $_REQUEST[$i . "triple"];
         $quartertriple = $_REQUEST[$i . "quartertriple"];
        // $extrabed = $_REQUEST[$i . "extrabed"];

        // if ($extrabed == '') {
        //     $extrabed = 0;
        // }

	

		$get = "select * from Temp_trans_roomdet_det_rent where Rentdate = '".$formattedDate."' and roomid = '".$roomtype."' ";
		$getexe = $this->db->query($get);

		$getcount = $getexe->num_rows();
		//    --  extraadultcharges = '$extrabed',

		if($getcount){

				$up = "UPDATE Temp_trans_roomdet_det_rent 
                 SET singlerent = '".$single."',
                         Doublerent = '".$double."',
                         Triplerent = '".$triple."',
                        Quartertriplerent = '".$quartertriple."',
                 
					 checkinrenttype = 'R'
                     WHERE Rentdate = '".$formattedDate."' and roomid = '".$roomtype."'";
					 $execups = $this->db->query($up);

					 
$ups = "UPDATE mas_rateplan_det 
        SET Single='".$single."',
            Doubles='".$double."',
            Triple='".$triple."',
            Quadruple='".$quartertriple."' 
        WHERE RatePlan_Id = '".$ratecode."'";

$execup = $this->db->query($ups);



		} else{

			$ins = "insert into Temp_trans_roomdet_det_rent (Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,userid,hotelid)
			values('".$formattedDate."','".$roomtype."','".$single."','".$double."','".$triple."','".$quartertriple."','R','".$single."','".$double."','".$triple."','".User_id."','".Hotel_Id."')";
 
			$execups = $this->db->query($ins);

			$ups = "UPDATE mas_rateplan_det 
        SET Single='".$single."',
            Doubles='".$double."',
            Triple='".$triple."',
            Quadruple='".$quartertriple."' 
        WHERE RatePlan_Id = '".$ratecode."'";

$execup = $this->db->query($ups);
		}

				
			}

			if($execup){
   $response = [
            'status' => 'success',
              'single' => $single,
            'double' => $double,
            'triple' => $triple,
            'quartertriple' => $quartertriple
        ];

        header('Content-Type: application/json');
        echo json_encode($response);

			}

}










public function booklogicroutinefunction() {
	date_default_timezone_set('Asia/Kolkata');


        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');
        
 
        if (!$frmdate || !$todate) {
            echo json_encode([
                'status' => 'warning',
                'message' => 'Both From Date and To Date are required.'
            ]);
            return;
        }

        $startDate = new DateTime($frmdate);
        $endDate = new DateTime($todate);


        if ($startDate > $endDate) {
            echo json_encode([
                'status' => 'warning',
                'message' => 'From date cannot be higher than To date.'
            ]);
            return;
        }




		$aa_date = date_create($frmdate);
		$l_date = date_create($todate);
		$diff = date_diff($aa_date, $l_date);
		$difference = $diff->format("%a");
		for ($i = 0; $i <= $difference; $i++) {
		
				$insR = "exec Update_RoomAvailability '" . $frmdate . "', 1";
				$execute = $this->db->query($insR);
				
			
		}



        if ($execute) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Routine successfully booked for the selected dates!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $message
            ]);
        }

   
}


public function Changegueststay_exec()
{
	date_default_timezone_set('Asia/Kolkata');

    $depTime = substr($_POST['depdate'], 11);
    $dqpdate = date("Y-m-d", strtotime($_POST['depdate']));
    $roomid = $_POST['roomid'];


	
	$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

	$set = $this->db->query($setqry)->row_array();



	if($set['Enablebeehivesroominventoryintergration'] == 1) {

		$fromroomnoqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
		inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
		inner join room_status rs on rs.Roomid = mr.Room_Id
		WHERE mr.Room_id = '".$roomid."'";

		$fromroomno = $this->db->query($fromroomnoqry)->row_array();

	  $rsdetqry = "INSERT INTO trans_roomstatus_det
	(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,updateflg)
	VALUES ('".$fromroomno['RoomNo']."','".$_REQUEST['roomid']."','".$fromroomno['RoomType_Id']."','".$fromroomno['grcid']."','".$fromroomno['roomgrcid']."','".$fromroomno['RoomType']."','".date("Y-m-d") ."','".date("H:i:s") ."','','','CHANGE GUEST STAY','0'); ";
    $qry= $this->db->query($rsdetqry);

	}

    $qry = "exec Update_ChangeguestStay '".$dqpdate."','".$depTime."', '".$roomid."', '".User_id."'";
    $res = $this->db->query($qry);

    $msg = $this->db->error();
    if ($res) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $msg['message']]);
    }
}


public function getroomtypeid() {
	date_default_timezone_set('Asia/Kolkata');

    $Roomid = $_REQUEST['Roomid'];

    $type = "SELECT * FROM mas_room WHERE Room_Id = '".$Roomid."'";
    $ectye = $this->db->query($type)->row_array();

    $roomtype = isset($ectye['RoomType_Id']) ? $ectye['RoomType_Id'] : null;

    echo json_encode([
        'roomtypeid' => $roomtype
    ]);
}


public function RoomStatusChange_exec() {

	date_default_timezone_set('Asia/Kolkata');

	$BlockType = $this->input->post("BlockType");
	$roomid = $this->input->post("roomid");
	$reason = $this->input->post("reason");
	$fromDate = $this->input->post("fromDate");
	$toDate = $this->input->post("toDate");
	$totime = $this->input->post("totime");
	$fromtime = $this->input->post("fromtime");
	if ($BlockType == '1') {
        $FoBlock = 1;
        $MBlock = 0;

			
	$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

	$set = $this->db->query($setqry)->row_array();



	if($set['Enablebeehivesroominventoryintergration'] == 1) {

		$fromroomnoqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
		inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
		inner join room_status rs on rs.Roomid = mr.Room_Id
		WHERE mr.Room_id = '".$roomid."'";

		$fromroomno = $this->db->query($fromroomnoqry)->row_array();

	  $rsdetqry = "INSERT INTO trans_roomstatus_det
	(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,updateflg)
	VALUES ('".$fromroomno['RoomNo']."','".$_REQUEST['roomid']."','".$fromroomno['RoomType_Id']."','".$fromroomno['grcid']."','".$fromroomno['roomgrcid']."','".$fromroomno['RoomType']."','".date("Y-m-d", strtotime($_REQUEST['fromDate'])) ."','".date("H:i:s", strtotime($_REQUEST['fromtime'])) ."','".date("Y-m-d", strtotime($_REQUEST['toDate']))."','".date("H:i:s", strtotime($_REQUEST['totime']))."','FOBLOCK','0'); ";
    $qry= $this->db->query($rsdetqry);

	}

    } else {
        $FoBlock = 0; 
        $MBlock = 1;
			
	$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

	$set = $this->db->query($setqry)->row_array();



	if($set['Enablebeehivesroominventoryintergration'] == 1) {

		$fromroomnoqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo,rs.grcid,rs.roomgrcid FROM mas_room mr
		inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
		inner join room_status rs on rs.Roomid = mr.Room_Id
		WHERE mr.Room_id = '".$roomid."'";

		$fromroomno = $this->db->query($fromroomnoqry)->row_array();

	  $rsdetqry = "INSERT INTO trans_roomstatus_det
	(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,updateflg)
	VALUES ('".$fromroomno['RoomNo']."','".$_REQUEST['roomid']."','".$fromroomno['RoomType_Id']."','".$fromroomno['grcid']."','".$fromroomno['roomgrcid']."','".$fromroomno['RoomType']."','".date("Y-m-d", strtotime($_REQUEST['fromDate'])) ."','".date("H:i:s", strtotime($_REQUEST['fromtime'])) ."','".date("Y-m-d", strtotime($_REQUEST['toDate']))."','".date("H:i:s", strtotime($_REQUEST['totime']))."','MBLOCK','0'); ";
    $qry= $this->db->query($rsdetqry);

	}
    }

 
    if (!isset($roomid) || !isset($reason) || !isset($fromDate) || !isset($toDate)) {
        echo json_encode(['success' => false, 'error' => 'Missing required parameters.']);
        return;
    }

  
    $qry1 = "
        INSERT INTO Trans_blockmas (
            dirty, blockdate, blockno, reason, roomid, mblock, foblock,
            fromdate, fromtime, todate, totime, blockeduserid, blocktime
        ) VALUES (
            '1', CONVERT(VARCHAR, GETDATE(), 23), dbo.BlockMasNo(), '" . $reason . "', '" . $roomid . "', 
            '" . $MBlock . "', '" . $FoBlock . "',
            '" . date("Y-m-d", strtotime($fromDate)) . "','".$fromtime."',
            '" . date("Y-m-d", strtotime($toDate)) . "','".$totime."',
            '" . User_id . "', CONVERT(VARCHAR, GETDATE(), 108)
        );
    ";

    $this->db->query($qry1);

    $qry2 = "
        UPDATE Room_Status 
        SET Status='N', blocked='1', mblock='" . $MBlock . "', foblock='" . $FoBlock . "' 
        WHERE Roomid='" . $roomid . "';
    ";

  
    $this->db->query($qry2);

 
    $check = "
        SELECT tb.fromdate, mr.roomtype_id AS typeid, tb.todate, tb.roomgrcid
        FROM Trans_blockmas tb 
        INNER JOIN mas_room room ON room.room_id = tb.roomid
        INNER JOIN mas_roomtype mr ON mr.roomtype_id = room.roomtype_id
        WHERE tb.roomid = '" . $roomid . "'
        AND tb.fromdate = '" . date("Y-m-d", strtotime($_REQUEST['fromDate'])) . "'
        AND tb.todate = '" . date("Y-m-d", strtotime($_REQUEST['toDate'])) . "'
    ";

    
    $checkqry = $this->db->query($check)->row_array();
    if (!$checkqry) {
        echo json_encode(['success' => false, 'error' => 'Block record not found.']);
        return;
    }


    $cid = $checkqry['fromdate'];
    $typeid = $checkqry['typeid'];
    $expcdate = $checkqry['todate'];

  
    $aa_date = date_create($cid);
    $l_date = date_create($expcdate);
    $diff = date_diff($aa_date, $l_date);
    $difference = $diff->format("%a");

 
    for ($i = 0; $i <= $difference; $i++) {
     
        $val = "EXEC roomavailability_validation '" . $cid . "', '" . $typeid . "'";
        $validationResult = $this->db->query($val)->row_array();

       
        if ($validationResult) {
            $insR = "EXEC Update_RoomAvailability '" . $cid . "', '" . $typeid . "'";
            $this->db->query($insR);
        }

     
        $cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
    }

  
    echo json_encode(['success' => true, 'msg' => "Room status changed successfully."]);
}

public function ReinstateNoShows_Save()
{
  
	date_default_timezone_set('Asia/Kolkata');
    ob_start();


    $resdetid     = $this->input->post('resdetid');
    $idv          = $this->input->post('idv');
    $ResNo        = $this->input->post('ResNo');
      $Arrival      = $this->input->post('Arrival');
      $Departure    = $this->input->post('Departure');
     $NewArrival   = $this->input->post('NewArrival');
     $NewDeparture = $this->input->post('NewDeparture');
    $typeid       = $this->input->post('typeid');
    $noofrooms    = $this->input->post('noofrooms');





    $date = date("Y-m-d");
    $time = date("H:i:s");


    $sql2 = "DELETE FROM Trans_Reserve_det1 WHERE refresdetid = '$resdetid'";
    $this->db->query($sql2);


    $sql = "INSERT INTO trans_reservenoshow(
        entrydate, entrytime, resid, resno,
        noshowarrivaldate, noshowarrivaltime,
        noshowdeparturedate, noshowdeparturetime,
        newarrivaldate, newarrivaltime,
        newdeparturedate, newdeparturetime, userid)
        VALUES (
        '$date', '$time', '$idv', '$ResNo',
        '" . date('Y-m-d', strtotime(substr($Arrival, 0, 10))) . "', '" . substr($Arrival, 34, 45) . "',
        '" . date('Y-m-d', strtotime(substr($Departure, 0, 10))) . "', '" . substr($Departure, 34, 45) . "',
        '" . date('Y-m-d', strtotime(substr($NewArrival, 0, 10))) . "', '" . substr($NewArrival, 11, 5) . "',
        '" . date('Y-m-d', strtotime(substr($NewDeparture, 0, 10))) . "', '" . substr($NewDeparture, 11, 5) . "',
        '" . User_id . "'
    )";

    // Step 3: Update Trans_Reserve_det
    $sql1 = "UPDATE Trans_Reserve_det
            SET Noshows = '0',
                fromdate = '" . date('Y-m-d', strtotime(substr($NewArrival, 0, 10))) . "',
                fromtime = '" . substr($NewArrival, 11, 5) . "',
                todate = '" . date('Y-m-d', strtotime(substr($NewDeparture, 0, 10))) . "',
                totime = '" . substr($NewDeparture, 11, 5) . "'
            WHERE resid = '$idv'";

    // Step 4: Insert new reservation detail records (Trans_Reserve_det1)
    $sql3 = "";
    $Indate = date('Y/m/d', strtotime(substr($NewArrival, 0, 10)));
    $todate = date('Y/m/d', strtotime(substr($NewDeparture, 0, 10)));
    $From = $Indate;

    while ($Indate <= $todate) {
        $fromtime = ($From == $Indate) ? substr($NewArrival, 11, 5) : "00:00";
        $totime = ($Indate == $todate) ? substr($NewDeparture, 11, 5) : "00:00";

        $sql3 .= "INSERT INTO Trans_Reserve_det1 (
                    resdate, typeid, noofrooms, refresdetid,
                    fromtime, totime, fromdate, todate, ratetypeid
                  ) VALUES (
                    '$date', '$typeid', '$noofrooms', '$resdetid',
                    '$fromtime', '$totime', '$Indate', '$Indate', '$typeid'
                  );\n";

        $Indate = date("Y/m/d", strtotime("+1 day", strtotime($Indate)));
    }


    echo "BEGIN TRY\n";
    echo "BEGIN TRANSACTION\n";
    echo $sql3;
    echo $sql . ";\n";
    echo $sql1 . ";\n";
    echo "IF @@ERROR <> 0 ROLLBACK TRAN ELSE COMMIT TRAN\n";
    echo "END TRY\n";
    echo "BEGIN CATCH\n";
    echo "ROLLBACK TRAN\n";
    echo "SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;\n";
    echo "END CATCH\n";


    $sqc = ob_get_clean();
    $res = $this->db->query($sqc);

    $this->db->close();
    $this->db->reconnect();

    // Step 6: Update room availability
    if ($res) {
        $check = "SELECT tdet.fromdate, tdet.typeid, tdet.todate, mas.resid
                  FROM Trans_reserve_mas mas
                  INNER JOIN Trans_reserve_det tdet ON tdet.resid = mas.resid
                  WHERE mas.resid = '$resdetid'";
        $checkqry = $this->db->query($check);

        foreach ($checkqry->result_array() as $ress) {
            $cid = $ress['fromdate'];
            $typeid = $ress['typeid'];
            $expcdate = $ress['todate'];

            $startDate = date_create($cid);
            $endDate = date_create($expcdate);
            $diff = date_diff($startDate, $endDate);
            $days = $diff->format("%a");

            for ($i = 0; $i <= $days; $i++) {
                $currentDate = date("Y-m-d", strtotime("+$i day", strtotime($cid)));

                $val = "EXEC roomavailability_validation '$currentDate', '$typeid'";
                $validationResult = $this->db->query($val);

                $this->db->close();
                $this->db->reconnect();

                if ($validationResult) {
                    $updateRoom = "EXEC Update_RoomAvailability '$currentDate', '$typeid'";
                    $this->db->query($updateRoom);

                    $this->db->close();
                    $this->db->reconnect();
                }
            }
        }

    
        echo "success";
    } else {
        
        echo "error";
    }
}


// public function get_room_data(){
// 	echo "123";
// }
	

// public function power_save(){

// 	$roomno = $this->input->post('roomno');
	
// 	$insqry = "select mc.control,md.Device from mas_control mc
// inner join mas_Room mr on mr.Room_Id = mc.Room_Id
// inner join mas_device md on mc.Device = md.Device
// inner join mas_status ms on ms.Status_Id = md.Dev_status
// where mr.RoomNo = '".$roomno."'";

// $ins = $this->db->query($insqry)->row_array();

// $ins['control'] ,$ins['Device']

// insert into trans_power(powerid,roomno,process,devicenumber)



// }



	
public function checkincancellation($ID = -1, $BUT = 'SAVE')
{
	$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'checkincancellation', 'ID' => $ID, 'BUT' => $BUT);
	$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
}

public function Checkincancellationsave()
{
    date_default_timezone_set('Asia/Kolkata');

    $Reason   = $this->input->post('Reason');
    $grcid    = $this->input->post('grcid');
    $guest    = $this->input->post('guest');

    $cur_date = date("Y-m-d");
    $cur_time = date("H:i:s");

   
    $romup       = "";
    $rsdetqry    = "";
    $ins9        = "";
    $fromroomnoqry = "";

 
    $up = "
        UPDATE trans_checkin_mas
        SET reason      = '".$Reason."',
            cancelflag  = 1,
            canceldate  = '".$cur_date."',
            canceltime  = '".$cur_time."'
        WHERE Grcid = '".$grcid."';
    ";


    $checkincanqry = "SELECT * FROM room_status WHERE Grcid = '".$grcid."'";
    $checkin = $this->db->query($checkincanqry)->result_array();

    foreach ($checkin as $checkinrow) {

      
        $romup .= "
            UPDATE room_status 
            SET status = 'N' 
            WHERE roomid = '".$checkinrow['Roomid']."';
        ";

        // 2. if beehives integration enabled
        $set = $this->db->query("SELECT Enablebeehivesroominventoryintergration FROM ExtraOption")->row_array();

        if ($set['Enablebeehivesroominventoryintergration'] == 1) {

            $fromroomnoqry = "
                SELECT mrtype.RoomType_Id, mrtype.RoomType, mr.RoomNo, rs.grcid, rs.roomgrcid
                FROM mas_room mr
                JOIN mas_roomtype mrtype ON mrtype.RoomType_Id = mr.RoomType_Id 
                JOIN room_status rs ON rs.Roomid = mr.Room_Id
                WHERE mr.Room_Id = '".$checkinrow['Roomid']."'
            ";

            $fromroomno = $this->db->query($fromroomnoqry)->row_array();

            $rsdetqry .= "
                INSERT INTO trans_roomstatus_det
                (fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,
                 fromdate, fromtime, todate, totime, roomstatus, billno,updateflg)
                VALUES (
                    '".$fromroomno['RoomNo']."',
                    '".$checkinrow['Roomid']."',
                    '".$fromroomno['RoomType_Id']."',
                    '".$fromroomno['grcid']."',
                    '".$fromroomno['roomgrcid']."',
                    '".$fromroomno['RoomType']."',
                    '".$cur_date."',
                    '".$cur_time."',
                    '',
                    '',
                    'CHECKIN CANCEL',
                    '',
					'0'
                );
            ";
        }

        // 3. POWER CONTROL
        $set = $this->db->query("SELECT enablepower FROM extraoption")->row_array();

        if ($set['enablepower'] == 1) {

            $roomnumber = $this->db
                ->query("SELECT RoomNo FROM mas_room WHERE Room_Id = '".$checkinrow['Roomid']."'")
                ->row_array();

            $otherDB = $this->load->database('another_db', TRUE);

            $selroom = "
                SELECT mc.ControlType_Id AS control, md.Device
                FROM mas_control mc
                JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
                JOIN mas_device md ON mc.Device = md.Device
                WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'
            ";

            $result = $otherDB->query($selroom)->result_array();

            foreach ($result as $res) {
                $process_id = $otherDB->query("SELECT Status_Id FROM mas_status WHERE upper(status)='CHECKOUT'")
                                      ->row_array();

                $ins9 .= "
                    INSERT INTO trans_power 
                    (roomno, Process, control, devicenumber, Roomgrcid, Remarks,
                     powerondate, powerontime, customer, usersname, onoff)
                    VALUES (
                        '".$roomnumber['RoomNo']."',
                        '".$process_id['Status_Id']."',
                        '".$res['control']."',
                        '".$res['Device']."',
                        '".$checkinrow['roomgrcid']."',
                        'Checkin cancel',
                        '".$cur_date."',
                        '".$cur_time."',
                        '".$guest."',
                        '".$guest."',
                        '1'
                    );
                ";
            }
        }
    }

    // OUTPUT FINAL SQL BLOCK
    echo "BEGIN TRY\n";
    echo "BEGIN TRANSACTION\n";
    echo $up;
    echo $romup;
    echo $rsdetqry;
    echo $ins9;
    echo "IF @@ERROR <> 0 ROLLBACK TRAN ELSE COMMIT TRAN\n";
    echo "END TRY\n";
    echo "BEGIN CATCH\n";
    echo "ROLLBACK TRAN\n";
    echo "SELECT ERROR_NUMBER() AS ErrorNumber, ERROR_MESSAGE() AS ErrorMessage;\n";
    echo "END CATCH\n";

	  $sqc = ob_get_clean();
    $res = $this->db->query($sqc);
	// exit;
    $this->db->close();
    $this->db->reconnect();

	if ($res) {
		
          
            $cid = $_REQUEST['fromdate'];
            $typeid = $_REQUEST['roomtypeid'];
            $expcdate = $_REQUEST['todate'];

            $startDate = date_create($cid);
            $endDate = date_create($expcdate);
            $diff = date_diff($startDate, $endDate);
            $days = $diff->format("%a");

            for ($i = 0; $i <= $days; $i++) {
                $currentDate = date("Y-m-d", strtotime("+$i day", strtotime($cid)));

                    $updateRoom = "EXEC Update_RoomAvailability '$currentDate', '$typeid'";
                    $this->db->query($updateRoom);

                    $this->db->close();
                    $this->db->reconnect();
              
            }
      
        echo "success";
    } else {
        
        echo "error";
    }

	
}


public function GroupCheckout()
{
	$data = array('F_Class' => 'Transaction', 'F_Ctrl' => 'GroupCheckout');
	$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
}


public function groupcheckoutsave()
	{
		
		date_default_timezone_set('Asia/Kolkata');


		$room_ids = $_REQUEST['Room_id'];
	
		if (!is_array($room_ids) || count($room_ids) == 0) {
			exit("No Room IDs received.");
		}
	

		if (count($room_ids) > 1) {
			$sql = "SELECT ISNULL(MAX(grpcheckoutbillid),0) + 1 AS NextGroup FROM Trans_Checkout_mas";
			$res = $this->db->query($sql)->row_array();
			$nextGroupCheckout = $res['NextGroup'];
		} else {
			$nextGroupCheckout = 0;
		}
	
	
		foreach ($room_ids as $rid) {
	
			$sql = "SELECT roomgrcid, grcid FROM room_status WHERE roomid = '$rid'";
			$q = $this->db->query($sql);

			$roomtypeqry = "SELECT mrtype.RoomType_Id, mrtype.RoomType,mr.RoomNo FROM mas_room mr
			inner join mas_roomtype mrtype on mrtype.RoomType_Id = mr.RoomType_Id 
			WHERE mr.Room_id = '$rid'";

			$roomtype = $this->db->query($roomtypeqry)->row_array();

			
			$chkqry = "select Checkoutno,Checkoutdate,Checkouttime from trans_checkout_mas where Roomid ='".$rid."'order by Checkoutno desc ";

			$chkq = $this->db->query($chkqry)->row_array();
	
			if ($q->num_rows() == 0) continue;
	
			$r = $q->row_array();
	
			$sql = "INSERT INTO Temp_checkout_room(Roomid, Roomgrcid, grcid)
					VALUES ('".$rid."', '".$r['roomgrcid']."', '".$r['grcid']."')";
			$this->db->query($sql);



			$setqry = "select Enablebeehivesroominventoryintergration from ExtraOption";

			$set = $this->db->query($setqry)->row_array();

		

			if($set['Enablebeehivesroominventoryintergration'] == 1) {

			  $rsdetqry = "INSERT INTO trans_roomstatus_det
			(fromroomno, fromroomid, typeid, grcid, roomgrcid, roomtype,fromdate, fromtime, todate, totime,roomstatus,billno,updateflg)
			VALUES ('".$roomtype['RoomNo']."','".$rid."','".$roomtype['RoomType_Id']."','".$r['grcid']."','".$r['roomgrcid']."','".$roomtype['RoomType']."','".date("Y-m-d") ."','".date("H:i:s") ."','".$chk['Checkoutdate']."','".$chk['Checkouttime']."','CHECKOUT','".$chkq['Checkoutno']."','0'); ";

$resde = $this->db->query($rsdetqry);




			}

			$setqry = "select enablepower from extraoption";

		$set = $this->db->query($setqry)->row_array();

		if($set['enablepower'] == 1) {

   $select ="select RoomNo from mas_room where Room_Id = '".$rid."'";

  $roomnumber = $this->db->query($select)->row_array();


  $otherDB = $this->load->database('another_db', TRUE);


  $selroom = "
  SELECT mc.ControlType_Id as control, md.Device
  FROM mpower_beehives.dbo.mas_control mc
  INNER JOIN mpower_beehives.dbo.mas_Room mr ON mr.Room_Id = mc.Room_Id
  INNER JOIN mpower_beehives.dbo.mas_device md ON mc.Device = md.Device
  WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";
  
  $result = $otherDB->query($selroom)->result_array();

  foreach($result as $res) {

$control = $res['control'];
$Device = $res['Device'];


$process = "select Status_Id from mas_status where upper(status) = 'CHECKOUT'";

$process_id = $otherDB->query($process)->row_array();

$today = date('Y-m-d');
$nowtime = date('H:i:s');



	$insertqry= "
	INSERT INTO trans_power (roomno, Process,control, devicenumber,Roomgrcid,Remarks,powerondate,powerontime,onoff)
	VALUES ('".$roomnumber['RoomNo']."', '".$process_id['Status_Id']."','".$control."','".$Device."','".$r['roomgrcid']."','Checkout','".$today."','".$nowtime."','1')";

	$insexe = $this->db->query($insertqry);
	
  }
}
			
		
		}

		// $this->db->close();
		// $this->db->reconnect();
	
	
		$sql = "EXEC Exec_GroupCheckout_Save '" . date("Y-m-d") . "','" . User_id . "','" . $nextGroupCheckout . "'";
		$this->db->query($sql);
	

		$sql = "
			SELECT cm.Checkoutid
			FROM Trans_checkout_mas cm
			INNER JOIN Trans_checkin_mas ch ON ch.Grcid = cm.grcid
			INNER JOIN Trans_RoomCustomer_det det ON det.grcid = ch.Grcid
			INNER JOIN mas_customer cus ON cus.Customer_Id = det.Customerid
			INNER JOIN mas_title t ON t.Titleid = cus.Titelid
			INNER JOIN Trans_Roomdet_det roomdet ON roomdet.grcid = ch.Grcid
			INNER JOIN Mas_room room ON room.Room_Id = roomdet.Roomid
			INNER JOIN Mas_RoomType mr ON mr.RoomType_Id = room.RoomType_Id
			INNER JOIN Mas_Hotel mh ON mh.Hotel_Id='" . Hotel_Id . "'
			WHERE cm.Checkoutid = IDENT_CURRENT('Trans_checkout_mas')
			  AND cm.checkoutno LIKE '%CHK%'
		";
	
		$result = $this->db->query($sql);
	
		$Checkoutid = 0;
		if ($result && $result->num_rows() > 0) {
			$row = $result->row_array();
			$Checkoutid = $row['Checkoutid'];
		}
	
	
	
	
		if ($Checkoutid > 0) {
			$sql = "SELECT grpcheckoutbillid FROM Trans_checkout_mas WHERE Checkoutid='" . $Checkoutid . "'";
			$ckid = $this->db->query($sql)->row_array();
			$grpCheckoutBillId = $ckid['grpcheckoutbillid'];
		}


	
		// foreach ($room_ids as $rid) {

		// 	$checkout = "SELECT cmas.roomgrcid, cmas.checkoutdate, room.typeid, room.depdate
		// 				 FROM trans_checkout_mas cmas
		// 				 INNER JOIN Trans_Roomdet_det room ON room.roomgrcid = cmas.roomGrcid
		// 				 WHERE cmas.roomgrcid = '".$roomgrcid."'";
		// 	$checkqry = $this->db->query($checkout);
	
		// 	foreach ($checkqry->result_array() as $ress) {
		// 		$cid    = $ress['checkoutdate'];
		// 		$typeid = $ress['typeid'];
		// 		$depdate= $ress['depdate'];
		// 	}
	
		// 	$aa_date = date_create($cid); 
		// 	$l_date  = date_create($depdate);
		// 	$diff    = date_diff($aa_date, $l_date);
		// 	$difference = $diff->format("%a");
	
		// 	for ($i = 0; $i <= $difference; $i++) {
		// 		$insR = "exec Update_RoomAvailability '" . $cid . "', '" . $typeid . "'";
		// 		$execute = $this->db->query($insR);
		// 		$this->db->close();
		// 		$this->db->reconnect();
		// 		$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
		// 	}
		// }

	
		echo $grpCheckoutBillId;


		



	
		// if (!is_array($room_ids) || empty($room_ids)) {
		// 	echo "No room selected!";
		// 	return;
		// }
	

	// 	$selqry = "Select * from Temp_checkout_room";
	// 	$sel = $this->db->query($selqry)->result_array();
		


	// 	foreach($sel as $sel) {
	

	
	// 		if (!$res || $res->num_rows() == 0) {
	// 			continue; 
	// 		}
	
		
	

	// 		$sql2 = "SELECT roomgrcid, grcid FROM room_status WHERE roomid = ?";
	// 		$res2 = $this->db->query($sql2, [$sel['Roomid']]);
	// 		$row  = $res2->row_array();
	// 		if (!$row) continue;
	
	// 		$roomgrcid = $row['roomgrcid'];
	// 		$grcid     = $row['grcid'];
	
	// 		$this->db->close();
	// 		$this->db->reconnect();
	
	// 		// 3. Check if WhatsApp/SMS for checkout is enabled
			// $check = $this->db->query("SELECT ISNULL(enablewhatsappsmsforcheckout,0) AS checkout FROM extraoption");
			// $enableCheckout = 0;
			// foreach ($check->result_array() as $r) {
			// 	$enableCheckout = $r['checkout'];
			// }
	
			// if ($enableCheckout == 1) {
			// 	// 4. Get checkout details
			// 	$qry = "SELECT mh.Company AS Com, *
			// 			FROM Trans_checkout_mas cm
			// 			INNER JOIN Trans_checkin_mas ch ON ch.Grcid = cm.grcid
			// 			INNER JOIN Trans_RoomCustomer_det det ON det.grcid = ch.Grcid
			// 			INNER JOIN mas_customer cus ON cus.Customer_Id = det.Customerid
			// 			INNER JOIN mas_title t ON t.Titleid = cus.Titelid
			// 			INNER JOIN Trans_Roomdet_det roomdet ON roomdet.grcid = ch.Grcid
			// 			INNER JOIN Mas_room room ON room.Room_Id = roomdet.Roomid
			// 			INNER JOIN Mas_RoomType mr ON mr.RoomType_Id= room.RoomType_Id
			// 			INNER JOIN Trans_checkout_mas outm ON outm.grcid = ch.Grcid
			// 			INNER JOIN Mas_Hotel mh ON mh.Hotel_Id='" . Hotel_Id . "'
			// 			WHERE cm.Checkoutid = IDENT_CURRENT('Trans_checkout_mas') AND cm.checkoutno LIKE '%CHK%'";
				
			// 	$result = $this->db->query($qry);
				
	
			// 	foreach ($result->result_array() as $row1) {
			// 		$firstname   = $row1['Firstname'];
			// 		$lastname    = $row1['Lastname'];
			// 		$title       = $row1['Title'];
			// 		$name        = $title . '.' . $firstname . $lastname;
			// 		$roomno      = $row1['RoomNo'];
			// 		$roomType    = $row1['RoomType'];
			// 		$rent        = $row1['roomrent'];
			// 		$company     = $row1['Com'];
			// 		$mobile      = $row1['Mobile'];
			// 		$checkintime = (new DateTime($row1['CheckinTime']))->format('H:i');
			// 		$resno       = $row1['Grcno'];
			// 		$checkindate = date('Y-m-d', strtotime(substr($row1['CheckinDate'], 0, 10)));
			// 		$billamount  = $row1['totalamount'];
			// 		$checkoutdate= date('Y-m-d', strtotime(substr($row1['Checkoutdate'], 0, 10)));
			// 		$url         = $row1['feedbackmoduleurl'];
			// 		$Checkoutid  = $row1['Checkoutid'];
			// 	}
	
				
				
			// 	$detmsg = '';
			// 	$i = 1;
			// 	$temqury = "SELECT Template, campaign FROM mas_smsmessage WHERE ISNULL(CheckoutGuest,0)='1'";
			// 	$smsTemp = $this->db->query($temqury);
	
			// 	foreach ($smsTemp->result_array() as $row) {
			// 		$msg = $row['Template'];
			// 		$campaignname = $row['campaign'];
			// 		$smstype = 'GCHK';
	
	
			// 		$msg = str_replace('*GuestName*', $name, $msg);
			// 		$msg = str_replace('*FeedbackURL*', $url, $msg);
	
					
			// 		$inss = "INSERT INTO outbox (MobileNumber, SMSMessage, DateCreated, campaign)
			// 				 VALUES('" . $mobile . "','" . $msg . "',CONVERT(VARCHAR, GETDATE(), 20),'" . $campaignname . "')";
			// 		$execins = $this->db->query($inss);
			// 	}
			// }
	
			
			// $checkout = "SELECT cmas.roomgrcid, cmas.checkoutdate, room.typeid, room.depdate
			// 			 FROM trans_checkout_mas cmas
			// 			 INNER JOIN Trans_Roomdet_det room ON room.roomgrcid = cmas.roomGrcid
			// 			 WHERE cmas.roomgrcid = '".$roomgrcid."'";
			// $checkqry = $this->db->query($checkout);
	
			// foreach ($checkqry->result_array() as $ress) {
			// 	$cid    = $ress['checkoutdate'];
			// 	$typeid = $ress['typeid'];
			// 	$depdate= $ress['depdate'];
			// }
	
			// $aa_date = date_create($cid); 
			// $l_date  = date_create($depdate);
			// $diff    = date_diff($aa_date, $l_date);
			// $difference = $diff->format("%a");
	
			// for ($i = 0; $i <= $difference; $i++) {
			// 	$insR = "exec Update_RoomAvailability '" . $cid . "', '" . $typeid . "'";
			// 	$execute = $this->db->query($insR);
			// 	$this->db->close();
			// 	$this->db->reconnect();
			// 	$cid = date("Y-m-d", strtotime('+1 day', strtotime($cid)));
			// }
		
	
	// }

	
		
	// $trunt = "truncate table Temp_checkout_room";
	// $tr = $this->db->query($trunt);

	// echo $Checkoutid;

	// print_r($Checkoutid);
//  $getcheckid = "select grpcheckoutbillid from Trans_checkout_mas where Checkoutid='".$Checkoutid."'"; 

//  $ckid = $this->db->query($getcheckid)->row_array();
 
//  echo $ckid['grpcheckoutbillid'];
		
	}
	

	
public function groupsettlement()
{
	  $Billid = $this->input->post('Billid');
	$data = array(
		'F_Class' => 'Transaction', 
		'F_Ctrl' => 'settlement_group',
		'Billid' => $Billid
	);


	
	if (!$data['Billid']) {
		show_error('Invalid Bill ID');
		return;
	}
	
	$this->load->view($data['F_Class'] . '/' . $data['F_Ctrl'], $data);
}

public function groupSettlementsave()
{
	date_default_timezone_set('Asia/Kolkata');

	$datetime = new DateTime();
	$date = $datetime->format('Y-m-d');
	$time = $datetime->format('H:i:s');
	$totalbillamt = $_REQUEST['totalbillamout'];
	$ros = $_REQUEST['ros'];
	$billid = $_REQUEST['Roomid'][0];
     $grpid = $_REQUEST['grpid']; 
	$amt = 0;
	$ins1 = '';
	$ins2 = '';
	$ins3 = '';
	$paidamt = 0;
	$Creditheadid = 0;
	for ($j = 1; $j <= $ros; $j++) {

		$amt = $amt + $_REQUEST['Amt_' . $j];
	}
	if ($totalbillamt == $amt) {
		  $sql = "Select cms.grcid,cms.Roomgrcid,cms.Roomid,Checkoutno,RoomNo, Customerid,totalamount,Checkoutdate,tarrifftypeid,ratetypeid,taxid 
			from Trans_Checkout_mas cms
			  Inner Join Mas_Room rm on rm.Room_Id = cms.Roomid
			  inner join trans_roomdet_det det on det.roomgrcid = cms.Roomgrcid
			  where Checkoutid='" . $billid . "'";
		$res = $this->db->query($sql);
		foreach ($res->result_array() as $row) {

			
			$grcid = $row['grcid'];
			$roomgrcid = $row['Roomgrcid'];
			$roomid = $row['Roomid'];
			$Billno = $row['Checkoutno'];
			$Roomno = $row['RoomNo'];
			$Customerid = $row['Customerid'];
			$tamount = $row['totalamount'];
			$tcheckoutdate = $row['Checkoutdate'];
			$ttariff = $row['tarrifftypeid'];
			$tratetype = $row['ratetypeid'];
			$ttax = $row['taxid'];
		}

		for ($j = 1; $j <= $ros; $j++)
		 {

	$paymode = $_REQUEST['paymode_' . $j]; 




			if ($paymode == "COMPANY") 
			{
				$paidamt = 0;
			} 
			else if ($paymode == "TOROOM") 
			{

				  $sqlto = "select mr.RoomNo, rs.Roomid, * from room_status rs
			inner join mas_room mr on rs.Roomid = mr.Room_Id
			where rs.roomid = '" . @$_REQUEST['bank_' . $j] . "' and isnull(rs.status,'')='Y' and isnull(billsettle,0)=0";
				$exec = $this->db->query($sqlto);
				foreach ($exec->result_array() as $row) {
					$troomid = $row['Roomid'];
					// $roomid = $row['Roomid'];
					$tgrcid = $row['grcid'];
					$troomgrcid = $row['roomgrcid'];
				}

				$sq = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TCR'";
				$exsq = $this->db->query($sq);
				foreach ($exsq->result_array() as $row1) {
					$Creditheadid1 = $row1['Revenue_Id'];
				}
				$sq1 = " SELECT Revenue_Id FROM Mas_Revenue WHERE HeadCode ='TDR'";
				$exsq = $this->db->query($sq);
				foreach ($exsq->result_array() as $row1) {
					$Creditheadid2 = $row1['Revenue_Id'];	
				}
				if ($tamount > 0)
				 {
					$Creditheadid = $Creditheadid1;
				} 
				else if($tamount < 0)					
				{
					$Creditheadid = $Creditheadid2;
				}
				$sqlch = "update trans_checkout_mas set toroomid= '" . $troomid . "' where Checkoutid = '" . $billid . "'";
				$exech = $this->db->query($sqlch);
				$sqlins = "insert into Trans_credit_entry (CreditNo,Roomid,Grcid,CreditDate,
			Creditheadid,Amount,roomgrcid,otherAmount,crtime,tarrifftype,tarriffsetupid,
			Actroomrent,Nettarrifamount,Ratetypeid,actrackrate,chNo)
			values(dbo.Credit_Entry_No(),'" . $troomid . "','" . $tgrcid . "','" . $tcheckoutdate . "','" . $Creditheadid . "','" . $tamount . "',
			'" . $troomgrcid . "','" . $tamount . "',convert(varchar(25),getdate(),108),'" . $ttariff . "','" . $ttax . "',
			'" . $tamount . "','0.00','" . $tratetype . "','" . $tamount . "', '" . 'Chk.No : ' . $Billno . '- RoomNo: ' . $Roomno . "' ) ";
				$execc = $this->db->query($sqlins);

			// 	echo $sqlins;
			}
			 else
			{
				$paidamt = $_REQUEST['Amt_' . $j];
			
			}

		


			$amt = $_REQUEST['Amt_' . $j];
			// $paymode = $_REQUEST['paymode_' . $j];
			$bankid = @$_REQUEST['bank_' . $j];
			$vdate = @$_REQUEST['validate_' . $j];
			$cardnumber = @$_REQUEST['cardno_' . $j];


$paymode_id = $_REQUEST['paymode_' . $j] ?? '';

$sql = "SELECT PayMode_Id FROM mas_paymode WHERE PayMode = ?";
$paymode_row = $this->db->query($sql, [$paymode_id])->row_array();

$paymodeid = $paymode_row['PayMode_Id'] ?? null;


			  $ins1 = $ins1 . "insert into Trans_receipt_mas (Receiptno,Billid,ReceiptType,Amount,paymodeid,cancel,grcid,roomgrcid,rptdate,roomid,billno,narration,customerid,bank,cardnumber,ADJUSTAMOUT,userid,rpttime,validdate)
			values(dbo.SettlementNo(),'" . $billid . "','O','" . $amt . "','".$paymodeid."','0','" . $grcid . "','" . $roomgrcid . "','" . $date . "','" . $roomid . "','" . $Billno . "','Set-Room No." . $Roomno . " BillNo." . $Billno . "','" . $Customerid . "','" . $bankid . "','" . $cardnumber . "','" . $amt . "','" . User_id . "','" . $time . "','" . $vdate . "')";
			$ins2 = $ins2 . "Insert into Trans_Pay_Det(Checkoutid,Paymodeid,Bankid,Amount,ChqNo,Validdate,Paidamount,receiptid,userid,grpcheckoutbillid)
			values('" . $billid . "','". $paymodeid."','" . $bankid . "','" . $amt . "','" . $cardnumber . "','" . $vdate . "','" . $paidamt . "',@Siden,'" . User_id . "','".$grpid."')";
		}

		 $chkqry  = "select roomgrcid,Checkoutid,Roomid, * from trans_checkout_mas where grpcheckoutbillid = '".$grpid."'";
		$chk = $this->db->query($chkqry)->result_array();

		foreach($chk as  $chk) {

		$ins3 = $ins3 . "Insert into Trans_Blockmas(blockdate,blockno,reason,roomgrcid,roomid,dirty,blockeduserid,rptdirty,blocktime,checkoutid)
			values(convert(varchar(25),getdate(),101),dbo.BlockMasNo(),'FROM CHECKOUT','" . $chk['roomgrcid'] . "','" . $chk['Roomid'] . "','1','" . User_id . "','1',convert(varchar(25),getdate(),108),'" . $chk['Checkoutid'] . "')";

		  $sql3 = "select * from Room_Status rs
				INNER JOIN Trans_checkout_mas cmas on cmas.roomgrcid=rs.roomgrcid 
				INNER JOIN Mas_Customer cus on cus.Customer_Id=cmas.Customerid 
				where rs.Status='Y' and isnull(billsettle,0)='1' and isnull(cmas.Settle,0)=0 and isnull(cmas.cancelflag,0)=0 and isnull(cmas.reinstate,0)= 0 and cmas.Checkoutno like 'CHK%' 
				and cmas.roomgrcid='" . $chk['roomgrcid']. "'";
		$res3 = $this->db->query($sql3);
		$NoOfBils = $res3->num_rows();
		$up = '';
		if ($NoOfBils == 1) {
			  $up = "UPDATE Room_status set notready='1',Status='N',grcid='0',billsettle='0',checkindate='',roomgrcid='0' where Roomid='".$chk['Roomid']."'";
				 $res4 = $this->db->query($up);
		}
		$update = "update Trans_checkout_mas set Settle=1 where Checkoutid='" . $chk['Checkoutid'] . "'";
		$res5 = $this->db->query($update);
		
		$setqry = "select enablepower,powercut_after_settlement from extraoption";

		$set = $this->db->query($setqry)->row_array();

		if($set['enablepower'] == 1) {

			if($set['powercut_after_settlement'] == 1) {


			 $custqry = "select Firstname from mas_customer where Customer_Id = '".$Customerid."'";

			 $cust = $this->db->query($custqry)->row_array();
		

		$select ="select RoomNo from mas_room where Room_Id = '".$chk['Roomid']."'";

		$roomnumber = $this->db->query($select)->row_array();
	  
	  
		$otherDB = $this->load->database('another_db', TRUE);
	  
	  
		 $selroom = "
		SELECT mc.ControlType_Id as control, md.Device
		FROM mas_control mc
		INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
		INNER JOIN  mas_device md ON mc.Device = md.Device
		WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";

		
		
		$result = $otherDB->query($selroom)->result_array();
		foreach($result as $res) {

			$control = $res['control'];
			$Device  = $res['Device'];
		
			$process = "SELECT Status_Id FROM mas_status WHERE UPPER(status) = 'CHECKOUT'";
			$process_id = $otherDB->query($process)->row_array();
		
			$today = date('Y-m-d');
			$nowtime = date('H:i:s');
	
			
			$ins4 = "
				INSERT INTO trans_power 
				(roomno, Process, control, devicenumber, Roomgrcid, Remarks, powerondate, powerontime, onoff)
				VALUES (
					'".$roomnumber['RoomNo']."',
					'".$process_id['Status_Id']."',
					'".$control."',
					'".$Device."',
					'".$chk['roomgrcid']."',
					'Checkout',
					'".$today."',
					'".$nowtime."',
					'1'
				)
			";
		
			$this->db->query($ins4);
		}
	}
}
	}


		ob_start();
		@session_start();
		echo "BEGIN Try ";
		echo "BEGIN Transaction ";
		echo "BEGIN Tran ";
		echo "Declare @Siden INT; ";
		echo $ins1;
		echo "set @Siden=@@identity; ";
		echo $ins2;
		echo $ins3;
		echo $update;
		echo $up;
		echo " If @@error<>0 Rollback Tran else Commit Tran ";
		echo "COMMIT ";
		echo "end try ";
		echo "BEGIN CATCH ROLLBACK SELECT ERROR_NUMBER() AS ErrorNumber,ERROR_MESSAGE(); ";
		echo "END CATCH ";
		$sqc = ob_get_clean();
		$ran = rand() . rand() . rand();
		$sq = "Create Procedure #" . $ran . " as " . $sqc . "";
		$result = $this->db->query($sq);
		$result = $this->db->query("exec #" . $ran);
		$this->db->close();
		$this->db->reconnect();
		echo "Bill Settled Successfully";
	} else {
		echo "Amount Incorrect";
	}
}


public function visitingsave(){
	date_default_timezone_set('Asia/Kolkata');
	 $roomno = $_REQUEST['roomNo'];
	 $inDate = $_REQUEST['inDate'];
	 $outDate = $_REQUEST['outDate'];
	 $intime = $_REQUEST['intime'];
	 $totime = $_REQUEST['totime'];
	 $Remarks = $_REQUEST['Remarks'];
	 $roomid = $_REQUEST['roomid'];


	 $frintdate = date('Y-m-d',strtotime($inDate));
	 $froutdate = date('Y-m-d',strtotime($outDate));
	 $setqry = "select enablepower from extraoption";

	 $set = $this->db->query($setqry)->row_array();

	 if($set['enablepower'] == 1) {
	 

	 $select ="select RoomNo from mas_room where Room_Id = '".$roomid."'";

	 $roomnumber = $this->db->query($select)->row_array();
   
   
	 $otherDB = $this->load->database('another_db', TRUE);
   
   
	  $selroom = "
	 SELECT mc.ControlType_Id as control, md.Device
	 FROM mas_control mc
	 INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
	 INNER JOIN  mas_device md ON mc.Device = md.Device
	 WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";

	 
	 
	 $result = $otherDB->query($selroom)->result_array();
	 foreach($result as $res) {

		 $control = $res['control'];
		 $Device  = $res['Device'];
	 
		 $process = "SELECT Status_Id FROM mas_status WHERE UPPER(status) = 'VISITING'";
		 $process_id = $otherDB->query($process)->row_array();
	 
		 $today = date('Y-m-d');
		 $nowtime = date('H:i:s');
	 
		 $ins4 = "
			 INSERT INTO trans_power 
			 (roomno, Process, control, devicenumber, Roomgrcid, Remarks, powerondate, powerontime, customer, usersname, onoff)
			 VALUES (
				 '".$roomnumber['RoomNo']."',
				 '".$process_id['Status_Id']."',
				 '".$control."',
				 '".$Device."',
				 '',
				 'Visiting',
				 '".$today."',
				 '".$nowtime."',
				 '',
				 '',
				 '0'
			 )
		 ";
	 
		$instrns =  $this->db->query($ins4);
	 }
 
}
	 
if($instrns){
	$update = "update room_status set Pwvisiting ='1' ,Pwondate ='".$frintdate."',Pwoffdate='".$froutdate."',Pwontime='".$intime."',Pwofftime='".$totime."' where Roomid='".$roomid."'";

	$upexe = $this->db->query($update);
  
	if($upexe){
	 echo 'success';
	} else{
	  echo 'Fail';
	}
}



}




public function cleaningsave(){
	date_default_timezone_set('Asia/Kolkata');

	 $roomno = $_REQUEST['roomNo'];
	$inDate = $_REQUEST['inDate'];
	$outDate = $_REQUEST['outDate'];
	$intime = $_REQUEST['intime'];
	$totime = $_REQUEST['totime'];
	$Remarks = $_REQUEST['Remarks'];
	$roomid = $_REQUEST['roomid'];
	$frintdate = date('Y-m-d',strtotime($inDate));
	$froutdate = date('Y-m-d',strtotime($outDate));



	$setqry = "select enablepower from extraoption";

				$set = $this->db->query($setqry)->row_array();
		
				if($set['enablepower'] == 1) {
				

				$select ="select RoomNo from mas_room where Room_Id = '".$roomid."'";

				$roomnumber = $this->db->query($select)->row_array();
			  
			  
				$otherDB = $this->load->database('another_db', TRUE);
			  
			  
				 $selroom = "
				SELECT mc.ControlType_Id as control, md.Device
				FROM mas_control mc
				INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
				INNER JOIN  mas_device md ON mc.Device = md.Device
				WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";

				
				
				$result = $otherDB->query($selroom)->result_array();
				foreach($result as $res) {

					$control = $res['control'];
					$Device  = $res['Device'];
				
					$process = "SELECT Status_Id FROM mas_status WHERE UPPER(status) = 'CLEANING'";
					$process_id = $otherDB->query($process)->row_array();
				
					$today = date('Y-m-d');
					$nowtime = date('H:i:s');
				
					$ins4 = "
						INSERT INTO trans_power 
						(roomno, Process, control, devicenumber, Roomgrcid, Remarks, powerondate, powerontime, customer, usersname, onoff)
						VALUES (
							'".$roomnumber['RoomNo']."',
							'".$process_id['Status_Id']."',
							'".$control."',
							'".$Device."',
							'',
							'Cleaning',
							'".$today."',
							'".$nowtime."',
							'',
							'',
							'0'
						)
					";
				
					$instrns = $this->db->query($ins4);
				}
			
		}
				


if($instrns){

	$update = "update room_status set Pwcleaning ='1' ,Pwondate ='".$frintdate."',Pwoffdate='".$froutdate."',Pwontime='".$intime."',Pwofftime='".$totime."' where Roomid='".$roomid."'";

	$upexe = $this->db->query($update);
   
	if($upexe){
	 echo 'success';
	} else{
	  echo 'Fail';
	}

}


}




public function maintainancesave(){
	date_default_timezone_set('Asia/Kolkata');

	 $roomno = $_REQUEST['roomNo'];
	$inDate = $_REQUEST['inDate'];
	$outDate = $_REQUEST['outDate'];
	$intime = $_REQUEST['intime'];
	$totime = $_REQUEST['totime'];
	$Remarks = $_REQUEST['Remarks'];
	$roomid = $_REQUEST['roomid'];
	$frintdate = date('Y-m-d',strtotime($inDate));
	$froutdate = date('Y-m-d',strtotime($outDate));



	$setqry = "select enablepower from extraoption";

				$set = $this->db->query($setqry)->row_array();
		
				if($set['enablepower'] == 1) {
				

				$select ="select RoomNo from mas_room where Room_Id = '".$roomid."'";

				$roomnumber = $this->db->query($select)->row_array();
			  
			  
				$otherDB = $this->load->database('another_db', TRUE);
			  
			  
				 $selroom = "
				SELECT mc.ControlType_Id as control, md.Device
				FROM mas_control mc
				INNER JOIN mas_Room mr ON mr.Room_Id = mc.Room_Id
				INNER JOIN  mas_device md ON mc.Device = md.Device
				WHERE mr.RoomNo = '".$roomnumber['RoomNo']."'";

				
				
				$result = $otherDB->query($selroom)->result_array();
				foreach($result as $res) {

					$control = $res['control'];
					$Device  = $res['Device'];
				
					$process = "SELECT Status_Id FROM mas_status WHERE UPPER(status) = 'Maintenance'";
					$process_id = $otherDB->query($process)->row_array();
				
					$today = date('Y-m-d');
					$nowtime = date('H:i:s');
				
					$ins4 = "
						INSERT INTO trans_power 
						(roomno, Process, control, devicenumber, Roomgrcid, Remarks, powerondate, powerontime, customer, usersname, onoff)
						VALUES (
							'".$roomnumber['RoomNo']."',
							'".$process_id['Status_Id']."',
							'".$control."',
							'".$Device."',
							'',
							'maintainance',
							'".$today."',
							'".$nowtime."',
							'',
							'',
							'0'
						)
					";
				
					$instrns = $this->db->query($ins4);
				}
			
		}
				


if($instrns){

	$update = "update room_status set Pwmaintenance ='1' ,Pwondate ='".$frintdate."',Pwoffdate='".$froutdate."',Pwontime='".$intime."',Pwofftime='".$totime."' where Roomid='".$roomid."'";

	$upexe = $this->db->query($update);
   
	if($upexe){
	 echo 'success';
	} else{
	  echo 'Fail';
	}

}


}

// maintainancesave

public function getroomtypeextraamount() {
  
    $roomtypeid = $this->input->post('roomid', TRUE);
    
 
    if (empty($roomtypeid)) {
        echo json_encode(['error' => 'Room ID is required']);
        return;
    }
    
   
    $sql = "SELECT mtype.Extrabedamount, mtype.Extrabedcount,mtype.Adults  
            FROM room_status rs 
            INNER JOIN mas_room mr ON mr.Room_id = rs.Roomid
            INNER JOIN mas_roomtype mtype ON mtype.RoomType_Id = mr.RoomType_Id
            WHERE rs.Roomid = ?";
    
    $query = $this->db->query($sql, [$roomtypeid]);
    
    if ($query->num_rows() > 0) {
        $res = $query->row_array(); 
		$totalcount = $res['Adults'] + $res['Extrabedcount'];
        
        $row_set = [
            [
                'amount' => $res['Extrabedamount'],
                'adults' => $res['Adults'],
                'totalcount' => $totalcount,
                'Extrabedcount' => $res['Extrabedcount'] 
            ]
        ];
        
        echo json_encode($row_set);
    } else {
     
        echo json_encode(['error' => 'No data found']);
    }
}


}
