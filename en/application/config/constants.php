<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * General constants used in code
 */
define('prime_multiplier', 379);
define('admin_from_email', 'admin@publishat.com');
define('noreply', 'no-reply@publishat.com');
define('page_redirect_intervel', 3); //3 seconds
define('max_photo_file_size', 150 * 1024); //150 KB
define('max_photo_file_size_text', '150 KB');
define('max_document_file_size', 5 * 1024 * 1024); //2 MB
define('max_document_file_size_text', '5 MB');
define('admin_page_size', 25);
define('protocol', 'smtp');
define('smtp_host', 'ssl://smtp.zoho.com');
//define ('smtp_host','relay-hosting.secureserver.net');
define('encryption', 'ssl');
//define ('encryption','tls');
define('smtp_port', 465);
//define ('smtp_port',25);
// define ('smtp_user','ipublishats@gmail.com');
define('smtp_user', 'admin@publishat.com');
//define ('smtp_pass','Publish@20');
define('smtp_pass', 'Vijaya@123');
define('mailpath', '');
define('charset', 'iso-8859-1');
define('wordwrap', true);

/*used for mailing*/
/*<tr>
  <td align="left" valign="bottom" height="32" colspan="2"  style="padding:6px;font-size:13px; font-weight:normal" ></td>  
 </tr>*/
define(
    'header_top',
    '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 0px solid #E0E9ED; border-collapse:collapse;">
  <tr>
    <td height="75" align="left" valign="middle" bgcolor="#004E83" style="padding-left:5px;"><div style="float:left;"><a href="http://www.publishat.com"><img src="http://www.publishat.com/templates/logo.png" alt="Publishat.com" width="252" height="61" border="0" title="Publistat.com"/></a></div>
    <div style="float:right; padding-top:25px; padding-right:10px; color:#FFFFFF;"><a href="https://www.publishat.com/login.php" style="padding-top:25px; padding-right:10px; color:#FFFFFF; text-decoration:none; font-weight:bold; font-size:13px; font-family:Arial;">Manage Account</a></div></td>
  </tr>
    <tr>
    <td align="left" valign="top" colspan="2"  style="padding:6px;">##ADD-TEXT##</td> 
  </tr>
   <tr>
    <td align="left" valign="top" colspan="2"  style="padding:6px;"><u><b>Attachments</b></u></td> 
  </tr>
</table>
<div style="height:5px; width:600px;"></div>',
);
define(
    'header_top_user_details',
    '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 0px solid #E0E9ED; border-collapse:collapse;">
  <tr>
    <td height="75" align="left" valign="middle" bgcolor="#004E83" style="padding-left:5px;"><div style="float:left;"><a href="http://www.publishat.com"><img src="http://www.publishat.com/templates/logo.png" alt="Publishat.com" width="252" height="61" border="0" title="Publistat.com"/></a></div>
    <div style="float:right; padding-top:25px; padding-right:10px; color:#FFFFFF;"><a href="https://www.publishat.com/login.php" style="padding-top:25px; padding-right:10px; color:#FFFFFF; text-decoration:none; font-weight:bold; font-size:13px; font-family:Arial;">Manage Account</a></div></td>
  </tr>
    
</table><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 0px solid #E0E9ED; border-collapse:collapse;">
  
    <tr>
    <td align="left" valign="top" colspan="2"  style="padding:6px;">##ADD-TEXT##</td> 
  </tr>
  <tr>
	<td align="left" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:13px; font-weight:bold; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">User Type</td>
    <td width="75%" align="left" valign="top" style="padding:6px;padding-left:5px;font-family:Arial; color:#000000; font-size:13px; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">: ##USERTYPE##</td>
  </tr>
  <tr>
	<td align="left" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:13px; font-weight:bold; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">Group</td>
    <td width="75%" align="left" valign="top" style="padding:6px;padding-left:5px;font-family:Arial; color:#000000; font-size:13px; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">: ##GROUP##</td>
  </tr>
  <tr>
	<td align="left" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:13px; font-weight:bold; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">Category</td>
    <td width="75%" align="left" valign="top" style="padding:6px;padding-left:5px;font-family:Arial; color:#000000; font-size:13px; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">: ##CATEGORY##</td>
  </tr>
  <tr>
	<td align="left" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:13px; font-weight:bold; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">Sub Category</td>
    <td width="75%" align="left" valign="top" style="padding:6px;padding-left:5px;font-family:Arial; color:#000000; font-size:13px; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">: ##SUBCATEGORY##</td>
  </tr>
  <tr>
	<td align="left" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:13px; font-weight:bold; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">Issue Status</td>
    <td width="75%" align="left" valign="top" style="padding:6px;padding-left:5px;font-family:Arial; color:#000000; font-size:13px; border-bottom: 1px solid #E0E9ED; border-collapse:collapse;">: ##ISSUESSTATUS##</td>
  </tr>
   <tr>
    <td align="left" valign="top" colspan="2"  style="padding:6px;"><u><b>Attachments</b></u></td> 
  </tr>
</table>
<div style="height:5px; width:600px;"></div>',
);

