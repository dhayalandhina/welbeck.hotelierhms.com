<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Card</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: Arial, sans-serif;
    font-size: 11px;
    background: #fff;
  }
  .card {
    background: #fff;
    width: 710px;
    margin: 16px auto;
    padding: 16px 18px;
    border: 1px solid #777;
  }
  .header {
    text-align: center;
    margin-bottom: 8px;
    line-height: 1.6;
    font-size: 11px;
  }
  .header .reg-title {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 1.5px;
    margin-top: 3px;
  }
  .reg-table { width: 100%; border-collapse: collapse; }
  .reg-table td {
    border: 1px solid #444;
    padding: 3px 6px;
    vertical-align: middle;
    font-size: 11px;
    height: 20px;
  }
  .c1 { width: 118px; }
  .c2 { width: 162px; }
  .c3 { width: 148px; }
  .c4 { }
  .lbl  { font-weight: 600; white-space: nowrap; }
  .val  { background: #fff; }
  .empty { background: #fff; }
  .sec-hdr {
    font-weight: bold;
    text-align: center;
    background: #f0f0f0;
    font-size: 10.5px;
    height: 18px;
  }
  .arr-dep-box {
    border: 1px solid #444;
    border-top: none;
    padding: 5px 10px 5px 8px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    min-height: 46px;
  }
  .arr-dep-left {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding-top: 2px;
  }
  .arr-dep-left span { font-weight: 600; font-size: 11px; }
  .arr-dep-right {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 200px;
    padding-top: 2px;
  }
  .reg-line {
    font-weight: 600;
    font-size: 11px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .reg-line input[type="checkbox"] { width: 13px; height: 13px; }
  .terms {
    border: 1px solid #444;
    border-top: none;
    padding: 5px 8px;
    font-size: 10.5px;
    line-height: 1.65;
  }
  .terms strong { display: block; margin-bottom: 2px; font-size: 11px; }
  .sig-table { width: 100%; border-collapse: collapse; }
  .sig-table td {
    border: 1px solid #444;
    border-top: none;
    text-align: center;
    font-weight: bold;
    font-size: 11.5px;
    padding: 5px 4px 38px 4px;
    vertical-align: top;
  }
  @media print {
    body { background: #fff; }
    .card { border: none; margin: 0; width: 100%; }
  }
</style>
</head>
<body>
<div class="card">

  <div class="header">
    <strong><?php echo isset($hotel_name) ? $hotel_name : 'Welbeck'; ?></strong><br>
    <?php echo isset($hotel_sub) ? $hotel_sub : 'Unit of The Beehives'; ?><br>
    GSTIN: <?php echo isset($gstin) ? $gstin : '33AALFT4448E1Z5'; ?>
    <div class="reg-title">REGISTRATION CARD</div>
  </div>

  <table class="reg-table">
    <tr>
      <td class="c1 lbl">Grcno</td>
      <td class="c2 val"><?php echo isset($grcno) ? $grcno : ''; ?></td>
      <td class="c3 lbl">SOURCE</td>
      <td class="c4 val"><?php echo isset($source) ? $source : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Guest Name</td>
      <td class="c2 val"><?php echo isset($guest_name) ? $guest_name : ''; ?></td>
      <td colspan="2" class="sec-hdr">Passport Details</td>
    </tr>
    <tr>
      <td class="c1 lbl">Company Name</td>
      <td class="c2 val"><?php echo isset($company_name) ? $company_name : ''; ?></td>
      <td class="c3 lbl">Number</td>
      <td class="c4 val"><?php echo isset($passport_no) ? $passport_no : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Address</td>
      <td class="c2 val"><?php echo isset($address1) ? $address1 : ''; ?></td>
      <td class="c3 lbl">Date of Issue</td>
      <td class="c4 val"><?php echo isset($passport_doi) ? $passport_doi : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 empty"><?php echo isset($address2) ? $address2 : ''; ?></td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Validity Till</td>
      <td class="c4 val"><?php echo isset($passport_valid) ? $passport_valid : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 empty"></td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Place of Issue</td>
      <td class="c4 val"><?php echo isset($passport_poi) ? $passport_poi : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 empty"></td>
      <td class="c2 val"></td>
      <td colspan="2" class="sec-hdr">Visa Details</td>
    </tr>
    <tr>
      <td class="c1 lbl">Mobile</td>
      <td class="c2 val"><?php echo isset($mobile) ? $mobile : ''; ?></td>
      <td class="c3 lbl">Number</td>
      <td class="c4 val"><?php echo isset($visa_no) ? $visa_no : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Email</td>
      <td class="c2 val"><?php echo isset($email) ? $email : ''; ?></td>
      <td class="c3 lbl">Date of Issue</td>
      <td class="c4 val"><?php echo isset($visa_doi) ? $visa_doi : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Room No &amp; Type</td>
      <td class="c2 val"><?php echo isset($room_no) ? $room_no : ''; ?></td>
      <td class="c3 lbl">Validity Till</td>
      <td class="c4 val"><?php echo isset($visa_valid) ? $visa_valid : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Rate Type &amp; Tariff</td>
      <td class="c2 val"><?php echo isset($rate_type) ? $rate_type : ''; ?></td>
      <td class="c3 lbl">Place of Issue</td>
      <td class="c4 val"><?php echo isset($visa_poi) ? $visa_poi : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Arrival Date</td>
      <td class="c2 val"><?php echo isset($arrival_date) ? $arrival_date : ''; ?></td>
      <td class="c3 lbl">Date of arrival in ind</td>
      <td class="c4 val"><?php echo isset($date_arrival_ind) ? $date_arrival_ind : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Departure Date</td>
      <td class="c2 val"><?php echo isset($departure_date) ? $departure_date : ''; ?></td>
      <td class="c3 lbl">Duration of stay in Ind</td>
      <td class="c4 val"><?php echo isset($duration_stay) ? $duration_stay : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">No of Pax</td>
      <td class="c2 val"><?php echo isset($no_pax) ? $no_pax : ''; ?></td>
      <td class="c3 lbl">Purpose of visit</td>
      <td class="c4 val"><?php echo isset($purpose_visit) ? $purpose_visit : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Plan</td>
      <td class="c2 val"><?php echo isset($plan) ? $plan : ''; ?></td>
      <td class="c3 lbl">Date Of Birth Date</td>
      <td class="c4 val"><?php echo isset($dob) ? $dob : ''; ?></td>
    </tr>
    <tr>
      <td class="c1 lbl">Advance</td>
      <td class="c2 val"><?php echo isset($advance) ? $advance : ''; ?></td>
      <td class="c3 lbl">Anniversary Date :</td>
      <td class="c4 val"><?php echo isset($anniversary) ? $anniversary : ''; ?></td>
    </tr>
  </table>

  <div class="arr-dep-box">
    <div class="arr-dep-left">
      <span>Arrival From : <?php echo isset($arrival_from) ? $arrival_from : ''; ?></span>
      <span>Departure From : <?php echo isset($departure_from) ? $departure_from : ''; ?></span>
    </div>
    <div class="arr-dep-right">
      <div class="reg-line">
        Reg Card Update :&nbsp;
        <input type="checkbox" <?php echo (isset($reg_card_update) && $reg_card_update == 1) ? 'checked' : ''; ?>>
      </div>
    </div>
  </div>

  <div class="terms">
    <strong>Terms and Conditions</strong>
    1. Key handover @ reception to completed the checkout procedure.<br>
    2. Missing of keys will effect charges as per the management policy.<br>
    3. Guest are reminded that the hotel official departure time is 24 hours. Late departure can be arranged on request through the management, subject to room availability.
  </div>

  <table class="sig-table">
    <tr>
      <td style="width:18%;">FO</td>
      <td style="width:25%;">Tax Manager</td>
      <td style="width:22%;">PM</td>
      <td style="width:35%;">GUEST SIGNATURE</td>
    </tr>
  </table>

</div>
</body>
</html>
