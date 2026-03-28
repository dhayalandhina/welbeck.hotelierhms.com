<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Print', 'Registration Card');
$this->pfrm->FrmHead4('Print / Registration Card', $F_Class . "/" . $F_Ctrl, $F_Class . "/" . $F_Ctrl . "_View");

$Res = $this->Myclass->Hotel_Details();
foreach ($Res as $row) {
    $Company = $row['Company'];
    $Address = $row['Address'];
    $City = $row['City'];
    $Pin = $row['PinCode'];
    $State = $row['State'];
    $Phone = $row['Phone'];
    $logo = $row['logo'];
}
$cityqry = $this->db->query("select City from mas_city where Cityid='".$City."'")->row_array();
?>

<style>
/* Normal screen display */
.reg-form{
    width:100%;
    border-collapse:collapse;
    font-family:Arial, sans-serif;
    font-size:12px;
    border:2px solid #000;
}
.reg-form td{
    border:1px solid #000;
    padding:6px;
    vertical-align:top;
    width:25%; /* Equal width for all columns */
}
.bold{font-weight:bold;}
.center{text-align:center}
.no-border, .no-border td{
    border:none!important;
}
.check{
    width:14px;
    height:14px;
    border:1px solid #000;
    display:inline-block;
}
.signature{height:60px}

/* Fix for empty cells */
.reg-form td:empty {
    min-height: 25px;
}

/* Print specific styles */
@media print {
    /* Force everything to print as shown */
    body * {
        visibility: hidden;
    }
    
    #printing, #printing * {
        visibility: visible !important;
    }
    
    #printing {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
    }
    
    /* Force borders to print */
    .reg-form, .reg-form td {
        border: 1px solid #000 !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
    /* Remove borders for specific rows in print too */
    .no-border, .no-border td {
        border: none !important;
    }
    
    /* Ensure table takes full width */
    .reg-form {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Remove page margins */
    @page {
        margin: 0;
    }
    
    body {
        margin: 0;
        padding: 0;
    }
}

/* Container for printing */
#printing {
    width: 100%;
    padding: 20px;
    background: white;
}

/* Toggle Switch Styles */
.toggle-container {
    margin: 20px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background-color: #2196F3;
}

input:checked + .toggle-slider:before {
    transform: translateX(30px);
}

.toggle-label {
    font-weight: bold;
    font-size: 14px;
}