define(
    'header_top_record_mail',
    '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 0px solid #E0E9ED; border-collapse:collapse;">
  <tr>
    <td height="75" align="left" valign="middle" bgcolor="#004E83" style="padding-left:5px;"><div style="float:left;"><a href="http://www.publishat.com"><img src="http://www.publishat.com/templates/logo.png" alt="Publishat.com" width="252" height="61" border="0" title="Publistat.com"/></a></div>
    <div style="float:right; padding-top:25px; padding-right:10px; color:#FFFFFF;"><a href="https://www.publishat.com/login.php" style="padding-top:25px; padding-right:10px; color:#FFFFFF; text-decoration:none; font-weight:bold; font-size:13px; font-family:Arial;">Manage Account</a></div></td>
  </tr>
    
</table>
<div style="height:5px; width:600px;"></div>',
);

define(
    'header_bottom',
    '<div style="height:15px; width:600px;"></div>
<tr>
   <td align="left" valign="top" style="padding:6px; font-size:13px; font-weight:normal; line-height:16px;">Thanks & Regards<br>
##HEADER-NAME##,<br>
##HEADER-EMAIL##.

</td>
  </tr>
  <tr>
  <td align="left" valign="top" colspan="2"  style="padding:6px;"><b>My Digital Data is simple , safe and yet powerful with <a href="http://www.publishat.com">Publishat.com</a></b></td> 
</tr>
<tr>
  <td align="left" valign="top" style="padding:6px; font-size:13px; font-weight:normal; line-height:16px;">I recommend you to use <a href="http://www.publishat.com">Publishat.com</a> to safeguard your data.</td> 
</tr>
<div style="height:15px; width:600px;"></div>
<table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="#E0E9ED">
  
  <tr>
    <td align="center" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:11px; font-weight:normal; line-height:16px;">&copy; 2015. Publishat.com. All Rights Reserved. </td>
  </tr>
</table>
<div style="height:15px; width:600px;"></div>
<table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="#E0E9ED">
  <tr>
    <td align="left" valign="top" style="padding:6px; font-family:Arial; color:#000000; font-size:11px; font-weight:normal; line-height:16px;">This message sent by ##HEADER-EMAIL## from Publishat.com &nbsp;|&nbsp; <a href="https://www.publishat.com/login.php">Manage Account</a><br />
      Add admin@publishat.com to your safe sender list to ensure our emails make it to your inbox.</td>
  </tr>
</table>
<div style="height:15px; width:600px;"></div>
',
);

/**
 * Database TableNames
 * @var unknown
 */
define('TBL_USER', 'User');
define('TBL_SETTINGS', 'Settings');
define('TBL_SCHOOL', 'School');
define('TBL_CERTIFICATION', 'Certification');
define('TBL_DOCUMENTS', 'Documents');
define('TBL_EXAM', 'Exam');
define('TBL_PHD', 'Phd');
define('TBL_POSTGRADUATE', 'Postgraduate');
define('TBL_PROJECT', 'Project');
define('TBL_UNDERGRADUATE', 'Undergraduate');
define('TBL_SECURITYSETTINGS', 'SecuritySettings');
define('TBL_ACCOUNTSETTINGS', 'AccountSettings');
define('TBL_RECORDTYPE', 'RecordType');
define('TBL_EVENTS', 'events');
define('TBL_PERSONALEVENTS', 'Wishes');
define('TBL_KARTNAME', 'kartname');
define('TBL_KART', 'kart');
define('TBL_SUGGESTEMAILS', 'SuggestEmails');
define('TBL_DYNAMIC', 'dynamicfeilds');
define('TBL_DROPDOWNFIELDS', 'dropdownfeilds');
define('TBL_LOCATIONHISTORY', 'LocationHistory');
define('TBL_GOVERNMENTCERTIFICATES', 'GovernmentCertificates');
define('TBL_RELATIONSHIP', 'Relationship');
define('TBL_WEBHISTORY', 'WebHistory');
define('TBL_TRAVEL', 'Travel');
define('TBL_DEVICES', 'Devices');
define('TBL_CONTACTS', 'Contacts');
define('TBL_EMPLOYMENT', 'Employment');
define('TBL_PROJECTS', 'Projects');
define('TBL_SKILLS', 'Skills');
define('TBL_APPS', 'Apps');
define('TBL_MEDMEDICALTEST', 'MedMedicalTest');
define('TBL_MEDPRESCRIPTION', 'MedPrescription');
define('TBL_MEDFAMILY', 'MedFamily');
define('TBL_MEDHEALTHINSURANCE', 'MedHealthInsurance');
define('TBL_MEDMEDICALTESTRECORDS', 'MedMedicalTestRecords');
define('TBL_MEDPRESCRIPTIONMEDICINE', 'MedPrescriptionMedicine');
define('TBL_MEDPRESCRIPTIONPRESCRIPTION', 'MedPrescriptionPrescription');
define('TBL_MEDFAMILYMEMBER', 'MedFamilyMember');
define('TBL_MEDHEALTHINSURANCEBENEFICIARY', 'MedHealthInsuranceBeneficiary');
define('TBL_LEGALDISPUTE', 'LegalDispute');
define('TBL_LEGALOWNERSHIPTRANSFER', 'LegalOwnershipTransfer');
define('TBL_FINFINANCIALACCOUNTS', 'FinFinancialAccounts');
define('TBL_FINASSET', 'FinAsset');
define('TBL_FINREVENUE', 'FinRevenue');
define('TBL_FINCARDS', 'FinCards');
define('TBL_FINLIABILITY', 'FinLiability');
define('TBL_FINPAYMENT', 'FinPayment');
define('TBL_FINTAX', 'FinTax');
define('TBL_FININSURANCE', 'FinInsurance');
define('TBL_RESUME', 'Resume');
define('TBL_USERLOGINHISTORY', 'UserLoginHistory');
define('TBL_GROUPNAMES', 'groupname');
define('TBL_REVENUE', 'revenue');
define('TBL_PAYMENTS', 'payments');
define('TBL_VENDORS', 'vendors');
define('TBL_USER_VENDOR', 'user_vendor');
define('TBL_CLIENTCONTACTS', 'ClientContacts');

define('USERID', '373');

/*constants for vendor names*/

define('VendorName', 'BloodDonation');
define('TimeStamp', date('Y-m-d H:i:s'));

define(
    'School',
    json_encode([
        'query' => 'School',
        'headers' => ['key1' => 'Class', 'key2' => 'SchoolName', 'key3' => 'DocumentType'],
    ]),
);

define(
    'Undergraduate',
    json_encode([
        'query' => 'Undergraduate',
        'headers' => ['key1' => 'Degree', 'key2' => 'Term', 'key3' => 'DocumentType'],
    ]),
);

define(
    'Postgraduate',
    json_encode([
        'query' => 'Postgraduate',
        'headers' => ['key1' => 'Degree', 'key2' => 'Term', 'key3' => 'DocumentType'],
    ]),
);