.toggle-fill { color: #2196F3; }
.toggle-empty { color: #666; }

/* Empty cell styling */
.empty-cell {
    min-height: 20px;
    display: block;
}
</style>

<div class="col-sm-12">
<div class="the-box F_ram">
<fieldset>

<!-- Toggle Switch -->
<div class="toggle-container">
    <!-- <span class="toggle-label toggle-fill">Filled Card</span> -->
    <label class="toggle-switch">
        <input type="checkbox" id="cardToggle" onchange="toggleCard()">
        <span class="toggle-slider"></span>
    </label>
    <span class="toggle-label toggle-empty">Blank Reg Card</span>
</div>

<div id="printing">

<?php
$room_ids = explode(",", $_REQUEST['roomgrcid']);
$roomTypes = $roomNos = [];
$totrmrent = $allpax = 0;

// Store all data in PHP variables
$guest_data = array();
foreach ($room_ids as $room_id){
    $sql = "exec registration__card '".$room_id."'";
    $result = $this->db->query($sql);
    foreach ($result->result() as $row){
        $guest_data['guestname'] = $row->Guestname;
        $guest_data['grcno'] = $row->grcno;
        $guest_data['companycus'] = $row->company;
        $guest_data['addresscus'] = $row->HomeAddress1;
        $guest_data['citycus'] = $row->City;
        $guest_data['statecus'] = $row->State;
        $guest_data['mobilecus'] = $row->Mobile;
        $guest_data['emailcus'] = $row->Email_ID;
        $roomNos[] = $row->Roomno;
        $roomTypes[] = $row->Roomtype;
        $guest_data['arrival'] = $row->arrival;
        $guest_data['dep'] = $row->depature;
        $guest_data['pax'] = $row->Noofpersons;
        $guest_data['advance'] = $row->advance;
        $guest_data['proofno'] = $row->idproofno;
        $guest_data['prooftype'] = $row->idname;
        $guest_data['roomrent'] = $row->roomrent;
        $totrmrent += $guest_data['roomrent'];
        $allpax += $guest_data['pax'];
    }
}

// Store combined data
$guest_data['roomNos'] = implode(',', $roomNos);
$guest_data['roomTypes'] = implode(',', $roomTypes);
$guest_data['totrmrent'] = $totrmrent;
$guest_data['allpax'] = $allpax;
?>

<!-- Filled Card Table -->
<table id="filledCard" class="reg-form" cellspacing="0" cellpadding="0">

<tr>
<td colspan="4" class="center bold">
<?php echo $Company  ?><br>
<?php echo $Address ?><br>
GSTIN: 33AALFT4448E1Z5
</td>
</tr>

<tr>
<td colspan="4" class="center bold">REGISTRATION CARD</td>
</tr>

<tr>
<td class="bold">Grcno</td>
<td><?=$guest_data['grcno']?></td>
<td class="bold">SOURCE</td>
<td></td>
</tr>

<tr>
<td class="bold">Guest Name</td>
<td><?=$guest_data['guestname']?></td>
<td colspan="2" class="bold center">Passport Details</td>
</tr>

<tr>
<td class="bold">Company Name</td>
<td><?=$guest_data['companycus']?></td>
<td class="bold">Number</td>
<td><?=$guest_data['proofno']?></td>
</tr>

<tr>
<td class="bold">Address</td>
<td><?=$guest_data['addresscus']?></td>
<td class="bold">Date of Issue</td>
<td></td>
</tr>

<tr>
<td></td>
<td></td>
<td class="bold">Validity Till</td>
<td></td>
</tr>

<tr>
<td></td>
<td></td>
<td class="bold">Place of Issue</td>
<td></td>
</tr>

<tr>
<td class="bold">Mobile</td>
<td><?=$guest_data['mobilecus']?></td>
<td colspan="2" class="bold center">Visa Details</td>
</tr>

<tr>
<td class="bold">Email</td>
<td><?=$guest_data['emailcus']?></td>
<td class="bold">Number</td>
<td></td>
</tr>

<tr>
<td class="bold">Room No & Type</td>
<td><?=$guest_data['roomNos']?> / <?=$guest_data['roomTypes']?></td>
<td class="bold">Date of Issue</td>
<td></td>
</tr>

<tr>
<td class="bold">Rate Type & Tariff</td>
<td><?=number_format($guest_data['totrmrent'],2)?></td>
<td class="bold">Validity Till</td>
<td></td>
</tr>

<tr>
<td class="bold">Arrival Date</td>
<td><?=$guest_data['arrival']?></td>
<td class="bold">Place of Issue</td>
<td></td>
</tr>

<tr>
<td class="bold">Departure Date</td>
<td><?=$guest_data['dep']?></td>
<td class="bold">Date of arrival in ind</td>
<td></td>
</tr>

<tr>
<td class="bold">No of Pax</td>
<td><?=$guest_data['allpax']?></td>
<td class="bold">Duration of stay in Ind</td>
<td></td>
</tr>

<tr>
<td class="bold">Plan</td>
<td></td>
<td class="bold">Purpose of visit</td>
<td></td>
</tr>

<tr>
<td class="bold">Advance</td>
<td><?=number_format($guest_data['advance'],2)?></td>
<td class="bold">Date Of Birth Date</td>
<td></td>
</tr>

<tr>
<td colspan="2"></td>
<td class="bold">Anniversary Date :</td>
<td></td>
</tr>

<!-- No border rows -->
<tr class="no-border">
<td class="bold">Arrival From :</td>
<td></td>
<td class="bold">Reg Card Update :</td>
<td><span class="check"></span></td>
</tr>

<tr class="no-border">
<td class="bold">Departure From :</td>
<td></td>
<td colspan="2"></td>
</tr>
<!-- REMOVED: Viruthinar App row -->
<!-- REMOVED: Tata Sky Status row -->

<tr>
<td colspan="4">
<b>Terms and Conditions</b><br><br>
1. Key handover @ reception to completed the checkout procedure.<br>
2. Missing of keys will effect charges as per the management policy.<br>
3. Guest are reminded that the hotel official departure time is 24 hours.
Late departure can be arranged on request through the management, subject to room availability.
</td>
</tr>

<tr>
<td class="signature center bold">FO</td>
<td class="signature center bold">Tax Manager</td>
<td class="signature center bold">PM</td>
<td class="signature center bold">GUEST SIGNATURE</td>
</tr>

</table>

<!-- Empty Card Table (Initially Hidden) -->
<table id="emptyCard" class="reg-form" cellspacing="0" cellpadding="0" style="display:none;">

<tr>
<td colspan="4" class="center bold">
<?php echo $Company  ?><br>
<?php echo $Address ?><br>
GSTIN: 33AALFT4448E1Z5
</td>
</tr>

<tr>
<td colspan="4" class="center bold">REGISTRATION CARD</td>
</tr>

<tr>
<td class="bold">Grcno</td>
<td>&nbsp;</td>
<td class="bold">SOURCE</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Guest Name</td>
<td>&nbsp;</td>
<td colspan="2" class="bold center">Passport Details</td>
</tr>

<tr>
<td class="bold">Company Name</td>
<td>&nbsp;</td>
<td class="bold">Number</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Address</td>
<td>&nbsp;</td>
<td class="bold">Date of Issue</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td class="bold">Validity Till</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td class="bold">Place of Issue</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Mobile</td>
<td>&nbsp;</td>
<td colspan="2" class="bold center">Visa Details</td>
</tr>

<tr>
<td class="bold">Email</td>
<td>&nbsp;</td>
<td class="bold">Number</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Room No & Type</td>
<td>&nbsp;</td>
<td class="bold">Date of Issue</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Rate Type & Tariff</td>
<td>&nbsp;</td>
<td class="bold">Validity Till</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Arrival Date</td>
<td>&nbsp;</td>
<td class="bold">Place of Issue</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Departure Date</td>
<td>&nbsp;</td>
<td class="bold">Date of arrival in ind</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">No of Pax</td>
<td>&nbsp;</td>
<td class="bold">Duration of stay in Ind</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Plan</td>
<td>&nbsp;</td>
<td class="bold">Purpose of visit</td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="bold">Advance</td>
<td>&nbsp;</td>
<td class="bold">Date Of Birth Date</td>
<td>&nbsp;</td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
<td class="bold">Anniversary Date :</td>
<td>&nbsp;</td>
</tr>

<!-- No border rows -->
<tr class="no-border">
<td class="bold">Arrival From :</td>
<td>&nbsp;</td>
<td class="bold">Reg Card Update :</td>
<td><span class="check"></span></td>
</tr>

<tr class="no-border">
<td class="bold">Departure From :</td>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
</tr>
<!-- REMOVED: Viruthinar App row -->
<!-- REMOVED: Tata Sky Status row -->

<tr>
<td colspan="4">
<b>Terms and Conditions</b><br><br>
1. Key handover @ reception to completed the checkout procedure.<br>
2. Missing of keys will effect charges as per the management policy.<br>
3. Guest are reminded that the hotel official departure time is 24 hours.
Late departure can be arranged on request through the management, subject to room availability.
</td>
</tr>

<tr>
<td class="signature center bold">FO</td>
<td class="signature center bold">Tax Manager</td>
<td class="signature center bold">PM</td>
<td class="signature center bold">GUEST SIGNATURE</td>
</tr>

</table>

</div>

<!-- <div style="margin-top:20px; text-align:center;">
    <button class="btn btn-primary" onclick="printExact()">Print Registration Card</button>
</div> -->

</fieldset>
</div>
</div>

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<SCRIPT language="javascript">
function printExact() {
   
    var isFilledCard = document.getElementById('filledCard').style.display !== 'none';
    var cardToPrint = isFilledCard ? document.getElementById('filledCard') : document.getElementById('emptyCard');
    
    
    var printContent = cardToPrint.cloneNode(true);
    
  
    var printWindow = window.open('', '_blank');
    
 
    printWindow.document.write(`
        <html>
        <head>
            <title>Registration Card</title>
            <style>
                /* Reset and full page setup */
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    width: 100%;
                    height: 100vh;
                    font-family: Arial, sans-serif;
                    background: white;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 20px;
                }
                
                /* Container to center and expand table */
                .print-container {
                    width: 100%;
                    max-width: 100%;
                    height: auto;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                
                /* Make table expand to fill available space */
                table.reg-form {
                    width: 100% !important;
                    height: auto;
                    max-height: 100%;
                    border: 2px solid #000 !important;
                    border-collapse: collapse !important;
                    table-layout: fixed !important;
                }
                
                /* Ensure table takes full width of container */
                table.reg-form {
                    width: 100% !important;
                    max-width: 100% !important;
                }
                
                /* Make cells fill available space evenly */
                table.reg-form td {
                    border: 1px solid #000 !important;
                    padding: 8px 6px !important;
                    vertical-align: top !important;
                    width: 25% !important;
                    font-size: 14px !important;
                    line-height: 1.3 !important;
                }
                
                /* Make header cells slightly larger */
                table.reg-form tr:first-child td {
                    padding: 12px 6px !important;
                }
                
                /* Remove borders for specific rows */
                tr.no-border td {
                    border: none !important;
                }
                
                /* Scale checkboxes */
                .check {
                    width: 16px !important;
                    height: 16px !important;
                    border: 1px solid #000 !important;
                    display: inline-block !important;
                }
                
                /* Scale signature cells */
                .signature { 
                    height: 80px !important;
                    padding-top: 20px !important;
                }
                
                /* Ensure empty cells have height */
                td:empty {
                    min-height: 30px;
                }
                
                /* Make terms and conditions text more readable */
                table.reg-form tr:nth-last-child(2) td {
                    padding: 10px 6px !important;
                    font-size: 12px !important;
                    line-height: 1.4 !important;
                }
                
                /* Print-specific adjustments */
                @media print {
                    body {
                        width: 100% !important;
                        height: 100% !important;
                        margin: 0 !important;
                        padding: 10px !important;
                        display: flex !important;
                        justify-content: center !important;
                        align-items: center !important;
                    }
                    
                    .print-container {
                        width: 100% !important;
                        height: 100% !important;
                    }
                    
                    table.reg-form {
                        width: 100% !important;
                        height: auto !important;
                        max-height: 100% !important;
                        border: 2px solid #000 !important;
                    }
                    
                    /* Force 4 equal columns */
                    table.reg-form td {
                        width: 25% !important;
                        min-width: 25% !important;
                        max-width: 25% !important;
                    }
                    
                    /* Remove page margins */
                    @page {
                        margin: 5mm !important;
                        size: auto !important;
                    }
                }
                
                .bold { 
                    font-weight: bold !important;
                    font-size: 14px !important;
                }
                .center { 
                    text-align: center !important; 
                }
            </style>
        </head>
        <body>
            <div class="print-container">
    `);
    
    // Add the content
    printWindow.document.write(printContent.outerHTML);
    printWindow.document.write('</div></body></html>');
    printWindow.document.close();
    
    // Wait a moment then print
    setTimeout(function() {
        printWindow.focus();
        
        // Add another timeout to ensure everything is rendered
        setTimeout(function() {
            printWindow.print();
            
            // Close after printing or after 5 seconds
            setTimeout(function() {
                printWindow.close();
            }, 500);
        }, 300);
    }, 500);
}

function toggleCard() {
    var toggle = document.getElementById('cardToggle');
    var filledCard = document.getElementById('filledCard');
    var emptyCard = document.getElementById('emptyCard');
    
    if (toggle.checked) {
        
        filledCard.style.display = 'none';
        emptyCard.style.display = 'table';
    } else {
        
        filledCard.style.display = 'table';
        emptyCard.style.display = 'none';
    }
}


function printDiv(a) {
    printExact();
}
</SCRIPT>