define(
    'Phd',
    json_encode([
        'query' => 'Phd',
        'headers' => ['key1' => 'Degree', 'key2' => 'AcademicYear', 'key3' => 'DocumentType'],
    ]),
);

define(
    'Exam',
    json_encode([
        'query' => 'Exam',
        'headers' => ['key1' => 'ExamType', 'key2' => 'ExamName', 'key3' => 'DocumentType'],
    ]),
);

define(
    'Certification',
    json_encode([
        'query' => 'Certification',
        'headers' => ['key1' => 'CertificationType', 'key2' => 'CertificateName', 'key3' => 'ValidFrom'],
    ]),
);

define(
    'Project',
    json_encode([
        'query' => 'Project',
        'headers' => ['key1' => 'ProjectType', 'key2' => 'Title', 'key3' => 'DocumentType'],
    ]),
);

define(
    'LocationHistory',
    json_encode([
        'query' => 'LocationHistory',
        'headers' => ['key1' => 'Location', 'key2' => 'Purpose', 'key3' => 'FromDate'],
    ]),
);

define(
    'GovernmentCertificates',
    json_encode([
        'query' => 'GovernmentCertificates',
        'headers' => ['key1' => 'DocumentType', 'key2' => 'ValidTo', 'key3' => 'ReferenceNo'],
    ]),
);

define(
    'Relationship',
    json_encode([
        'query' => 'Relationship',
        'headers' => ['key1' => 'Name', 'key2' => 'RelationshipType', 'key3' => 'ContactMode'],
    ]),
);

define(
    'WebHistory',
    json_encode([
        'query' => 'WebHistory',
        'headers' => ['key1' => 'SiteName', 'key2' => 'Usage', 'key3' => 'DocumentType '],
    ]),
);

define(
    'Travel',
    json_encode([
        'query' => 'Travel',
        'headers' => ['key1' => 'TravelType', 'key2' => 'FromDate', 'key3' => 'ToPlace'],
    ]),
);

define(
    'Devices',
    json_encode([
        'query' => 'Devices',
        'headers' => ['key1' => 'DiviceName', 'key2' => 'Brand', 'key3' => 'ReferenceNumber'],
    ]),
);

define(
    'Wishes',
    json_encode(['query' => 'Wishes', 'headers' => ['key1' => 'EventType', 'key2' => 'EventName', 'key3' => 'Date']]),
);

define(
    'Contacts',
    json_encode([
        'query' => 'Contacts',
        'headers' => ['key1' => 'ContactName', 'key2' => 'PersonalEmail', 'key3' => 'MobilePhoneNumber'],
    ]),
);

define(
    'Employment',
    json_encode([
        'query' => 'Employment',
        'headers' => ['key1' => 'DocumentType', 'key2' => 'OrganisationName', 'key3' => 'IssuedDate'],
    ]),
);

define(
    'Projects',
    json_encode([
        'query' => 'Projects',
        'headers' => ['key1' => 'ProjectName', 'key2' => 'ProjectType', 'key3' => 'FromDate'],
        'subheaders' => ['key1' => 'TaskName', 'key2' => 'FromDate', 'key3' => 'ToDate'],
    ]),
);

define(
    'Skills',
    json_encode([
        'query' => 'Skills',
        'headers' => ['key1' => 'SkillType', 'key2' => 'SkillName', 'key3' => 'FromDate'],
    ]),
);

define(
    'Apps',
    json_encode([
        'query' => 'Apps',
        'headers' => ['key1' => 'AppType', 'key2' => 'AppName', 'key3' => 'PasswordChangeStatus'],
    ]),
);

define(
    'Resume',
    json_encode([
        'query' => 'Resume',
        'headers' => ['key1' => 'ResumeType', 'key2' => 'Name', 'key3' => 'FunctionalArea'],
    ]),
);

define(
    'LegalDispute',
    json_encode([
        'query' => 'LegalDispute',
        'headers' => ['key1' => 'DisputeType', 'key2' => 'PartyName', 'key3' => 'FromDate'],
    ]),
);

define(
    'LegalOwnershipTransfer',
    json_encode([
        'query' => 'LegalOwnershipTransfer',
        'headers' => ['key1' => 'TransferType', 'key2' => 'AssetName', 'key3' => 'ValidFrom'],
    ]),
);

define(
    'MedMedicalTest',
    json_encode([
        'query' => 'MedMedicalTest',
        'headers' => ['key1' => 'TestName', 'key2' => 'TestType', 'key3' => 'TestDate'],
        'subheaders' => ['key1' => 'DiagnosticCenterName', 'key2' => 'Address', 'key3' => 'TestDate'],
    ]),
);

define(
    'MedPrescription',
    json_encode([
        'query' => 'MedPrescription',
        'headers' => ['key1' => 'PrescriptionType', 'key2' => 'DiseaseName', 'key3' => 'MedicineName'],
        'subheaders' => ['key1' => 'MedicineName', 'key2' => 'Tenure', 'key3' => 'MedicineType'],
    ]),
);

define(
    'MedFamily',
    json_encode([
        'query' => 'MedFamily',
        'headers' => ['key1' => 'DiseaseType', 'key2' => 'TreatmentType', 'key3' => 'FromDate'],
        'subheaders' => ['key1' => 'PatientName', 'key2' => 'Address', 'key3' => 'FromDate'],
    ]),
);

define(
    'MedHealthInsurance',
    json_encode([
        'query' => 'MedHealthInsurance',
        'headers' => ['key1' => 'PolicyType', 'key2' => 'PolicyNumber', 'key3' => 'FromDate'],
        'subheaders' => ['key1' => 'BeneficiaryName', 'key2' => 'Relation', 'key3' => ''],
    ]),
);

define(
    'FinFinancialAccounts',
    json_encode([
        'query' => 'FinFinancialAccounts',
        'headers' => ['key1' => 'AccountType', 'key2' => 'AccountNumber', 'key3' => 'BranchName'],
    ]),
);

define(
    'FinAsset',
    json_encode([
        'query' => 'FinAsset',
        'headers' => ['key1' => 'AssetType', 'key2' => 'AssetName', 'key3' => 'ValidFrom'],
    ]),
);

define(
    'FinRevenue',
    json_encode([
        'query' => 'FinRevenue',
        'headers' => ['key1' => 'RevenueType', 'key2' => 'ItemName', 'key3' => 'Term'],
        'subheaders' => ['key1' => 'Amount', 'key2' => 'Notes', 'key3' => 'RevenueDate'],
    ]),
);

define(
    'FinCards',
    json_encode([
        'query' => 'FinCards',
        'headers' => ['key1' => 'CardType', 'key2' => 'ServiceProviderName', 'key3' => 'CardNumber'],
    ]),
);

define(
    'FinLiability',
    json_encode([
        'query' => 'FinLiability',
        'headers' => ['key1' => 'LiabilityType', 'key2' => 'LiabilityName', 'key3' => 'FromDate'],
    ]),
);

define(
    'FinPayment',
    json_encode([
        'query' => 'FinPayment',
        'headers' => ['key1' => 'PaymentType', 'key2' => 'ItemName', 'key3' => 'Term'],
        'subheaders' => ['key1' => 'Amount', 'key2' => 'Notes', 'key3' => 'PaymentDate'],
    ]),
);

define(
    'FinTax',
    json_encode([
        'query' => 'FinTax',
        'headers' => ['key1' => 'TaxDocumentType', 'key2' => 'Date', 'key3' => 'AssessmentYear'],
    ]),
);

define(
    'FinInsurance',
    json_encode([
        'query' => 'FinInsurance',
        'headers' => ['key1' => 'InsuranceType', 'key2' => 'PolicyNumber', 'key3' => 'FromDate'],
    ]),
);

define('AccountUpgradeAmonut', 500);
define('recordsPerPage', 50);
