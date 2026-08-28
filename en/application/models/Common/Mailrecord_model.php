<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mailrecord_model extends CI_Model
{
    public function mail_record($params)
    {
        $RecordTypeId = $params['record_type_id'];
        $addtext = $params['addtext'];
        $this->mongodb->where(['RecordTypeId' => $RecordTypeId]);
        $dbtable = $this->mongodb->get(TBL_RECORDTYPE);
        foreach ($dbtable as $utils) {
            $table_name = $utils['DBTable'];
            $record_type = $utils['RecordType'];
            $module_name = $utils['Module'];
        }

        $selective_attach = $params['selective_attach'];
        $doc_id_arr = $params['document_id'];
        $sub_id_arr = $params['sub_record_id'];
        $id_list = $params['ids'];
        $user_id = $this->session->userdata('user_id');
        $record_id_arr = explode(',', $id_list);

        $this->mongodb->where(['UserId' => mongo_id($user_id)]);
        $validUser = $this->mongodb->get(TBL_USER);
        if (safe_count($validUser ?? []) > 0) {
            foreach ($validUser as $userData) {
                $user_email = $userData['Email'];
                $user_fullname = $userData['Name'];

                $phone = $userData['Phone'];
            }
        } else {
            return ['status' => 'failed', 'data' => 'invalid user'];
        }

        if (safe_count($record_id_arr ?? []) > 0) {
            $email_content = header_top_record_mail;

            $table_bg_color = '#99CCCC';
            foreach ($record_id_arr as $l_record_id) {
                $table_bg_color =
                    $table_bg_color == '#CCCC99' ? '#99CCCC' : '#99CCCC';
                if (empty($selective_attach)) {
                } else {
                    $this->mongodb->where([
                        'RecordId' => mongo_id($l_record_id),
                    ]);
                    $tmp_qry = $this->mongodb->get($table_name);
                    foreach ($tmp_qry as $tmp_rec) {
                        $document_type = '';

                        $subject = '';
                        if ($RecordTypeId == 1) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                $tmp_rec['Class'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_school_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 2) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                'UG / Graduate' .
                                ' | ' .
                                $tmp_rec['Degree'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_ug_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 3) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                $tmp_rec['Degree'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_pg_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 4) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                $tmp_rec['Degree'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_phd_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 5) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                $tmp_rec['CertificateName'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_certification_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 6) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                $tmp_rec['ExamName'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_exam_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 7) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                $tmp_rec['Title'] .
                                ' | ' .
                                $tmp_rec['DocumentType'];
                            $email_content .= $this->get_projects_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 8) {
                            $travel_status = $tmp_rec['TravelStatus'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['Location']) .
                                ' | ' .
                                stripslashes($tmp_rec['Purpose']);
                            $email_content .= $this->get_location_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $travel_status,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 9) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['DocumentType']) .
                                ' | ' .
                                stripslashes($tmp_rec['ReferenceNo']);
                            $email_content .= $this->get_govt_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 10) {
                            $document_type = $tmp_rec['RelationshipType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['RelationshipType']) .
                                ' | ' .
                                stripslashes($tmp_rec['ContactMode']);
                            $email_content .= $this->get_relation_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 11) {
                            $document_type = $tmp_rec['SiteName'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['SiteName']) .
                                ' | ' .
                                stripslashes($tmp_rec['Usage']);
                            $email_content .= $this->get_web_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 12) {
                            $travel_type = $tmp_rec['TravelType'];
                            $travellers = $tmp_rec['Travellers'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['TravelType']) .
                                ' | ' .
                                stripslashes($tmp_rec['ToPlace']);
                            $email_content .= $this->get_travel_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $travel_type,
                                $travellers,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 13) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['DiviceName']) .
                                ' | ' .
                                stripslashes($tmp_rec['Brand']);
                            $email_content .= $this->get_warranty_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 14) {
                            $document_type = $tmp_rec['ContactType'];
                            $contact_type = $tmp_rec['ContactType'];
                            $category = $tmp_rec['Category'];
                            $subject =
                                "$user_fullname | " .
                                'Contacts' .
                                ' Record | ' .
                                stripslashes($tmp_rec['ContactName']) .
                                ' | ' .
                                stripslashes($tmp_rec['MobilePhoneNumber']);
                            $email_content .= $this->get_contacts_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $contact_type,
                                $category,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 15) {
                            $document_type = $tmp_rec['DocumentType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['DocumentType']) .
                                ' | ' .
                                stripslashes($tmp_rec['OrganisationName']);
                            $email_content .= $this->get_employment_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 16) {
                            $document_type = $tmp_rec['ProjectName'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['ProjectName']) .
                                ' | ' .
                                stripslashes($tmp_rec['Organisation']);
                            $email_content .= $this->get_proprojects_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 17) {
                            $document_type = $tmp_rec['SkillType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['SkillType']) .
                                ' | ' .
                                stripslashes($tmp_rec['SkillName']);
                            $email_content .= $this->get_skills_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 18) {
                            $document_type = $tmp_rec['AppType'];
                            $password_change_status =
                                $tmp_rec['PasswordChangeStatus'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['AppType']) .
                                ' | ' .
                                stripslashes($tmp_rec['AppName']);
                            $email_content .= $this->get_apps_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $password_change_status,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 38) {
                            $document_type = $tmp_rec['Name'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' | ' .
                                stripslashes($tmp_rec['Name']) .
                                ' | ' .
                                stripslashes($tmp_rec['KeySkills']);
                            $email_content .= $this->get_resume_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 19) {
                            $document_type = $tmp_rec['TestType'];
                            $subject =
                                "$user_fullname | Medical Test Record | " .
                                $tmp_rec['TestType'] .
                                ' | ' .
                                $tmp_rec['TestName'];
                            $email_content .= $this->get_medicaltest_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 20) {
                            $document_type = $tmp_rec['PrescriptionType'];
                            $subject =
                                "$user_fullname | Prescription Record | " .
                                $tmp_rec['PrescriptionType'] .
                                ' | ' .
                                $tmp_rec['DiseaseName'];
                            $email_content .= $this->get_prescription_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 21) {
                            $document_type = $tmp_rec['DiseaseType'];
                            $subject =
                                "$user_fullname | Family Health Record | " .
                                $tmp_rec['DiseaseType'] .
                                ' | ' .
                                $tmp_rec['DiseaseName'];
                            $email_content .= $this->get_familyhealth_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 22) {
                            $document_type = $tmp_rec['PolicyType'];
                            $subject =
                                "$user_fullname | Health Insurance Record | " .
                                $tmp_rec['PolicyType'] .
                                ' | ' .
                                $tmp_rec['PolicyNumber'];
                            $email_content .= $this->get_healthinsurance_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 28) {
                            $document_type = $tmp_rec['DisputeType'];
                            $subject =
                                "$user_fullname | Legal Dispute Record | " .
                                $tmp_rec['DisputeType'] .
                                ' | ' .
                                $tmp_rec['PartyName'];
                            $email_content .= $this->get_legaldispute_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 29) {
                            $document_type = $tmp_rec['TransferType'];
                            $subject =
                                "$user_fullname | Ownership Transfer Record | " .
                                $tmp_rec['TransferType'] .
                                ' | ' .
                                $tmp_rec['AssetName'];
                            $email_content .= $this->get_ownershiptrnsfr_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 30) {
                            $document_type = $tmp_rec['OrganizationName'];
                            $subject =
                                "$user_fullname | Bank Accounts Record | " .
                                $tmp_rec['OrganizationName'] .
                                ' | ' .
                                $tmp_rec['AccountNumber'];
                            $email_content .= $this->get_finaccounts_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 31) {
                            $document_type = $tmp_rec['AssetType'];
                            $subject =
                                "$user_fullname | Assets Record | " .
                                $tmp_rec['AssetType'] .
                                ' | ' .
                                $tmp_rec['AssetName'];
                            $email_content .= $this->get_finassets_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 32) {
                            $document_type = $tmp_rec['RevenueType'];
                            $subject =
                                "$user_fullname | Income Record | " .
                                $tmp_rec['RevenueType'] .
                                ' | ' .
                                $tmp_rec['ItemName'];
                            $email_content .= $this->get_finrevenues_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 33) {
                            $card_type = $tmp_rec['CardType'];
                            $usage_type = $tmp_rec['UsageType'];

                            $subject =
                                "$user_fullname | Cards Record | " .
                                $tmp_rec['CardType'] .
                                ' | ' .
                                $tmp_rec['ServiceProviderName'];
                            $email_content .= $this->get_fincards_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $card_type,
                                $usage_type,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 34) {
                            $document_type = $tmp_rec['LiabilityType'];
                            $subject =
                                "$user_fullname | Loan Record | " .
                                $tmp_rec['LiabilityType'] .
                                ' | ' .
                                $tmp_rec['LiabilityName'];
                            $email_content .= $this->get_finliability_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 35) {
                            $document_type = $tmp_rec['PaymentType'];
                            $subject =
                                "$user_fullname | Expense Record | " .
                                $tmp_rec['PaymentType'] .
                                ' | ' .
                                $tmp_rec['ItemName'];
                            $email_content .= $this->get_finpayment_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                                $sub_id_arr,
                            );
                        } elseif ($RecordTypeId == 36) {
                            $document_type = $tmp_rec['TaxDocumentType'];
                            $subject =
                                "$user_fullname | Tax Record | " .
                                $tmp_rec['TaxDocumentType'] .
                                ' | ' .
                                $tmp_rec['AssessmentYear'];
                            $email_content .= $this->get_fintax_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 37) {
                            $insurance_type = $tmp_rec['InsuranceType'];
                            $subject =
                                "$user_fullname | Insurance Record | " .
                                $tmp_rec['InsuranceType'] .
                                ' | ' .
                                $tmp_rec['PolicyNumber'];
                            $email_content .= $this->get_fininsurance_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $insurance_type,
                                $addtext,
                            );
                        } elseif ($RecordTypeId == 42) {
                            $document_type = $tmp_rec['EventType'];
                            $subject =
                                "$user_fullname | " .
                                ucwords($record_type) .
                                ' Record | ' .
                                stripslashes($tmp_rec['EventType']) .
                                ' | ' .
                                stripslashes($tmp_rec['Location']);
                            $email_content .= $this->get_events_select(
                                $doc_id_arr,
                                $l_record_id,
                                $table_bg_color,
                                '#FFFFFF',
                                $document_type,
                                $addtext,
                            );
                        }
                    }
                }
            }

            $email_content .= header_bottom;
            $header_title = str_replace('Publishat.com | ', '', $subject);
            $email_content = str_replace(
                '##HEADER-TITLE##',
                $header_title,
                $email_content,
            );
            $email_content = str_replace(
                '##HEADER-EMAIL##',
                $user_email,
                $email_content,
            );
            $email_content = str_replace(
                '##HEADER-NAME##',
                $user_fullname,
                $email_content,
            );
            $email_content = str_replace(
                '##HEADER-PHONE##',
                $phone,
                $email_content,
            );
            $from_email = $this->session->userdata('email');

            $email_list = $params['email_list'];
            if (!empty($email_list)) {
                $email_arr = explode(',', trim($email_list));
                if (safe_count($email_arr ?? []) > 0) {
                    foreach ($email_arr as $out_email) {
                        try {
                            $this->phpmail_nocc(
                                $from_email,
                                trim($out_email),
                                $subject,
                                $email_content,
                                'html',
                            );
                            $status_code = 1;
                        } catch (Exception $e) {
                        }
                    }
                }
            }
            if ($status_code == 1) {
                $status_message =
                    'Emails have been sent with the record details';

                if ($RecordTypeId == 1) {
                    $headers = [
                        'key1' => 'Class',
                        'key2' => 'SchoolName',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 2) {
                    $headers = [
                        'key1' => 'Degree',
                        'key2' => 'Term',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 3) {
                    $headers = [
                        'key1' => 'Degree',
                        'key2' => 'Term',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 4) {
                    $headers = [
                        'key1' => 'Degree',
                        'key2' => 'Term',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 5) {
                    $headers = [
                        'key1' => 'CertificationType',
                        'key2' => 'CertificateName',
                        'key3' => 'ValidFrom',
                    ];
                }
                if ($RecordTypeId == 6) {
                    $headers = [
                        'key1' => 'ExamType',
                        'key2' => 'ExamName',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 7) {
                    $headers = [
                        'key1' => 'ProjectType',
                        'key2' => 'Title',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 8) {
                    $headers = [
                        'key1' => 'Location',
                        'key2' => 'Purpose',
                        'key3' => 'FromDate',
                    ];
                }
                if ($RecordTypeId == 9) {
                    $headers = [
                        'key1' => 'DocumentType',
                        'key2' => 'IssuedDate',
                        'key3' => 'ReferenceNo',
                    ];
                }
                if ($RecordTypeId == 10) {
                    $headers = [
                        'key1' => 'Name',
                        'key2' => 'RelationshipType',
                        'key3' => 'ContactMode',
                    ];
                }
                if ($RecordTypeId == 11) {
                    $headers = [
                        'key1' => 'SiteName',
                        'key2' => 'Usage',
                        'key3' => 'DocumentStatus',
                    ];
                }
                if ($RecordTypeId == 12) {
                    $headers = [
                        'key1' => 'TravelType',
                        'key2' => 'FromDate',
                        'key3' => 'ToPlace',
                    ];
                }
                if ($RecordTypeId == 13) {
                    $headers = [
                        'key1' => 'DeviceName',
                        'key2' => 'Brand',
                        'key3' => 'ReferenceNumber',
                    ];
                }
                if ($RecordTypeId == 14) {
                    $headers = [
                        'key1' => 'ContactName',
                        'key2' => 'MobileNumber',
                        'key3' => 'PersonalEmail',
                    ];
                }
                if ($RecordTypeId == 15) {
                    $headers = [
                        'key1' => 'DocumentType',
                        'key2' => 'OrganisationName',
                        'key3' => 'IssuedDate',
                    ];
                }
                if ($RecordTypeId == 16) {
                    $headers = [
                        'key1' => 'ProjectName',
                        'key2' => 'FromDate',
                        'key3' => 'ToDate',
                    ];
                }
                if ($RecordTypeId == 17) {
                    $headers = [
                        'key1' => 'SkillType',
                        'key2' => 'SkillName',
                        'key3' => 'DocumentType',
                    ];
                }
                if ($RecordTypeId == 18) {
                    $headers = [
                        'key1' => 'AppType',
                        'key2' => 'AppName',
                        'key3' => 'PasswordChangeStatus',
                    ];
                }
                if ($RecordTypeId == 38) {
                    $headers = [
                        'key1' => 'ResumeType',
                        'key2' => 'Name',
                        'key3' => 'FunctionalArea',
                    ];
                }
                if ($RecordTypeId == 19) {
                    $headers = [
                        'key1' => 'TestName',
                        'key2' => 'TestType',
                        'key3' => 'TestDate',
                    ];
                }
                if ($RecordTypeId == 20) {
                    $headers = [
                        'key1' => 'PrescriptionType',
                        'key2' => 'DiseaseName',
                        'key3' => 'MedicineType',
                    ];
                }
                if ($RecordTypeId == 21) {
                    $headers = [
                        'key1' => 'DiseaseType',
                        'key2' => 'TreatmentType',
                        'key3' => 'FromDate',
                    ];
                }
                if ($RecordTypeId == 22) {
                    $headers = [
                        'key1' => 'PolicyType',
                        'key2' => 'PolicyName',
                        'key3' => 'FromDate',
                    ];
                }
                if ($RecordTypeId == 28) {
                    $headers = [
                        'key1' => 'DisputeType',
                        'key2' => 'PartyName',
                        'key3' => 'FromDate',
                    ];
                }
                if ($RecordTypeId == 29) {
                    $headers = [
                        'key1' => 'TransferType',
                        'key2' => 'AssetName',
                        'key3' => 'ValidFrom',
                    ];
                }
                if ($RecordTypeId == 30) {
                    $headers = [
                        'key1' => 'AccountType',
                        'key2' => 'AccountNumber',
                        'key3' => 'BranchName',
                    ];
                }
                if ($RecordTypeId == 31) {
                    $headers = [
                        'key1' => 'AssetType',
                        'key2' => 'AssetName',
                        'key3' => 'ValidFrom',
                    ];
                }
                if ($RecordTypeId == 32) {
                    $headers = [
                        'key1' => 'RevenueType',
                        'key2' => 'ItemName',
                        'key3' => 'Term',
                    ];
                }
                if ($RecordTypeId == 33) {
                    $headers = [
                        'key1' => 'CardType',
                        'key2' => 'ServiceProviderName',
                        'key3' => 'CardNumber',
                    ];
                }
                if ($RecordTypeId == 34) {
                    $headers = [
                        'key1' => 'LiabilityType',
                        'key2' => 'LiabilityName',
                        'key3' => 'FromDate',
                    ];
                }
                if ($RecordTypeId == 35) {
                    $headers = [
                        'key1' => 'PaymentType',
                        'key2' => 'ItemName',
                        'key3' => 'Term',
                    ];
                }
                if ($RecordTypeId == 36) {
                    $headers = [
                        'key1' => 'TaxDocumentType',
                        'key2' => 'Date',
                        'key3' => 'AssessmentYear',
                    ];
                }
                if ($RecordTypeId == 37) {
                    $headers = [
                        'key1' => 'InsuranceType',
                        'key2' => 'PolicyName',
                        'key3' => 'FromDate',
                    ];
                }
                if ($RecordTypeId == 42) {
                    $headers = [
                        'key1' => 'Event Type',
                        'key2' => 'Event Name',
                        'key3' => 'Date',
                    ];
                }

                $document_type = $headers['key3'];
                $record_name = $headers['key1'];

                $eventdata = [
                    'UserId' => $user_id,
                    'EventType' => 'Shared',
                    'Module' => $module_name,
                    'RecordName' => $record_name,
                    'RecordType' => $record_type,
                    'DocumentType' => $document_type,
                    'Receiver' => $email_list,
                    'Date' => TimeStamp,
                ];
                $qry = $this->mongodb->insert(TBL_EVENTS, $eventdata);

                return ['status' => 'success', 'data' => 'Mail has been sent.'];
            } else {
                $status_message =
                    'Error: No emails have been sent. Please try again. ';
                return ['status' => 'failed', 'data' => 'No mails sent'];
            }
        }
    }

    public function get_school_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $document_type,
        $addtext,
    ) {
        $record_type_id = 1;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_SCHOOL);
        if (safe_count($qry ?? []) > 0) {
            if ($document_type == 'Marks Memo') {
                $email_template =
                    '../../templates/email-academic-school-template.html';
            } elseif (
                $document_type == 'Hall Ticket' ||
                $document_type == 'ID Card'
            ) {
                $email_template =
                    '../../templates/email-academic-school-template2.html';
            } else {
                $email_template =
                    '../../templates/email-academic-school-template1.html';
            }

            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $type = stripslashes($rec['Type']);
                $class = stripslashes($rec['Class']);
                $school_name = stripslashes($rec['SchoolName']);
                $location = stripslashes($rec['Location']);
                $document_type = stripslashes($rec['DocumentType']);
                $exam_type = stripslashes($rec['ExamType']);
                $board = stripslashes($rec['Board']);
                $year_of_passing = stripslashes($rec['YearofPassing']);
                $marks = stripslashes($rec['Marks']);
                $max_marks = stripslashes($rec['MaxMarks']);
                $grade = stripslashes($rec['Grade']);
                $percentage = stripslashes($rec['Percentage']);
                $rank = stripslashes($rec['Rank']);
                $roll_number = stripslashes($rec['RollNumber']);
                $hall_ticket_number = stripslashes($rec['HallTicketNumber']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SCHOOL LEVEL##',
                    $type,
                    $email_body,
                );
                $email_body = str_replace('##CLASS##', $class, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SCHOOL-NAME##',
                    $school_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOCATION##',
                    $location,
                    $email_body,
                );
                $email_body = str_replace('##BOARD##', $board, $email_body);
                $email_body = str_replace(
                    '##EXAM-TYPE##',
                    $exam_type,
                    $email_body,
                );
                $email_body = str_replace('##MARKS##', $marks, $email_body);
                $email_body = str_replace(
                    '##MAX-MARKS##',
                    $max_marks,
                    $email_body,
                );
                $email_body = str_replace(
                    '##YEAR-OF-PASSING##',
                    $year_of_passing,
                    $email_body,
                );
                $email_body = str_replace('##RANK##', $rank, $email_body);
                $email_body = str_replace(
                    '##ROLL-NUMBER##',
                    $roll_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HALL-TICKET-NUMBER##',
                    $hall_ticket_number,
                    $email_body,
                );
                $email_body = str_replace('##GRADE##', $grade, $email_body);
                $email_body = str_replace(
                    '##PERCENTAGE##',
                    $percentage,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_ug_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $document_type,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 2;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_UNDERGRADUATE);
        if (safe_count($qry ?? []) > 0) {
            if ($document_type == 'Marks Memo') {
                $email_template =
                    '../../templates/email-academic-ug-template.html';
            } else {
                $email_template =
                    '../../templates/email-academic-ug-template2.html';
            }
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $record_id = $rec['RecordId'];
                $level = stripslashes($rec['Level']);
                $degree = stripslashes($rec['Degree']);
                $college = stripslashes($rec['CollegeName']);
                $document_type = stripslashes($rec['DocumentType']);
                $academic_year = stripslashes($rec['AcademicYear']);
                $term = stripslashes($rec['Term']);
                $university = stripslashes($rec['University']);
                $specialisation = stripslashes($rec['Specialisation']);
                $year_of_passing = stripslashes($rec['YearOfPassing']);
                $marks = stripslashes($rec['Marks']);
                $max_marks = stripslashes($rec['MaxMarks']);
                $grade = stripslashes($rec['Grade']);
                $percentage = stripslashes($rec['PercentageGrade']);
                $rank = stripslashes($rec['Rank']);
                $roll_number = stripslashes($rec['RollNumber']);
                $hall_ticket_number = stripslashes($rec['HallTicketNumber']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $ug_loop_str = $this->get_ug_marksmemo_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace('##UG-LEVEL##', $level, $email_body);
                $email_body = str_replace('##DEGREE##', $degree, $email_body);
                $email_body = str_replace('##COLLGE##', $college, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACADEMIC-YEAR##',
                    $academic_year,
                    $email_body,
                );
                $email_body = str_replace('##TERM##', $term, $email_body);
                $email_body = str_replace(
                    '##UNIVERSITY##',
                    $university,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SPECIALISATION##',
                    $specialisation,
                    $email_body,
                );
                $email_body = str_replace('##MARKS##', $marks, $email_body);
                $email_body = str_replace(
                    '##MAX-MARKS##',
                    $max_marks,
                    $email_body,
                );
                $email_body = str_replace('##GRADE##', $grade, $email_body);
                $email_body = str_replace(
                    '##YEAR-OF-PASSING##',
                    $year_of_passing,
                    $email_body,
                );
                $email_body = str_replace('##RANK##', $rank, $email_body);
                $email_body = str_replace(
                    '##PERCENTAGE##',
                    $percentage,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ROLL-NUMBER##',
                    $roll_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HALL-TICKET-NUMBER##',
                    $hall_ticket_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##UG-LOOP##',
                    $ug_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_pg_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $document_type,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 3;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_POSTGRADUATE);
        if (safe_count($qry ?? []) > 0) {
            if ($document_type == 'Marks Memo') {
                $email_template =
                    '../../templates/email-academic-pg-template.html';
            } else {
                $email_template =
                    '../../templates/email-academic-pg-template2.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $record_id = $rec['RecordId'];
                $level = stripslashes($rec['Level']);
                $degree = stripslashes($rec['Degree']);
                $college = stripslashes($rec['CollegeName']);
                $document_type = stripslashes($rec['DocumentType']);
                $academic_year = stripslashes($rec['AcademicYear']);
                $term = stripslashes($rec['Term']);
                $university = stripslashes($rec['University']);
                $specialisation = stripslashes($rec['Specialisation']);
                $year_of_passing = stripslashes($rec['YearOfPassing']);
                $marks = stripslashes($rec['Marks']);
                $max_marks = stripslashes($rec['MaxMarks']);
                $grade = stripslashes($rec['Grade']);
                $percentage = stripslashes($rec['PercentageGrade']);
                $rank = stripslashes($rec['Rank']);
                $roll_number = stripslashes($rec['RollNumber']);
                $hall_ticket_number = stripslashes($rec['HallTicketNumber']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                    $attachments .= $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        '44',
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $pg_loop_str = $this->get_pg_marksmemo_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );
                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace('##PG-TYPE##', $level, $email_body);
                $email_body = str_replace('##DEGREE##', $degree, $email_body);
                $email_body = str_replace('##COLLGE##', $college, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACADEMIC-YEAR##',
                    $academic_year,
                    $email_body,
                );
                $email_body = str_replace('##TERM##', $term, $email_body);
                $email_body = str_replace(
                    '##UNIVERSITY##',
                    $university,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SPECIALISATION##',
                    $specialisation,
                    $email_body,
                );
                $email_body = str_replace('##MARKS##', $marks, $email_body);
                $email_body = str_replace(
                    '##MAX-MARKS##',
                    $max_marks,
                    $email_body,
                );
                $email_body = str_replace('##GRADE##', $grade, $email_body);
                $email_body = str_replace(
                    '##YEAR-OF-PASSING##',
                    $year_of_passing,
                    $email_body,
                );
                $email_body = str_replace('##RANK##', $rank, $email_body);
                $email_body = str_replace(
                    '##PERCENTAGE##',
                    $percentage,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ROLL-NUMBER##',
                    $roll_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HALL-TICKET-NUMBER##',
                    $hall_ticket_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PG_LOOP##',
                    $pg_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_phd_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $document_type,
        $addtext,
    ) {
        $record_type_id = 4;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_PHD);
        if (safe_count($qry ?? []) > 0) {
            if ($document_type == 'Marks Memo') {
                $email_template =
                    '../../templates/email-academic-phd-template.html';
            } else {
                $email_template =
                    '../../templates/email-academic-phd-template2.html';
            }

            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $level = stripslashes($rec['Level']);
                $degree = stripslashes($rec['Degree']);
                $college = stripslashes($rec['CollegeName']);
                $document_type = stripslashes($rec['DocumentType']);
                $academic_year = stripslashes($rec['AcademicYear']);
                $term = stripslashes($rec['Term']);
                $university = stripslashes($rec['University']);
                $specialisation = stripslashes($rec['Specialisation']);
                $year_of_passing = stripslashes($rec['YearOfPassing']);
                $marks = stripslashes($rec['Marks']);
                $max_marks = stripslashes($rec['MaxMarks']);
                $grade = stripslashes($rec['Grade']);
                $percentage = stripslashes($rec['PercentageGrade']);
                $rank = stripslashes($rec['Rank']);
                $roll_number = stripslashes($rec['RollNumber']);
                $hall_ticket_number = stripslashes($rec['HallTicketNumber']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace('##PHD-TYPE##', $level, $email_body);
                $email_body = str_replace('##DEGREE##', $degree, $email_body);
                $email_body = str_replace('##COLLGE##', $college, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACADEMIC-YEAR##',
                    $academic_year,
                    $email_body,
                );
                $email_body = str_replace('##TERM##', $term, $email_body);
                $email_body = str_replace(
                    '##UNIVERSITY##',
                    $university,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SPECIALISATION##',
                    $specialisation,
                    $email_body,
                );
                $email_body = str_replace('##MARKS##', $marks, $email_body);
                $email_body = str_replace(
                    '##MAX-MARKS##',
                    $max_marks,
                    $email_body,
                );
                $email_body = str_replace('##GRADE##', $grade, $email_body);
                $email_body = str_replace(
                    '##YEAR-OF-PASSING##',
                    $year_of_passing,
                    $email_body,
                );
                $email_body = str_replace('##RANK##', $rank, $email_body);
                $email_body = str_replace(
                    '##PERCENTAGE##',
                    $percentage,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ROLL-NUMBER##',
                    $roll_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HALL-TICKET-NUMBER##',
                    $hall_ticket_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_certification_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 5;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_CERTIFICATION);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-academic-certification-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $certification_type = stripslashes($rec['CertificationType']);
                $certificate_name = stripslashes($rec['CertificateName']);
                $document_type = stripslashes($rec['DocumentType']);
                $valid_from = stripslashes($rec['ValidFrom']);
                $valid_to = stripslashes($rec['ValidTo']);
                $certification_status = stripslashes(
                    $rec['CertificationStatus'],
                );
                $result = stripslashes($rec['Result']);
                $grade = stripslashes($rec['Grade']);
                $percentage = stripslashes($rec['PercentageGrade']);
                $certificate_number = stripslashes($rec['CertificateNumber']);
                $organisation_name = stripslashes($rec['OrganisationName']);
                $chapter_name = stripslashes($rec['ChapterName']);
                $address = stripslashes($rec['Address']);
                $url = stripslashes($rec['Url']);
                $username = stripslashes($rec['Username']);
                $password = stripslashes($rec['Password']);
                $notes = stripslashes($rec['Notes']);
                if (!empty($username)) {
                    $username_password = $username;
                }
                if (!empty($password)) {
                    $username_password .= '/' . $password;
                }
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CERTIFICATION-TYPE##',
                    $certification_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CERTIFICATE-NAME##',
                    $certificate_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-FROM##',
                    $valid_from,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-TO##',
                    $valid_to,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $certification_status,
                    $email_body,
                );
                $email_body = str_replace('##RESULT##', $result, $email_body);
                $email_body = str_replace('##GRADE##', $grade, $email_body);
                $email_body = str_replace(
                    '##PERCENTAGE##',
                    $percentage,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CERTIFICATE-NUMBER##',
                    $certificate_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORGANISATION-NAME##',
                    $organisation_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CHAPTER-NAME##',
                    $chapter_name,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace('##LOGIN-URL##', $url, $email_body);
                $email_body = str_replace(
                    '##USERNAME##',
                    $username,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PASSWORD##',
                    $password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_exam_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 6;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_EXAM);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-academic-exam-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $exam_type = stripslashes($rec['ExamType']);
                $exam_name = stripslashes($rec['ExamName']);
                $exam_date = stripslashes($rec['ExamDate']);
                $document_type = stripslashes($rec['DocumentType']);
                $exam_center = stripslashes($rec['ExamCenter']);
                $hall_ticket = stripslashes($rec['HallTicket']);
                $address = stripslashes($rec['Address']);
                $result = stripslashes($rec['Result']);
                $rank = stripslashes($rec['Rank']);
                $marks = stripslashes($rec['Marks']);
                $max_marks = stripslashes($rec['MaxMarks']);
                $percentile = stripslashes($rec['Percentile']);
                $percentage = stripslashes($rec['Percentage']);
                $notes = stripslashes($rec['Notes']);
                $exam_date = $this->date_format_short($exam_date);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EXAM-TYPE##',
                    $exam_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EXAM-NAME##',
                    $exam_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EXAM-DATE##',
                    $exam_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EXAM-CENTER##',
                    $exam_center,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HALL-TICKET##',
                    $hall_ticket,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace('##RESULT##', $result, $email_body);
                $email_body = str_replace('##MARKS##', $marks, $email_body);
                $email_body = str_replace(
                    '##MAX-MARKS##',
                    $max_marks,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PERCENTILE##',
                    $percentile,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PERCENTAGE##',
                    $percentage,
                    $email_body,
                );
                $email_body = str_replace('##RANK##', $rank, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_projects_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 7;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_PROJECT);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-academic-project-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $record_id = stripslashes($rec['RecordId']);
                $project_type = stripslashes($rec['ProjectType']);
                $title = stripslashes($rec['Title']);
                $document_type = stripslashes($rec['DocumentType']);
                $level = stripslashes($rec['Level']);
                $conference = stripslashes($rec['Conference']);
                $author = stripslashes($rec['Author']);
                $coauthors = stripslashes($rec['Coauthers']);
                $address = stripslashes($rec['Address']);
                $submitted_date = stripslashes($rec['SubmittedDate']);
                $status = stripslashes($rec['ProjectStatus']);
                $accepted_date = stripslashes($rec['AcceptedDate']);
                $url = stripslashes($rec['WebsiteUrl']);
                $presentation_date = stripslashes($rec['PresentationDate']);
                $username = stripslashes($rec['UserName']);
                $password = stripslashes($rec['Password']);
                $notes = stripslashes($rec['Notes']);
                $submitted_date = $this->date_format_short($submitted_date);
                $accepted_date = $this->date_format_short($accepted_date);
                $presentation_date = $this->date_format_short(
                    $presentation_date,
                );
                if (!empty($username)) {
                    $username_password = $username;
                }
                if (!empty($password)) {
                    $username_password .= '/' . $password;
                }
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PROJECT-TYPE##',
                    $project_type,
                    $email_body,
                );
                $email_body = str_replace('##TITLE##', $title, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##LEVEL##', $level, $email_body);
                $email_body = str_replace(
                    '##CONFERENCE##',
                    $conference,
                    $email_body,
                );
                $email_body = str_replace('##AUTHOR##', $author, $email_body);
                $email_body = str_replace(
                    '##COAUTHORS##',
                    $coauthors,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##SUBMITTED-DATE##',
                    $submitted_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACCEPTED-DATE##',
                    $accepted_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PRESENTED-DATE##',
                    $presentation_date,
                    $email_body,
                );
                $email_body = str_replace('##URL##', $url, $email_body);
                $email_body = str_replace(
                    '##USERNAME##',
                    $username,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PASSWORD##',
                    $password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_location_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $travel_status,
        $addtext,
    ) {
        $record_type_id = 8;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_LOCATIONHISTORY);
        if (safe_count($qry ?? []) > 0) {
            if ($travel_status == 'Single' || $travel_status == '') {
                $email_template =
                    '../../templates/email-personal-location-history-template1.html';
            } else {
                $email_template =
                    '../../templates/email-personal-location-history-template.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $location = stripslashes($rec['Location']);
                $address = stripslashes($rec['Address']);
                $country = stripslashes($rec['Country']);
                $from_date = stripslashes($rec['FromDate']);
                $name = stripslashes($rec['Name']);
                $nick_name = stripslashes($rec['NickName']);
                $to_date = stripslashes($rec['ToDate']);
                $purpose = stripslashes($rec['Purpose']);
                $mobile_number = stripslashes($rec['MobileNumber']);
                $alternate_phone_number = stripslashes(
                    $rec['AlternatePhoneNumber'],
                );
                $category = stripslashes($rec['Category']);
                $document_type = stripslashes($rec['DocumentType']);
                $famous_for = stripslashes($rec['FamousFor']);
                $travel_status = stripslashes($rec['TravelStatus']);
                $family_member_1 = stripslashes($rec['FamilyMember1']);
                $family_member_2 = stripslashes($rec['FamilyMember2']);
                $family_member_3 = stripslashes($rec['FamilyMember3']);
                $notes = stripslashes($rec['Notes']);
                $from_date = $this->date_format_short($from_date);
                $to_date = $this->date_format_short($to_date);
                $family_members = $family_member_1;
                if (!empty($family_member_2)) {
                    $family_members .= ', ' . $family_member_2;
                }
                if (!empty($family_member_3)) {
                    $family_members .= ', ' . $family_member_3;
                }
                $family_members = trim($family_members, ' ,');

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOCATION##',
                    $location,
                    $email_body,
                );
                $email_body = str_replace('##PURPOSE##', $purpose, $email_body);
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace('##NAME##', $name, $email_body);
                $email_body = str_replace(
                    '##NICK-NAME##',
                    $nick_name,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##MOBILE##',
                    $mobile_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ALTERNATE##',
                    $alternate_phone_number,
                    $email_body,
                );
                $email_body = str_replace('##COUNTRY##', $country, $email_body);
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FAMOUS-FOR##',
                    $famous_for,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $travel_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FAMILY-MEMBERS##',
                    $family_members,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_govt_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $document_type,
        $addtext,
    ) {
        $record_type_id = 9;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_GOVERNMENTCERTIFICATES);
        if (safe_count($qry ?? []) > 0) {
            if (
                $document_type == 'Passport' ||
                $document_type == 'Marriage Certificate' ||
                $document_type == 'Birth Certificate'
            ) {
                $email_template =
                    '../../templates/email-personal-govtcert-template.html';
            } elseif (
                $document_type == 'PAN Card' ||
                $document_type == 'Employee State Insurance (ESI)'
            ) {
                $email_template =
                    '../../templates/email-personal-govtcert-template1.html';
            } else {
                $email_template =
                    '../../templates/email-personal-govtcert-template2.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $document_type = stripslashes($rec['DocumentType']);
                $reference_no = stripslashes($rec['ReferenceNo']);
                $father_name = stripslashes($rec['FatherName']);
                $husband_name = stripslashes($rec['HusbandName']);
                $mother_name = stripslashes($rec['MotherName']);
                $spouse_name = stripslashes($rec['SpouseName']);
                $birth_date = stripslashes($rec['BirthDate']);
                $birth_place = stripslashes($rec['BirthPlace']);
                $issued_date = stripslashes($rec['IssuedDate']);
                $address = stripslashes($rec['Address']);
                $valid_to = stripslashes($rec['ValidTo']);
                $issued_by = stripslashes($rec['IssuedBy']);
                $document_status = stripslashes($rec['DocumentStatus']);
                $issued_place = stripslashes($rec['IssuedPlace']);
                $issued_country = stripslashes($rec['IssuedCountry']);
                $notes = stripslashes($rec['Notes']);
                $birth_date = $this->date_format_short($birth_date);
                $issued_date = $this->date_format_short($issued_date);
                $valid_to = $this->date_format_short($valid_to);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REFERENCE##',
                    $reference_no,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FATHER-NAME##',
                    $father_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HUSBAND-NAME##',
                    $husband_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MOTHER-NAME##',
                    $mother_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SPOUSE-NAME##',
                    $spouse_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BIRTH-DATE##',
                    $birth_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BIRTH-PLACE##',
                    $birth_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-DATE##',
                    $issued_date,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##VALID-TO##',
                    $valid_to,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-AUTHORITY##',
                    $issued_by,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $document_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-PLACE##',
                    $issued_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-COUNTRY##',
                    $issued_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_relation_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 10;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_RELATIONSHIP);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-personal-relation-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $relationship_type = stripslashes($rec['RelationshipType']);
                $name = stripslashes($rec['Name']);
                $contact_mode = stripslashes($rec['ContactMode']);
                $address = stripslashes($rec['Address']);
                $mobile_phone_number = stripslashes($rec['MobilePhoneNumber']);
                $home_phone_number = stripslashes($rec['HomePhoneNumber']);
                $office_phone_number = stripslashes($rec['OfficePhoneNumber']);
                $email = stripslashes($rec['Email']);
                $alternate_email = stripslashes($rec['AlternateEmail']);
                $category = stripslashes($rec['Category']);
                $document_type = stripslashes($rec['DocumentType']);
                $document_status = stripslashes($rec['DocumentStatus']);
                $living_place = stripslashes($rec['LivingPlace']);
                $living_country = stripslashes($rec['LivingCountry']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace('##NAME##', $name, $email_body);
                $email_body = str_replace(
                    '##RELATIONSHIP##',
                    $relationship_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CONTACT-MODE##',
                    $contact_mode,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##MOBILE##',
                    $mobile_phone_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HOME-PHONE##',
                    $home_phone_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OFFICE-PHONE##',
                    $office_phone_number,
                    $email_body,
                );
                $email_body = str_replace('##EMAIL##', $email, $email_body);
                $email_body = str_replace(
                    '##ALT-EMAIL##',
                    $alternate_email,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LIVING-PLACE##',
                    $living_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##COUNTRY##',
                    $living_country,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $document_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_web_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 11;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_WEBHISTORY);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-personal-web-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $category = stripslashes($rec['Category']);
                $site_name = stripslashes($rec['SiteName']);
                $usage = stripslashes($rec['Usage']);
                $url = stripslashes($rec['Url']);
                $document_type = stripslashes($rec['DocumentType']);
                $username = stripslashes($rec['Username']);
                $password = stripslashes($rec['Password']);
                $document_status = stripslashes($rec['DocumentStatus']);
                $service_type = stripslashes($rec['ServiceType']);
                $email_1 = stripslashes($rec['Email']);
                $email_2 = stripslashes($rec['AlternateEmail']);
                $mobile_1 = stripslashes($rec['PhoneNumber']);
                $mobile_2 = stripslashes($rec['AlternatePhoneNumber']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SITE-NAME##',
                    $site_name,
                    $email_body,
                );
                $email_body = str_replace('##USAGE##', $usage, $email_body);
                $email_body = str_replace('##URL##', $url, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##USER-NAME##',
                    $username,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $document_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SERVICE-TYPE##',
                    $service_type,
                    $email_body,
                );
                $email_body = str_replace('##EMAIL-1##', $email_1, $email_body);
                $email_body = str_replace('##EMAIL-2##', $email_2, $email_body);
                $email_body = str_replace(
                    '##MOBILE-1##',
                    $mobile_1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MOBILE-2##',
                    $mobile_2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_travel_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $travel_type,
        $travellers,
        $addtext,
    ) {
        $record_type_id = 12;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_TRAVEL);
        if (safe_count($qry ?? []) > 0) {
            if (
                $travel_type == 'International' &&
                ($travellers == 'Family' || $travellers == 'Group')
            ) {
                $email_template =
                    '../../templates/email-personal-travel-template.html';
            } elseif (
                $travel_type == 'International' &&
                ($travellers == 'Single' || ($travellers = ''))
            ) {
                $email_template =
                    '../../templates/email-personal-travel-template1.html';
            } elseif (
                ($travel_type == 'Domestic' || $travel_type == 'Others') &&
                ($travellers == 'Family' || $travellers == 'Group')
            ) {
                $email_template =
                    '../../templates/email-personal-travel-template2.html';
            } else {
                $email_template =
                    '../../templates/email-personal-travel-template3.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $travel_type = stripslashes($rec['TravelType']);
                $purpose = stripslashes($rec['Purpose']);
                $from_date = stripslashes($rec['FromDate']);
                $from_place = stripslashes($rec['FromPlace']);
                $from_address = stripslashes($rec['FromAddress']);
                $to_date = stripslashes($rec['ToDate']);
                $to_place = stripslashes($rec['ToPlace']);
                $to_address = stripslashes($rec['ToAddress']);
                $visa_type = stripslashes($rec['VisaType']);
                $visa_number = stripslashes($rec['VisaNumber']);
                $issued_date = stripslashes($rec['IssuedDate']);
                $issued_place = stripslashes($rec['IssuedPlace']);
                $valid_to = stripslashes($rec['ValidTo']);
                $port_of_entry = stripslashes($rec['PortOfEntry']);
                $category = stripslashes($rec['Category']);
                $travellers = stripslashes($rec['Travellers']);
                $mode = stripslashes($rec['Mode']);
                $document_type = stripslashes($rec['DocumentType']);
                $document_status = stripslashes($rec['DocumentStatus']);
                $member_1 = stripslashes($rec['Member1']);
                $member_2 = stripslashes($rec['Member2']);
                $member_3 = stripslashes($rec['Member3']);
                $notes = stripslashes($rec['Notes']);

                $members = $member_1;
                if (!empty($member_2)) {
                    $members .= ', ' . $member_2;
                }
                if (!empty($member_3)) {
                    $members .= ', ' . $member_3;
                }
                $members = trim($members, ' ,');
                if (empty($members)) {
                    $members = 'N/A';
                }

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TRAVEL-TYPE##',
                    $travel_type,
                    $email_body,
                );
                $email_body = str_replace('##PURPOSE##', $purpose, $email_body);
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##FROM-PLACE##',
                    $from_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-DATE##',
                    $issued_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-PLACE##',
                    $issued_place_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-ADDRESS##',
                    $from_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TRAVELLERS##',
                    $travellers,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TO-PLACE##',
                    $to_place,
                    $email_body,
                );
                $email_body = str_replace('##MEMBERS##', $members, $email_body);
                $email_body = str_replace(
                    '##TO-ADDRESS##',
                    $to_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VISA-TYPE##',
                    $visa_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VISA-NUMBER##',
                    $visa_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-DATE##',
                    $issued_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-PLACE##',
                    $issued_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-TO##',
                    $valid_to,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PORT##',
                    $port_of_entry,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $document_status,
                    $email_body,
                );
                $email_body = str_replace('##MODE##', $mode, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_warranty_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $document_type,
        $addtext,
    ) {
        $record_type_id = 13;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_DEVICES);
        if (safe_count($qry ?? []) > 0) {
            if ($document_type == 'Warranty') {
                $email_template =
                    '../../templates/email-personal-devices-template.html';
            } else {
                $email_template =
                    '../../templates/email-personal-devices-template1.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $device_type = stripslashes($rec['DeviceType']);
                $device_name = stripslashes($rec['DiviceName']);
                $purchase_date = stripslashes($rec['PuchasedDate']);
                $brand = stripslashes($rec['Brand']);
                $model = stripslashes($rec['Model']);
                $category = stripslashes($rec['Category']);
                $purpose = stripslashes($rec['Purpose']);
                $cost = stripslashes($rec['Cost']);
                $reference_number = stripslashes($rec['ReferenceNumber']);
                $agency_name = stripslashes($rec['AgencyName']);
                $agency_location = stripslashes($rec['AgencyLocation']);
                $lock_user_id = stripslashes($rec['LockUserId']);
                $lock_password = stripslashes($rec['LockPassword']);
                $address = stripslashes($rec['Address']);
                $country = stripslashes($rec['Country']);
                $document_type = stripslashes($rec['DocumentType']);
                $ownership_type = stripslashes($rec['OwnershipType']);
                $warranty_type = stripslashes($rec['WarrantyType']);
                $warranty_status = stripslashes($rec['WarrantyStatus']);
                $expiry_date = stripslashes($rec['ExpiryDate']);
                $contact_phone_number = stripslashes(
                    $rec['ContactPhoneNumber'],
                );
                $contact_email = stripslashes($rec['ContactEmail']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DEVICE-NAME##',
                    $device_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DEVICE-TYPE##',
                    $device_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PURCHASE-DATE##',
                    $device_type,
                    $email_body,
                );
                $email_body = str_replace('##BRAND##', $brand, $email_body);
                $email_body = str_replace('##MODEL##', $model, $email_body);
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##PURPOSE##', $purpose, $email_body);
                $email_body = str_replace('##COST##', $cost, $email_body);
                $email_body = str_replace(
                    '##REFERENCE-NUMBER##',
                    $reference_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##AGENCY-NAME##',
                    $agency_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOCK-ID##',
                    $lock_user_id,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PASSWORD##',
                    $lock_password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOCATION##',
                    $agency_location,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace('##COUNTRY##', $country, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OWNERSHIP-TYPE##',
                    $ownership_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##WARRANTY-TYPE##',
                    $warranty_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $warranty_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EXPIRY-DATE##',
                    $expiry_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CONTACT-NUMBER##',
                    $contact_phone_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EMAIL##',
                    $contact_email,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_events_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $event_type,
        $addtext,
    ) {
        $record_type_id = 42;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_PERSONALEVENTS);
        if (safe_count($qry ?? []) > 0) {
            if ($event_type == 'Wishes') {
                $email_template =
                    '../../templates/email-personal-Events-template1.html';
            } else {
                $email_template =
                    '../../templates/email-personal-Events-template.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $event_type = stripslashes($rec['EventType']);
                $event_name = stripslashes($rec['EventName']);
                $message = stripslashes($rec['Message']);
                $location = stripslashes($rec['Location']);
                $address = stripslashes($rec['Address']);
                $document_status = stripslashes($rec['DocumentStatus']);
                $date = stripslashes($rec['Date']);
                $hours = stripslashes($rec['Hours']);
                $minutes = stripslashes($rec['Minutes']);
                $document_type = stripslashes($rec['DocumentType']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $time = $hours . ':' . $minutes;
                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EVENT-TYPE##',
                    $event_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EVENT-NAME##',
                    $event_name,
                    $email_body,
                );
                $email_body = str_replace('##MESSAGE##', $message, $email_body);
                $email_body = str_replace(
                    '##LOCATION##',
                    $location,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace('##DATE##', $date, $email_body);
                $email_body = str_replace(
                    '##STATUS##',
                    $document_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##TIME##', $time, $email_body);

                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_contacts_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $contact_type,
        $category,
        $addtext,
    ) {
        $record_type_id = 14;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_CONTACTS);
        if (safe_count($qry ?? []) > 0) {
            if ($contact_type == 'Group' && !($category == 'Personal')) {
                $email_template =
                    '../../templates/email-professional-contacts-template.html';
            } elseif (!($contact_type == 'Group') && $category == 'Personal') {
                $email_template =
                    '../../templates/email-professional-contacts-template3.html';
            } elseif ($contact_type == 'Group' && $category == 'Personal') {
                $email_template =
                    '../../templates/email-professional-contacts-template2.html';
            } else {
                $email_template =
                    '../../templates/email-professional-contacts-template4.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $record_id = $rec['RecordId'];
                $contact_type = stripslashes($rec['ContactType']);
                $name = stripslashes($rec['ContactName']);
                $category = stripslashes($rec['Category']);
                $designation = stripslashes($rec['Designation']);
                $organisation_name = stripslashes($rec['OrganisationName']);
                $mobile_phone = stripslashes($rec['MobilePhoneNumber']);
                $alternate_phone = stripslashes($rec['AlternatePhoneNumber']);
                $office_phone = stripslashes($rec['OfficePhoneNumber']);
                $location = stripslashes($rec['Location']);
                $address = stripslashes($rec['Address']);
                $document_type = stripslashes($rec['DocumentType']);
                $office_email = stripslashes($rec['OfficeEmail']);
                $personal_email = stripslashes($rec['PersonalEmail']);
                $contact_status = stripslashes($rec['ContactStatus']);
                $home_address = stripslashes($rec['HomeAddress']);
                $country = stripslashes($rec['Country']);
                $notes = stripslashes($rec['Notes']);
                $group = stripslashes($rec['GroupName']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $medicine_loop_str = $this->get_pro_contact_related_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CONTACT-TYPE##',
                    $contact_type,
                    $email_body,
                );
                $email_body = str_replace('##NAME##', $name, $email_body);
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DESIGNATION##',
                    $designation,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORGANISATION-NAME##',
                    $organisation_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MOBILE-PHONE##',
                    $mobile_phone,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ALTERNATE-PHONE##',
                    $alternate_phone,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OFFICE-PHONE##',
                    $office_phone,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOCATION##',
                    $location,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##OFFICIAL-EMAIL##',
                    $office_email,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PERSONAL-EMAIL##',
                    $personal_email,
                    $email_body,
                );
                $email_body = str_replace(
                    '##STATUS##',
                    $contact_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HOME-ADDRESS##',
                    $home_address,
                    $email_body,
                );
                $email_body = str_replace('##COUNTRY##', $country, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace('##GROUP##', $group, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MEDICINE-LOOP##',
                    $medicine_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_pro_contact_related_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';

        $qry = "SELECT * FROM ContactsContacts WHERE ParentRecordId = '$parent_record_id' AND UserId = '$user_id'";

        $res = $this->db->query($qry);
        $output_str = '';
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $rec) {
                $print_template =
                    '../../templates/email-professional-contacts-template1.html';
                $html_content = read_file($print_template);

                $record_id = $rec['RecordId'];

                $parent_record_id = $rec['ParentRecordId'];
                $name = stripslashes($rec['Name']);
                $mobile = stripslashes($rec['Mobile']);
                $email = stripslashes($rec['Email']);
                $notes = stripslashes($rec['Notes']);
                $header_title = "Contacts | $name | $mobile";

                if ($document_id_arr == '-1') {
                    get_document_email_links(40, $record_id);
                } elseif (safe_count($document_id_arr ?? []) > 0) {
                    $attachments = get_document_email_links_by_id_arr(
                        $document_id_arr,
                        40,
                        $record_id,
                    );
                } else {
                    $attachments =
                        '<i>No documents are attached to this record</i>';
                }

                $html_content = str_replace('##NAME##', $name, $html_content);
                $html_content = str_replace(
                    '##MOBILE##',
                    $mobile,
                    $html_content,
                );
                $html_content = str_replace('##EMAIL##', $email, $html_content);
                $html_content = str_replace('##NOTES##', $notes, $html_content);
                $html_content = str_replace(
                    '##HEADER-TITLE##',
                    $header_title,
                    $html_content,
                );
                $html_content = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $html_content,
                );
                $output_str .= $html_content;
            }
        }
        return $output_str;
    }

    public function get_employment_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 15;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_EMPLOYMENT);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-professional-employment-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $document_type = stripslashes($rec['DocumentType']);
                $employment_type = stripslashes($rec['EmploymentType']);
                $employee_id = stripslashes($rec['EmployeeId']);
                $designation = stripslashes($rec['Designation']);
                $organisation_name = stripslashes($rec['OrganisationName']);
                $place = stripslashes($rec['Place']);
                $issued_date = stripslashes($rec['IssuedDate']);
                $address = stripslashes($rec['Address']);
                $country = stripslashes($rec['Country']);
                $effected_date = stripslashes($rec['EffectedDate']);
                $employment_status = stripslashes($rec['EmploymentStatus']);
                $from_date = stripslashes($rec['FromDate']);
                $ref_name_1 = stripslashes($rec['ReferenceName']);
                $ref_email_1 = stripslashes($rec['ReferenceEmail']);
                $ref_mobile_1 = stripslashes($rec['ReferencePhone']);
                $to_date = stripslashes($rec['ToDate']);
                $ref_name_2 = stripslashes($rec['ReferenceName2']);
                $ref_email_2 = stripslashes($rec['ReferenceEmail2']);
                $ref_mobile_2 = stripslashes($rec['ReferencePhone2']);
                $notes = stripslashes($rec['Notes']);

                $issued_date = $this->date_format_short($issued_date);
                $effected_date = $this->date_format_short($effected_date);
                $from_date = $this->date_format_short($from_date);

                $reference_1 = '';
                if (!empty($ref_name_1)) {
                    $reference_1 = $ref_name_1;
                }
                if (!empty($ref_email_1)) {
                    $reference_1 .= ', ' . $ref_email_1;
                }
                if (!empty($ref_mobile_1)) {
                    $reference_1 .= ', ' . $ref_mobile_1;
                }

                $reference_2 = '';
                if (!empty($ref_name_2)) {
                    $reference_2 = $ref_name_2;
                }
                if (!empty($ref_email_2)) {
                    $reference_2 .= ', ' . $ref_email_2;
                }
                if (!empty($ref_mobile_2)) {
                    $reference_2 .= ', ' . $ref_mobile_2;
                }

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EMPLOYMENT-TYPE##',
                    $employment_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EMPLOYEE-ID##',
                    $employee_id,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DESIGNATION##',
                    $designation,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORGANISATION-NAME##',
                    $organisation_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ISSUED-DATE##',
                    $issued_date,
                    $email_body,
                );
                $email_body = str_replace('##PLACE##', $place, $email_body);

                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##STATUS##',
                    $employment_status,
                    $email_body,
                );
                $email_body = str_replace('##COUNTRY##', $country, $email_body);
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EFFECTED-DATE##',
                    $to_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REFERENCE-1##',
                    $reference_1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REFERENCE-2##',
                    $reference_2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_proprojects_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 16;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_PROJECTS);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-professional-projects-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $user_id = stripslashes($rec['UserId']);
                $project_type = stripslashes($rec['ProjectType']);
                $project_name = stripslashes($rec['ProjectName']);
                $team_size = stripslashes($rec['TeamSize']);
                $client_name = stripslashes($rec['ClientName']);
                $role = stripslashes($rec['Role']);
                $organisation = stripslashes($rec['Organisation']);
                $description = stripslashes($rec['Description']);
                $responsibilities = stripslashes($rec['Responsibilities']);
                $document_type = stripslashes($rec['DocumentType']);
                $status = stripslashes($rec['ProjectStatus']);
                $category = stripslashes($rec['Category']);
                $industry = stripslashes($rec['Industry']);
                $domain = stripslashes($rec['Domain']);
                $from_date = stripslashes($rec['FromDate']);
                $ref_name_1 = stripslashes($rec['ReferenceName']);
                $ref_email_1 = stripslashes($rec['ReferenceEmail']);
                $ref_mobile_1 = stripslashes($rec['ReferencePhone']);
                $to_date = stripslashes($rec['ToDate']);
                $ref_name_2 = stripslashes($rec['ReferenceName2']);
                $ref_email_2 = stripslashes($rec['ReferenceEmail2']);
                $ref_mobile_2 = stripslashes($rec['ReferencePhone2']);
                $notes = stripslashes($rec['Notes']);
                $from_date = $this->date_format_short($from_date);
                $to_date = $this->date_format_short($to_date);

                $reference_1 = '';
                if (!empty($ref_name_1)) {
                    $reference_1 = $ref_name_1;
                }
                if (!empty($ref_email_1)) {
                    $reference_1 .= ', ' . $ref_email_1;
                }
                if (!empty($ref_mobile_1)) {
                    $reference_1 .= ', ' . $ref_mobile_1;
                }

                $reference_2 = '';
                if (!empty($ref_name_2)) {
                    $reference_2 = $ref_name_2;
                }
                if (!empty($ref_email_2)) {
                    $reference_2 .= ', ' . $ref_email_2;
                }
                if (!empty($ref_mobile_2)) {
                    $reference_2 .= ', ' . $ref_mobile_2;
                }

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $task_loop_str = $this->get_project_task_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );
                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PROJECT-TYPE##',
                    $project_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PROJECT-NAME##',
                    $project_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TEAM-SIZE##',
                    $team_size,
                    $email_body,
                );
                $email_body = str_replace('##ROLE##', $role, $email_body);
                $email_body = str_replace(
                    '##CLIENT-NAME##',
                    $client_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORGANISATION##',
                    $organisation,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DESCRIPTION##',
                    $description,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RESPONSIBILITIES##',
                    $responsibilities,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##INDUSTRY##',
                    $industry,
                    $email_body,
                );
                $email_body = str_replace('##DOMAIN##', $domain, $email_body);
                $email_body = str_replace(
                    '##REFERENCE-1##',
                    $reference_1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REFERENCE-2##',
                    $reference_2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TASK-LOOP##',
                    $task_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_skills_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 17;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_SKILLS);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-professional-skills-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $skill_type = stripslashes($rec['SkillType']);
                $skill_name = stripslashes($rec['SkillName']);
                $from_date = stripslashes($rec['FromDate']);
                $to_date = stripslashes($rec['ToDate']);
                $proficiency = stripslashes($rec['Proficiency']);
                $document_type = stripslashes($rec['DocumentType']);
                $project_name = stripslashes($rec['ProjectName']);
                $organisation = stripslashes($rec['OrganisationName']);
                $category = stripslashes($rec['Category']);
                $address = stripslashes($rec['Address']);
                $notes = stripslashes($rec['Notes']);
                $tools = stripslashes($rec['Tools']);
                $version = stripslashes($rec['Version']);

                $from_date = $this->date_format_short($from_date);
                $to_date = $this->date_format_short($to_date);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SKILL-TYPE##',
                    $skill_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SKILL-NAME##',
                    $skill_name,
                    $email_body,
                );
                $email_body = str_replace('##TOOLS##', $tools, $email_body);
                $email_body = str_replace('##VERSION##', $version, $email_body);
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##PROFICIENCY##',
                    $proficiency,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PROJECT-NAME##',
                    $project_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORGANISATION##',
                    $organisation,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_apps_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $password_change_status,
        $addtext,
    ) {
        $record_type_id = 18;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_APPS);
        if (safe_count($qry ?? []) > 0) {
            if ($password_change_status == 'Required') {
                $email_template =
                    '../../templates/email-professional-apps-template.html';
            } else {
                $email_template =
                    '../../templates/email-professional-apps-template1.html';
            }
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $app_type = stripslashes($rec['AppType']);
                $app_name = stripslashes($rec['AppName']);
                $usage = stripslashes($rec['Usage']);
                $description = stripslashes($rec['Description']);
                $status = stripslashes($rec['AppStatus']);
                $document_type = stripslashes($rec['DocumentType']);
                $category = stripslashes($rec['Category']);
                $url = stripslashes($rec['URL']);
                $service_type = stripslashes($rec['ServiceType']);
                $username = stripslashes($rec['Username']);
                $password = stripslashes($rec['Password']);
                $alt_email = stripslashes($rec['AlternateEmail']);
                $alt_mobile = stripslashes($rec['AlternatePhone']);
                $password_change_status = stripslashes(
                    $rec['PasswordChangeStatus'],
                );
                $new_password_change_date = stripslashes(
                    $rec['NextPasswordChangeDate'],
                );
                $period = stripslashes($rec['Period']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##APP-TYPE##',
                    $app_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##APP-NAME##',
                    $app_name,
                    $email_body,
                );
                $email_body = str_replace('##USAGE##', $usage, $email_body);
                $email_body = str_replace(
                    '##DESCRIPTION##',
                    $description,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##URL##', $url, $email_body);
                $email_body = str_replace(
                    '##SERVICE-TYPE##',
                    $service_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##USERNAME##',
                    $username,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PASSWORD##',
                    $password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ALT-EMAIL##',
                    $alt_email,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ALT-MOBILE##',
                    $alt_mobile,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PASSWORD-CHANGE-STATUS##',
                    $password_change_status,
                    $email_body,
                );
                $email_body = str_replace(
                    '##NEXT-PASSWORD-CHANGE-DATE##',
                    $new_password_change_date,
                    $email_body,
                );
                $email_body = str_replace('##PERIOD##', $period, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_resume_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 38;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_RESUME);
        if (safe_count($rec ?? []) > 0) {
            $email_template =
                '../../templates/email-professional-resume-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $ResumeType = stripslashes($rec['ResumeType']);
                $Name = stripslashes($rec['Name']);
                $FromDate = stripslashes($rec['FromDate']);
                $ToDate = stripslashes($rec['ToDate']);
                $CurrentRole = stripslashes($rec['CurrentRole']);
                $ExpectedRole = stripslashes($rec['ExpectedRole']);
                $CurrentCTC = stripslashes($rec['CurrentCTC']);
                $FunctionalArea = stripslashes($rec['FunctionalArea']);
                $Industry = stripslashes($rec['Industry']);
                $ExpectedCTC = stripslashes($rec['ExpectedCTC']);
                $ExpectedPlace = stripslashes($rec['ExpectedPlace']);
                $KeySkills = stripslashes($rec['KeySkills']);
                $AlternateEmail = stripslashes($rec['AlternateEmail']);
                $Mobile = stripslashes($rec['Mobile']);
                $Summary = stripslashes($rec['Summary']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ResumeType##',
                    $ResumeType,
                    $email_body,
                );
                $email_body = str_replace('##Name##', $Name, $email_body);
                $email_body = str_replace(
                    '##FromDate##',
                    $FromDate,
                    $email_body,
                );
                $email_body = str_replace('##ToDate##', $ToDate, $email_body);
                $email_body = str_replace(
                    '##CurrentRole##',
                    $CurrentRole,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ExpectedRole##',
                    $ExpectedRole,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CurrentCTC##',
                    $CurrentCTC,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FunctionalArea##',
                    $FunctionalArea,
                    $email_body,
                );
                $email_body = str_replace(
                    '##Industry##',
                    $Industry,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ExpectedCTC##',
                    $ExpectedCTC,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ExpectedPlace##',
                    $ExpectedPlace,
                    $email_body,
                );
                $email_body = str_replace(
                    '##KeySkills##',
                    $KeySkills,
                    $email_body,
                );
                $email_body = str_replace(
                    '##AlternateEmail##',
                    $AlternateEmail,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##Mobile##', $Mobile, $email_body);
                $email_body = str_replace('##Summary##', $Summary, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_medicaltest_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 19;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_MEDMEDICALTEST);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-medical-test-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $user_id = stripslashes($rec['UserId']);
                $document_type = stripslashes($rec['DocumentType']);
                $test_type = stripslashes($rec['TestType']);
                $test_name = stripslashes($rec['TestName']);
                $patient_name = stripslashes($rec['PatientName']);
                $referred_by = stripslashes($rec['ReferredBy']);
                $reference_number = stripslashes($rec['ReferenceNumber']);
                $patient_name = stripslashes($rec['PatientName']);
                $referred_by = stripslashes($rec['ReferredBy']);
                $doctor_name = stripslashes($rec['DoctorName']);
                $doctor_address = stripslashes($rec['DoctorAddress']);
                $test_date = stripslashes($rec['TestDate']);
                $report_date = stripslashes($rec['ReportDate']);
                $report_summary = stripslashes($rec['ReportSummary']);
                $description = stripslashes($rec['DetailedDescription']);
                $diagnostic_center_name = stripslashes(
                    $rec['DiagnosticCenterName'],
                );
                $diagnostic_center_place = stripslashes(
                    $rec['DiagnosticCenterPlace'],
                );
                $diagnostic_center_address = stripslashes(
                    $rec['DiagnosticCenterAddress'],
                );
                $status = stripslashes($rec['Status']);
                $retest_date = stripslashes($rec['StatusDate']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $test_loop_str = $this->get_med_test_test_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TEST-TYPE##',
                    $test_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TEST-NAME##',
                    $test_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REF-NUM##',
                    $reference_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PATIENT-NAME##',
                    $patient_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REF-BY##',
                    $referred_by,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-NAME##',
                    $doctor_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-ADDRESS##',
                    $doctor_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TEST-DATE##',
                    $test_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REPORT-DATE##',
                    $report_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REPORT-SUMMARY##',
                    $report_summary,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DESCRIPTION##',
                    $description,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DIAG-NAME##',
                    $diagnostic_center_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DIAG-PLACE##',
                    $diagnostic_center_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DIAG-ADDRESS##',
                    $diagnostic_center_address,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##RETEST-DATE##',
                    $retest_date,
                    $email_body,
                );

                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TEST-LOOP##',
                    $test_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_med_test_test_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('MedMedicalTestRecords');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-medical-test-test.html';
                        $html_content = $this->read_file($print_template);

                        $record_id = $rec['RecordId'];
                        $parent_record_id = $rec['ParentRecordId'];
                        $test_type = stripslashes($rec['TestType']);
                        $test_name = stripslashes($rec['TestName']);
                        $test_date = stripslashes($rec['TestDate']);
                        $diagnostic_center_name = stripslashes(
                            $rec['DiagnosticCenterName'],
                        );
                        $diagnostic_center_place = stripslashes($rec['Place']);
                        $diagnostic_center_address = stripslashes(
                            $rec['Address'],
                        );
                        $report_date = stripslashes($rec['ReportDate']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Medical Test | $test_date | $diagnostic_center_name";

                        if ($document_id_arr == '-1') {
                            $attachments = $this->get_document_email_links(
                                23,
                                $record_id,
                            );
                        } elseif (
                            !empty($document_id_arr) &&
                            safe_count($document_id_arr ?? []) > 0
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                23,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##TEST-TYPE##',
                            $test_type,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TEST-NAME##',
                            $test_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TEST-DATE##',
                            $test_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DIAG-CENTER-NAME##',
                            $diagnostic_center_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##REPORT-DATE##',
                            $report_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##PLACE##',
                            $diagnostic_center_place,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ADDRESS##',
                            $diagnostic_center_address,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##HEADER-TITLE##',
                            $header_title,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );

                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }

    public function get_prescription_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 20;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_MEDPRESCRIPTION);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-medical-prescription-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $user_id = stripslashes($rec['UserId']);
                $prescription_type = stripslashes($rec['PrescriptionType']);
                $diesease_name = stripslashes($rec['DiseaseName']);
                $medicine_name = stripslashes($rec['MedicineName']);
                $medicine_type = stripslashes($rec['MedicineType']);
                $doctor_name = stripslashes($rec['DoctorName']);
                $doctor_address = stripslashes($rec['DoctorAddress']);
                $from_date = stripslashes($rec['FromDate']);
                $to_date = stripslashes($rec['ToDate']);
                $frequency1 = stripslashes($rec['Frequency']);
                $times1 = stripslashes($rec['Times']);
                $dose = stripslashes($rec['Dose']);
                $special_conditions = stripslashes($rec['SpecialConditions']);
                $symptom = stripslashes($rec['Symptom']);
                $usage_str = stripslashes($rec['Usage']);
                $notes = stripslashes($rec['Notes']);
                $patient_name = stripslashes($rec['PatientName']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $medicine_loop_str = $this->get_med_prescription_medicine_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PRESCRIPTION-TYPE##',
                    $prescription_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DISEASE-NAME##',
                    $diesease_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MEDICINE-NAME##',
                    $medicine_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MEDICINE-TYPE##',
                    $medicine_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-NAME##',
                    $doctor_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-ADDRESS##',
                    $doctor_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace('##USAGE##', $usage_str, $email_body);
                $email_body = str_replace('##DOSE##', $dose, $email_body);
                $email_body = str_replace(
                    '##FREQUENCY1##',
                    $frequency1,
                    $email_body,
                );
                $email_body = str_replace('##TIMES1##', $times1, $email_body);
                $email_body = str_replace(
                    '##SPECIAL-CONDITIONS##',
                    $special_conditions,
                    $email_body,
                );
                $email_body = str_replace('##SYMPTOM##', $symptom, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##PATIENT-NAME##',
                    $patient_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );

                $email_body = str_replace(
                    '##MEDICINE-LOOP##',
                    $medicine_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_med_prescription_prescription_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';

        $qry = "SELECT * FROM MedPrescriptionPrescription WHERE ParentRecordId = '$parent_record_id' AND UserId = '$user_id'";
        $res = $this->db->query($qry);
        $output_str = '';
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $rec) {
                $print_template =
                    '../../templates/email-medical-prescription-prescription.html';
                $html_content = $this->read_file($print_template);

                $record_id = $rec['RecordId'];
                $parent_record_id = $rec['ParentRecordId'];
                $medicine_name = stripslashes($rec['MedicineName']);
                $medicine_type = stripslashes($rec['MedicineType']);
                $doctor_name = stripslashes($rec['DoctorName']);
                $doctor_address = stripslashes($rec['DoctorAddress']);
                $from_date = stripslashes($rec['FromDate']);
                $to_date = stripslashes($rec['ToDate']);
                $frequency = stripslashes($rec['Frequency']);
                $times = stripslashes($rec['Times']);
                $dose = stripslashes($rec['Dose']);
                $special_conditions = stripslashes($rec['SpecialConditions']);
                $symptom = stripslashes($rec['Symptom']);
                $usage_str = stripslashes($rec['Usage']);
                $notes = stripslashes($rec['Notes']);
                $header_title = "Prescription | $medicine_name | $medicine_type";

                if ($document_id_arr == '-1') {
                    $attachments = $this->get_document_email_links(
                        25,
                        $record_id,
                    );
                } elseif (
                    safe_count($document_id_arr ?? []) > 0 &&
                    !empty($document_id_arr)
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        25,
                        $record_id,
                    );
                } else {
                    $attachments =
                        '<i>No documents are attached to this record</i>';
                }

                $html_content = str_replace(
                    '##MEDICINE-NAME##',
                    $medicine_name,
                    $html_content,
                );
                $html_content = str_replace(
                    '##MEDICINE-TYPE##',
                    $medicine_type,
                    $html_content,
                );
                $html_content = str_replace(
                    '##DOC-NAME##',
                    $doctor_name,
                    $html_content,
                );
                $html_content = str_replace(
                    '##DOC-ADDRESS##',
                    $doctor_address,
                    $html_content,
                );
                $html_content = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $html_content,
                );
                $html_content = str_replace(
                    '##TO-DATE##',
                    $to_date,
                    $html_content,
                );
                $html_content = str_replace(
                    '##FREQUENCY##',
                    $frequency,
                    $html_content,
                );
                $html_content = str_replace('##TIMES##', $times, $html_content);
                $html_content = str_replace(
                    '##SYMPTOM##',
                    $symptom,
                    $html_content,
                );
                $html_content = str_replace(
                    '##USAGE##',
                    $usage_str,
                    $html_content,
                );
                $html_content = str_replace('##DOSE##', $dose, $html_content);
                $html_content = str_replace(
                    '##SPECIAL-CONDITIONS##',
                    $special_conditions,
                    $html_content,
                );
                $html_content = str_replace('##NOTES##', $notes, $html_content);
                $html_content = str_replace(
                    '##HEADER-TITLE##',
                    $header_title,
                    $html_content,
                );
                $html_content = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $html_content,
                );
                $output_str .= $html_content;
            }
        }
        return $output_str;
    }

    public function get_med_prescription_medicine_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('MedPrescriptionMedicine');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-medical-prescription-medicine.html';
                        $html_content = $this->read_file($print_template);

                        $record_id = $rec['RecordId'];
                        $parent_record_id = $rec['ParentRecordId'];
                        $medicine_name = stripslashes($rec['MedicineName']);
                        $medicine_type = stripslashes($rec['MedicineType']);
                        $from_date = stripslashes($rec['FromDate']);
                        $to_date = stripslashes($rec['ToDate']);
                        $frequency = stripslashes($rec['Frequency']);
                        $times = stripslashes($rec['Times']);
                        $dose = stripslashes($rec['Dose']);
                        $special_conditions = stripslashes(
                            $rec['SpecialConditions'],
                        );
                        $usage_str = stripslashes($rec['Usage']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Medicine | $medicine_name | $medicine_type";

                        if ($document_id_arr == '-1') {
                            $this->get_document_email_links(24, $record_id);
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                24,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##MEDICINE-NAME##',
                            $medicine_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##MEDICINE-TYPE##',
                            $medicine_type,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##FROM-DATE##',
                            $from_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TO-DATE##',
                            $to_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##FREQUENCY##',
                            $frequency,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TIMES##',
                            $times,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##USAGE##',
                            $usage_str,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DOSE##',
                            $dose,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##SPECIAL-CONDITIONS##',
                            $special_conditions,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##HEADER-TITLE##',
                            $header_title,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );
                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }

    public function get_familyhealth_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 21;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_MEDFAMILY);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-medical-family-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $record_id = $rec['RecordId'];
                $disease_type = stripslashes($rec['DiseaseType']);
                $disease_name = stripslashes($rec['DiseaseName']);
                $reference_number = stripslashes($rec['ReferenceNumber']);
                $patient_name = stripslashes($rec['PatientName']);
                $patient_address = stripslashes($rec['PatientAddress']);
                $from_date = stripslashes($rec['FromDate']);
                $hospital_name = stripslashes($rec['HospitalName']);
                $hospital_address = stripslashes($rec['HospitalAddress']);
                $to_date = stripslashes($rec['ToDate']);
                $doctor_name = stripslashes($rec['DoctorName']);
                $doctor_address = stripslashes($rec['DoctorAddress']);
                $document_type = stripslashes($rec['DocumentType']);
                $status = stripslashes($rec['Status']);
                $treatment_type = stripslashes($rec['TreatmentType']);
                $notes = stripslashes($rec['Notes']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $patient_loop_str = $this->get_med_family_patient_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DISEASE-TYPE##',
                    $disease_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DISEASE-NAME##',
                    $disease_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REF-NUM##',
                    $reference_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PATIENT-NAME##',
                    $patient_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PATIENT-ADDRESS##',
                    $patient_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##HOSPITAL-NAME##',
                    $hospital_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##HOSPITAL-ADDRESS##',
                    $hospital_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TREATMENT-TYPE##',
                    $treatment_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCTOR-NAME##',
                    $doctor_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCTOR-ADDRESS##',
                    $doctor_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PATIENT-LOOP##',
                    $patient_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_healthinsurance_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 22;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_MEDHEALTHINSURANCE);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-medical-health-insurance-template.html';
            $email_body = $this->read_file($email_template);
            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $insurance_type = $rec['InsuranceType'];
                $policy_type = stripslashes($rec['PolicyType']);
                $policy_name = stripslashes($rec['PolicyName']);
                $policy_number = stripslashes($rec['PolicyNumber']);
                $from_date = stripslashes($rec['FromDate']);
                $insurance_name = stripslashes($rec['InsuranceName']);
                $insurance_address = stripslashes($rec['InsuranceAddress']);
                $to_date = stripslashes($rec['ToDate']);
                $covered_party = stripslashes($rec['CoveredParty']);
                $covered_amount = stripslashes($rec['CoveredAmount']);
                $category = stripslashes($rec['Category']);
                $status = stripslashes($rec['Status']);
                $coverage_type = stripslashes($rec['CoverageType']);
                $website_url = stripslashes($rec['WebsiteURL']);
                $login_name = stripslashes($rec['LoginUsername']);
                $login_password = stripslashes($rec['LoginPassword']);
                $beneficiary_name = stripslashes($rec['BeneficiaryName']);
                $relation = stripslashes($rec['Relation']);
                $tenure = stripslashes($rec['Tenure']);
                $tenure_amount = stripslashes($rec['TenureAmount']);
                $percentage_allocation = stripslashes(
                    $rec['PercentageAllocation'],
                );
                $notes = stripslashes($rec['Notes']);
                $currency = stripslashes($rec['Currency']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $beneficiary_loop_str = $this->get_med_insurance_beneficiary_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##INSURANCE-TYPE##',
                    $insurance_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-TYPE##',
                    $policy_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-NAME##',
                    $policy_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-NUMBER##',
                    $policy_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##INSURANCE-NAME##',
                    $insurance_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##INSURANCE-ADDRESS##',
                    $insurance_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##COVERED-PARTY##',
                    $covered_party,
                    $email_body,
                );
                $email_body = str_replace(
                    '##AMOUNT##',
                    $covered_amount,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##WEBSITE-URL##',
                    $website_url,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOGIN-USERNAME##',
                    $login_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LOGIN-PASSWORD##',
                    $login_password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##COVERAGE-TYPE##',
                    $coverage_type,
                    $email_body,
                );
                $email_body = str_replace('##TENURE##', $tenure, $email_body);
                $email_body = str_replace(
                    '##TENURE-AMOUNT##',
                    $tenure_amount,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BENEFICIARY-NAME##',
                    $beneficiary_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RELATION##',
                    $relation,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PERCENTAGE-OF-ALLOCATION##',
                    $percentage_allocation,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CURRENCY##',
                    $currency,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );

                $email_body = str_replace(
                    '##BENEFICIARY-LOOP##',
                    $beneficiary_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_legaldispute_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 28;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_LEGALDISPUTE);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-legal-dispute-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $dispute_type = $rec['DisputeType'];
                $party_name = stripslashes($rec['PartyName']);
                $party_address = stripslashes($rec['Address']);
                $reference_number = stripslashes($rec['ReferenceNumber']);
                $document_type = $rec['DocumentType'];
                $from_date = stripslashes($rec['FromDate']);
                $description = stripslashes($rec['Description']);
                $asset_name = stripslashes($rec['AssetName']);
                $court_name = stripslashes($rec['CourtName']);
                $asset_place = stripslashes($rec['AssetPlace']);
                $asset_address = stripslashes($rec['AssetAddress']);
                $lawyer_name = stripslashes($rec['LawyerName']);
                $lawyer_address = stripslashes($rec['LawyerAddress']);
                $lawyer_email = stripslashes($rec['LawyerEmail']);
                $contact_number = stripslashes($rec['ContactNumber']);
                $alt_contact_number = stripslashes($rec['AltContactNumber']);
                $category = stripslashes($rec['Category']);
                $status = stripslashes($rec['Status']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DISPUTE-TYPE##',
                    $dispute_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PARTY-NAME##',
                    $party_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PARTY-ADDRESS##',
                    $party_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REF-NUM##',
                    $reference_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DESCRIPTION##',
                    $description,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSET-NAME##',
                    $asset_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PLACE##',
                    $asset_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ADDRESS##',
                    $asset_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##COURT-NAME##',
                    $court_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LAWYER-NAME##',
                    $lawyer_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LAWYER-ADDRESS##',
                    $lawyer_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EMAIL##',
                    $lawyer_email,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CONTACT-NUM##',
                    $contact_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ALT-CONTACT-NUM##',
                    $alt_contact_number,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_ownershiptrnsfr_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 29;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_LEGALOWNERSHIPTRANSFER);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-legal-ownership-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $transfer_type = $rec['TransferType'];
                $asset_name = stripslashes($rec['AssetName']);
                $asset_place = stripslashes($rec['AssetPlace']);
                $asset_address = stripslashes($rec['AssetAddress']);
                $owner1 = $rec['Ownership1'];
                $owner1_address = stripslashes($rec['Ownership1Address']);
                $owner2 = stripslashes($rec['Ownership2']);
                $owner2_address = stripslashes($rec['Ownership2Address']);
                $rev_office_place = stripslashes($rec['RevenueOfficePlace']);
                $rev_office_address = stripslashes(
                    $rec['RevenueOfficeAddress'],
                );
                $from_date = stripslashes($rec['ValidFrom']);
                $duty_amount = stripslashes($rec['DutyAmount']);
                $chalan = stripslashes($rec['Chelan']);
                $dd = stripslashes($rec['DDNumber']);
                $bank_name = stripslashes($rec['BankName']);
                $bank_place = stripslashes($rec['BankPlace']);
                $bank_address = stripslashes($rec['BankAddress']);
                $receiver1 = stripslashes($rec['ReceiverParty1Name']);
                $receiver1_address = stripslashes(
                    $rec['ReceiverParty1Address'],
                );
                $receiver2 = stripslashes($rec['ReceiverParty2Name']);
                $receiver2_address = stripslashes(
                    $rec['ReceiverParty2Address'],
                );
                $receiver3 = stripslashes($rec['ReceiverParty3Name']);
                $receiver3_address = stripslashes(
                    $rec['ReceiverParty3Address'],
                );
                $category = stripslashes($rec['Category']);
                $status = stripslashes($rec['Status']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TRANSFER-TYPE##',
                    $transfer_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSET-NAME##',
                    $asset_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSET-PLACE##',
                    $asset_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSET-ADDRESS##',
                    $asset_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OWNERSHIP-1##',
                    $owner1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OWNERSHIP-1-ADDRESS##',
                    $owner1_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OWNERSHIP-2##',
                    $owner2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OWNERSHIP-2-ADDRESS##',
                    $owner2_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REV-OFFICE-PLACE##',
                    $rev_office_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REV-OFFICE-ADDRESS##',
                    $rev_office_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-FROM##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DUTY-AMOUNT##',
                    $duty_amount,
                    $email_body,
                );
                $email_body = str_replace('##CHELAN##', $chalan, $email_body);
                $email_body = str_replace('##DD##', $dd, $email_body);
                $email_body = str_replace(
                    '##RECEIVER-PARTY-1##',
                    $receiver1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIVER-PARTY-1-ADDRESS##',
                    $receiver1_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIVER-PARTY-2##',
                    $receiver2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIVER-PARTY-2-ADDRESS##',
                    $receiver2_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIVER-PARTY-3##',
                    $receiver3,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIVER-PARTY-3-ADDRESS##',
                    $receiver3_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BANK-NAME##',
                    $bank_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BANK-PLACE##',
                    $bank_place,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BANK-ADDRESS##',
                    $bank_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_finaccounts_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 30;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINFINANCIALACCOUNTS);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-financial-accounts-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $account_type = $rec['AccountType'];
                $organization_name = stripslashes($rec['OrganizationName']);
                $account_number = stripslashes($rec['AccountNumber']);
                $branch_name = stripslashes($rec['BranchName']);
                $branch_address = stripslashes($rec['BranchAddress']);
                $customer_number = stripslashes($rec['CustomerNumber']);
                $acholder_name = stripslashes($rec['ACHolderName']);
                $acholder_address = stripslashes($rec['ACHolderAddress']);
                $from_date = stripslashes($rec['ValidFrom']);
                $website_url = stripslashes($rec['WebsiteUrl']);
                $username = stripslashes($rec['Username']);
                $website_password = stripslashes($rec['Password']);
                $trans_password = stripslashes($rec['TransPassword']);
                $document_type = stripslashes($rec['DocumentType']);
                $service_type = stripslashes($rec['ServiceType']);
                $category = stripslashes($rec['Category']);
                $account_status = stripslashes($rec['AccountStatus']);
                $notes = stripslashes($rec['Notes']);
                $ifsc = stripslashes($rec['Ifsc']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACCOUNT-TYPE##',
                    $account_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACCOUNT-NUMBER##',
                    $account_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORGANIZATION-NAME##',
                    $organization_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BRANCH-NAME##',
                    $branch_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BRANCH-ADDRESS##',
                    $branch_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CUSTOMER-NUMBER##',
                    $customer_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACHOLDER-NAME##',
                    $acholder_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACHOLDER-ADDRESS##',
                    $acholder_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-FROM##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##WEBSITE-URL##',
                    $website_url,
                    $email_body,
                );
                $email_body = str_replace(
                    '##USERNAME##',
                    $username,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PASSWORD##',
                    $website_password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TRANS-PASSWORD##',
                    $trans_password,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SERVICE-TYPE##',
                    $service_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ACCOUNT-STATUS##',
                    $account_status,
                    $email_body,
                );

                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace('##IFSC##', $ifsc, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_finassets_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 31;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINASSET);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-financial-assets-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $asset_type = $rec['AssetType'];
                $asset_name = stripslashes($rec['AssetName']);
                $ownership_type = stripslashes($rec['OwnershipType']);
                $reference_number = stripslashes($rec['ReferenceNo']);
                $document_type = stripslashes($rec['DocumentType']);
                $place = stripslashes($rec['Place']);
                $address = stripslashes($rec['Address']);
                $from_date = stripslashes($rec['ValidFrom']);
                $to_date = stripslashes($rec['ValidTo']);
                $present_value = stripslashes($rec['PresentValue']);
                $expected_value = stripslashes($rec['ExpectedValue']);
                $liability = stripslashes($rec['Liability']);
                $policy_names = stripslashes($rec['PolicyNames']);
                $liability_number = stripslashes($rec['LiabilityNo']);
                $insurance_number = stripslashes($rec['InsuranceNo']);
                $category = stripslashes($rec['Category']);
                $status = stripslashes($rec['Status']);
                $warrenty_number = stripslashes($rec['WarrantyNo']);
                $receipt_number = stripslashes($rec['ReceiptNo']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSET-TYPE##',
                    $asset_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSET-NAME##',
                    $asset_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##OWNERSHIP-TYPE##',
                    $ownership_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REF-NUM##',
                    $reference_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##PLACE##', $place, $email_body);
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##VALID-FROM##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-TO##',
                    $to_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PRESENT-VALUE##',
                    $present_value,
                    $email_body,
                );
                $email_body = str_replace(
                    '##EXPECTED-VALUE##',
                    $expected_value,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LIABILITY-NUM##',
                    $liability_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##INSURANCE-NUM##',
                    $insurance_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LIABILITY-NAMES##',
                    $liability,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-NAMES##',
                    $policy_names,
                    $email_body,
                );
                $email_body = str_replace(
                    '##WARRENTY-NUM##',
                    $warrenty_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIPT-NUM##',
                    $receipt_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_finrevenues_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 32;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINREVENUE);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-financial-revenues-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $record_id = $rec['RecordId'];
                $revenue_type = $rec['RevenueType'];
                $item_name = stripslashes($rec['ItemName']);
                $from_date = stripslashes($rec['FromDate']);
                $source = stripslashes($rec['Source']);
                $address = stripslashes($rec['Address']);
                $to_date = stripslashes($rec['ToDate']);
                $term = stripslashes($rec['Term']);
                $assessment_year = stripslashes($rec['AssessmentYear']);
                $qry = "select * from revenue where UserId='$user_id' AND ParentRecordId='$record_id'";
                $res = $this->db->query($qry);
                $amount1 = 0;
                foreach ($res->result_array() as $rec1) {
                    $amount1 += $rec1['Amount'];
                }
                if ($term == 'Once' || $term == 'Yearly') {
                    $amount = stripslashes($rec['Amount']);
                } else {
                    $amount = $amount1;
                }
                $category = stripslashes($rec['Category']);
                $document_type = stripslashes($rec['DocumentType']);
                $notes = stripslashes($rec['Notes']);
                $due_date = stripslashes($rec['DueDate']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $medicine_loop_str = $this->get_fin_revenue_related_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REVENUE-TYPE##',
                    $revenue_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ITEM-NAME##',
                    $item_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace('##AMOUNT##', $amount, $email_body);
                $email_body = str_replace('##SOURCE##', $source, $email_body);
                $email_body = str_replace('##ADDRESS##', $address, $email_body);
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOCUMENT-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##TERM##', $term, $email_body);
                $email_body = str_replace(
                    '##ASSESSMENT-YEAR##',
                    $assessment_year,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DUEDATE##',
                    $due_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MEDICINE-LOOP##',
                    $medicine_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_fin_revenue_related_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('revenue');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-financial-revenues-template1.html';
                        $html_content = $this->read_file($print_template);

                        $record_id = $rec['RecordId'];

                        $parent_record_id = $rec['ParentRecordId'];
                        $revenue_date = stripslashes($rec['RevenueDate']);
                        $amount = stripslashes($rec['Amount']);
                        $document_type = stripslashes($rec['DocumentType']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Income | $revenue_date | $amount";

                        if ($document_id_arr == '-1') {
                            $this->get_document_email_links(41, $record_id);
                        } elseif (
                            !empty($document_id_arr) &&
                            safe_count($document_id_arr ?? []) > 0
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                41,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##REVENUE-DATE##',
                            $revenue_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##AMOUNT##',
                            $amount,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DOC-TYPE##',
                            $document_type,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##HEADER-TITLE##',
                            $header_title,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );
                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }

    public function get_fincards_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $card_type,
        $usage_type,
        $addtext,
    ) {
        $record_type_id = 33;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINCARDS);
        if (safe_count($qry ?? []) > 0) {
            if (
                ($card_type == 'Credit' ||
                    $card_type == 'Others' ||
                    $card_type == '') &&
                $usage_type == 'Joint'
            ) {
                $email_template =
                    '../../templates/email-financial-cards-template.html';
            } elseif (
                ($card_type == 'Credit' ||
                    $card_type == 'Others' ||
                    $card_type == '') &&
                ($usage_type == 'Self' || $usage_type == 'Others')
            ) {
                $email_template =
                    '../../templates/email-financial-cards-template1.html';
            } elseif (
                ($card_type == 'Debit' || $card_type == 'Forex') &&
                $usage_type == 'Joint'
            ) {
                $email_template =
                    '../../templates/email-financial-cards-template2.html';
            } elseif (
                ($card_type == 'Debit' || $card_type == 'Forex') &&
                ($usage_type == 'Self' || $usage_type == 'Others')
            ) {
                $email_template =
                    '../../templates/email-financial-cards-template3.html';
            } elseif (
                ($card_type == 'Discount' || $card_type == 'Shopping') &&
                $usage_type == 'Joint'
            ) {
                $email_template =
                    '../../templates/email-financial-cards-template4.html';
            } else {
                $email_template =
                    '../../templates/email-financial-cards-template5.html';
            }
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $card_type = $rec['CardType'];
                $service_provider = stripslashes($rec['ServiceProviderName']);
                $card_number = stripslashes($rec['CardNumber']);
                $card_provider = stripslashes($rec['CardProvider']);
                $name_on_card = stripslashes($rec['NameOnCard']);
                $from_date = stripslashes($rec['ValidFrom']);
                $billing_address = stripslashes($rec['BillingAddress']);
                $to_date = stripslashes($rec['ValidTo']);
                $cvv = stripslashes($rec['CVV']);
                $pin = stripslashes($rec['Pin']);
                $billing_date = stripslashes($rec['BillingDate']);
                $payment_date = stripslashes($rec['PaymentDate']);
                $usage_type = stripslashes($rec['UsageType']);
                $category = stripslashes($rec['Category']);
                $number_of_users = stripslashes($rec['NumberOfUsers']);
                $user_2_name = stripslashes($rec['User2Name']);
                $user_3_name = stripslashes($rec['User3Name']);
                $status = stripslashes($rec['Status']);
                $notes = stripslashes($rec['Notes']);
                $due_date = stripslashes($rec['DueDate']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CARD-TYPE##',
                    $card_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##SERVICE-PROVIDER-NAME##',
                    $service_provider,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CARD-NUMBER##',
                    $card_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CARD-PROVIDER##',
                    $card_provider,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BILLING-ADDRESS##',
                    $billing_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##NAME-ON-CARD##',
                    $name_on_card,
                    $email_body,
                );
                $email_body = str_replace('##CVV##', $cvv, $email_body);
                $email_body = str_replace('##PIN##', $pin, $email_body);
                $email_body = str_replace(
                    '##VALID-FROM##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##VALID-TO##',
                    $to_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BILLING-DATE##',
                    $billing_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PAYMENT-DATE##',
                    $payment_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##USER-TYPE##',
                    $usage_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##NUM-USERS##',
                    $number_of_users,
                    $email_body,
                );
                $email_body = str_replace(
                    '##USER-2-NAME##',
                    $user_2_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##USER-3-NAME##',
                    $user_3_name,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DUEDATE##',
                    $due_date,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_finliability_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 34;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINLIABILITY);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-financial-liability-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $liability_type = $rec['LiabilityType'];
                $liability_name = stripslashes($rec['LiabilityName']);
                $reference_number = stripslashes($rec['ReferenceNumber']);
                $party_name = stripslashes($rec['PartyName']);
                $party_address = stripslashes($rec['Address']);
                $from_date = stripslashes($rec['FromDate']);
                $principal_amount = stripslashes($rec['PrincipalAmount']);
                $rate_type = stripslashes($rec['RateType']);
                $to_date = stripslashes($rec['ToDate']);
                $emi = stripslashes($rec['EMI']);
                $duration = stripslashes($rec['Duration']);
                $reset_date = stripslashes($rec['ResetDate']);
                $tenure = stripslashes($rec['Tenure']);
                $interest_rate = stripslashes($rec['InterestRate']);
                $category = stripslashes($rec['Category']);
                $document_type = stripslashes($rec['DocumentType']);
                $status = stripslashes($rec['Status']);
                $notes = stripslashes($rec['Notes']);
                $due_date = stripslashes($rec['DueDate']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LIABILITY-TYPE##',
                    $liability_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##LIABILITY-NAME##',
                    $liability_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##REFERENCE-NUMBER##',
                    $reference_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PARTY-NAME##',
                    $party_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##ADDRESS##',
                    $party_address,
                    $email_body,
                );
                $email_body = str_replace('##EMI##', $emi, $email_body);
                $email_body = str_replace(
                    '##DURATION##',
                    $duration,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PRINCIPAL-AMOUNT##',
                    $principal_amount,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RATE-TYPE##',
                    $rate_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RESET-DATE##',
                    $reset_date,
                    $email_body,
                );
                $email_body = str_replace('##TENURE##', $tenure, $email_body);
                $email_body = str_replace(
                    '##INTEREST##',
                    $interest_rate,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##DOC-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DUEDATE##',
                    $due_date,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_finpayment_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
        $sub_id_arr,
    ) {
        $record_type_id = 35;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINPAYMENT);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-financial-payments-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $user_id = $rec['UserId'];
                $record_id = $rec['RecordId'];
                $payment_type = $rec['PaymentType'];
                $item_name = stripslashes($rec['ItemName']);
                $from_date = stripslashes($rec['FromDate']);
                $receiver_name = stripslashes($rec['ReceiverName']);
                $address = stripslashes($rec['Address']);
                $to_date = stripslashes($rec['ToDate']);
                $term = stripslashes($rec['Term']);
                $assessment_year = stripslashes($rec['AssessmentYear']);

                $qry = "select * from payments where UserId='$user_id' AND ParentRecordId='$record_id'";
                $res = $this->db->query($qry);
                $amount1 = 0;
                foreach ($res->result_array() as $rec1) {
                    $amount1 += $rec1['Amount'];
                }
                if ($term == 'Once' || $term == 'Yearly') {
                    $amount = stripslashes($rec['Amount']);
                } else {
                    $amount = $amount1;
                }
                $category = stripslashes($rec['Category']);
                $document_type = stripslashes($rec['DocumentType']);
                $notes = stripslashes($rec['Notes']);
                $due_date = stripslashes($rec['DueDate']);

                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }
                $medicine_loop_str = $this->get_fin_payment_related_html(
                    $document_id_arr,
                    $user_id,
                    $record_id,
                    $sub_id_arr,
                );

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PAYMENT-TYPE##',
                    $payment_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ITEM-NAME##',
                    $item_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace('##AMOUNT##', $amount, $email_body);
                $email_body = str_replace(
                    '##RECEIVER-NAME##',
                    $receiver_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RECEIVER-ADDRESS##',
                    $address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace('##TERM##', $term, $email_body);
                $email_body = str_replace(
                    '##ASSESSEMENT-YEAR##',
                    $assessment_year,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DUEDATE##',
                    $due_date,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MEDICINE-LOOP##',
                    $medicine_loop_str,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_fin_payment_related_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('payments');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-financial-payments-template1.html';
                        $html_content = $this->read_file($print_template);

                        $record_id = $rec['RecordId'];

                        $parent_record_id = $rec['ParentRecordId'];
                        $payment_date = stripslashes($rec['PaymentDate']);
                        $amount = stripslashes($rec['Amount']);
                        $document_type = stripslashes($rec['DocumentType']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Expense | $payment_date | $amount";

                        if ($document_id_arr == '-1') {
                            $this->get_document_email_links(39, $record_id);
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                39,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##PAYMENT-DATE##',
                            $payment_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##AMOUNT##',
                            $amount,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DOC-TYPE##',
                            $document_type,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##HEADER-TITLE##',
                            $header_title,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );
                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }

    public function get_fintax_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $addtext,
    ) {
        $record_type_id = 36;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FINTAX);
        if (safe_count($qry ?? []) > 0) {
            $email_template =
                '../../templates/email-financial-tax-template.html';
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $tax_doc_type = $rec['TaxDocumentType'];
                $assessment_year = stripslashes($rec['AssessmentYear']);
                $tax_item_type = stripslashes($rec['TaxItemType']);
                $item_name = stripslashes($rec['ItemName']);
                $date = stripslashes($rec['Date']);
                $place = stripslashes($rec['Place']);
                $income = stripslashes($rec['Income']);
                $tax_amount = stripslashes($rec['TaxAmount']);
                $max_tax_benefit = stripslashes($rec['MaxTaxBenefit']);
                $document_type = stripslashes($rec['DocumentType']);
                $applicable_section = stripslashes($rec['ApplicableSection']);
                $applicability = stripslashes($rec['Applicability']);
                $from_date = stripslashes($rec['FromDate']);
                $org_name = stripslashes($rec['OrganisationName']);
                $to_date = stripslashes($rec['ToDate']);
                $org_address = stripslashes($rec['OrganisationAddress']);
                $category = stripslashes($rec['Category']);
                $notes = stripslashes($rec['Notes']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TAX-DOC-TYPE##',
                    $tax_doc_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ASSESSMENT-YEAR##',
                    $assessment_year,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TAX-ITEM-TYPE##',
                    $tax_item_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ITEM-NAME##',
                    $item_name,
                    $email_body,
                );
                $email_body = str_replace('##DATE##', $date, $email_body);
                $email_body = str_replace('##PLACE##', $place, $email_body);
                $email_body = str_replace(
                    '##DOC-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace(
                    '##APPLICABLE-SECTION##',
                    $applicable_section,
                    $email_body,
                );
                $email_body = str_replace(
                    '##APPLICABILITY##',
                    $applicability,
                    $email_body,
                );
                $email_body = str_replace('##INCOME##', $income, $email_body);
                $email_body = str_replace(
                    '##TAX-AMOUNT##',
                    $tax_amount,
                    $email_body,
                );
                $email_body = str_replace(
                    '##MAX-TAX-BENEFIT##',
                    $max_tax_benefit,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##ORG-NAME##',
                    $org_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ORG-ADDRESS##',
                    $org_address,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function get_fininsurance_select(
        $document_id_arr,
        $record_id,
        $table_bg,
        $tr_bg,
        $insurance_type,
        $addtext,
    ) {
        $record_type_id = 37;
        $email_body = '';
        $this->mongodb->where(['RecordId' => mongo_id($record_id)]);
        $qry = $this->mongodb->get(TBL_FININSURANCE);
        if (safe_count($qry ?? []) > 0) {
            if ($insurance_type == 'Life') {
                $email_template =
                    '../../templates/email-financial-insurance-template.html';
            } else {
                $email_template =
                    '../../templates/email-financial-insurance-template1.html';
            }
            $email_body = $this->read_file($email_template);

            foreach ($qry as $rec) {
                $record_id = $rec['RecordId'];
                $insurance_type = $rec['InsuranceType'];
                $policy_name = stripslashes($rec['PolicyName']);
                $policy_type = stripslashes($rec['PolicyType']);
                $policy_number = stripslashes($rec['PolicyNumber']);
                $insurance_company = stripslashes($rec['InsuranceCompany']);
                $from_date = stripslashes($rec['FromDate']);
                $issuer_name = stripslashes($rec['IssuerName']);
                $to_date = stripslashes($rec['ToDate']);
                $agent_number = stripslashes($rec['AgentNumber']);
                $agent_name = stripslashes($rec['AgentName']);
                $document_type = stripslashes($rec['DocumentType']);
                $tenure = stripslashes($rec['Tenure']);
                $tenure_amount = stripslashes($rec['TenureAmount']);
                $status = stripslashes($rec['Status']);
                $total_value = stripslashes($rec['TotalValue']);
                $claim_number = stripslashes($rec['ClaimNumber']);
                $claim_amount = stripslashes($rec['ClaimAmount']);
                $beneficiary_name_1 = stripslashes($rec['BeneficiaryName1']);
                $relationship_1 = stripslashes($rec['Relationship1']);
                $percent_allocation_1 = stripslashes(
                    $rec['PercentAllocation1'],
                );
                $beneficiary_name_2 = stripslashes($rec['BeneficiaryName2']);
                $relationship_2 = stripslashes($rec['Relationship2']);
                $percent_allocation_2 = stripslashes(
                    $rec['PercentAllocation2'],
                );
                $category = stripslashes($rec['Category']);
                $notes = stripslashes($rec['Notes']);
                $due_date = stripslashes($rec['DueDate']);
                if (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr(
                        $document_id_arr,
                        $record_type_id,
                        $record_id,
                    );
                } else {
                    $attachments = 'No Attachments';
                }

                $email_body = str_replace(
                    '##ADD-TEXT##',
                    $addtext,
                    $email_body,
                );
                $email_body = str_replace(
                    '##INSURANCE-TYPE##',
                    $insurance_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-NAME##',
                    $policy_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-TYPE##',
                    $policy_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##POLICY-NUMBER##',
                    $policy_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##INSURANCE-COMPANY##',
                    $insurance_company,
                    $email_body,
                );
                $email_body = str_replace(
                    '##FROM-DATE##',
                    $from_date,
                    $email_body,
                );
                $email_body = str_replace('##TO-DATE##', $to_date, $email_body);
                $email_body = str_replace(
                    '##ISSUER-NAME##',
                    $issuer_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##AGENT-NUMBER##',
                    $agent_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##AGENT-NAME##',
                    $agent_name,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DOC-TYPE##',
                    $document_type,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CATEGORY##',
                    $category,
                    $email_body,
                );
                $email_body = str_replace('##TENURE##', $tenure, $email_body);
                $email_body = str_replace(
                    '##TENURE-AMOUNT##',
                    $tenure_amount,
                    $email_body,
                );
                $email_body = str_replace('##STATUS##', $status, $email_body);
                $email_body = str_replace(
                    '##TOTAL-VALUE##',
                    $total_value,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CLAIM-NUMBER##',
                    $claim_number,
                    $email_body,
                );
                $email_body = str_replace(
                    '##CLAIM-AMOUNT##',
                    $claim_amount,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BENEFICIARY-1##',
                    $beneficiary_name_1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RELATION-1##',
                    $relationship_1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PERCENT-ALLOCATION-1##',
                    $percent_allocation_1,
                    $email_body,
                );
                $email_body = str_replace(
                    '##BENEFICIARY-2##',
                    $beneficiary_name_2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##RELATION-2##',
                    $relationship_2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##PERCENT-ALLOCATION-2##',
                    $percent_allocation_2,
                    $email_body,
                );
                $email_body = str_replace(
                    '##ATTACHMENTS##',
                    $attachments,
                    $email_body,
                );
                $email_body = str_replace('##NOTES##', $notes, $email_body);
                $email_body = str_replace(
                    '##TABLE_BGCOLOR##',
                    $table_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##TR_BGCOLOR##',
                    $tr_bg,
                    $email_body,
                );
                $email_body = str_replace(
                    '##DUEDATE##',
                    $due_date,
                    $email_body,
                );
            }
        }
        return $email_body;
    }

    public function read_file($filename)
    {
        if (file_exists($filename)) {
            $handle = fopen($filename, 'r');
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            return $contents;
        } else {
            return '';
        }
    }

    public function get_document_email_links($record_type_id, $record_id)
    {
        ob_start();

        $qry =
            'SELECT * FROM ' .
            TBL_DOCUMENTS .
            " WHERE RecordTypeId = '$record_type_id' AND RecordId = '$record_id'";
        $res = $this->db->query($qry);

        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $rec) {

                $document_id = $rec['DocumentId'];

                $user_id = $rec['UserId'];
                $file_type = $rec['FileType'];
                $doc_path = $rec['DocumentPath'];
                $doc_tag = $rec['Notes'];

                $filename = '../..' . $doc_path;
                $file_tag = strtolower(substr(strstr($filename, '-'), 1));
                $file_tag = substr($file_tag, '0', '15');
                if (empty($doc_tag)) {
                    $doc_tag = "$file_tag";
                }

                $doc_icon =
                    'https://www.publishat.com/' .
                    $this->get_document_icon($file_type);
                $key = $user_id . '###' . $document_id . '###email-attachment';
                $doc_link_url =
                    'https://www.publishat.com/mobile_ws/GlobalController/viewattachment?key=' .
                    $this->encript($key);
                ?>
      <a target="_blank" href="<?= $doc_link_url ?>"><img src="<?= $doc_icon ?>" width="20" height="20" border="0" align="absmiddle" /></a>&nbsp;
            <a target="_blank" href="<?= $doc_link_url ?>"><?= strtoupper(
    $doc_tag,
) ?></a><?php
            }
        } else {
            echo '<i>No documents are attached to this record</i>';
        }
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function get_document_email_links_by_id_arr(
        $document_id_arr,
        $record_type_id,
        $record_id,
    ) {
        ob_start();
        if (safe_count($document_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($document_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($record_id),
                    'DocumentId' => mongo_id($document_id_arr[$i]),
                ]);
                $qry = $this->mongodb->get('fs.files');

                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {

                        $document_id = $rec['DocumentId'];
                        $user_id = $rec['UserId'];
                        $file_type = $rec['FileType'];
                        $doc_path = $rec['DocumentPath'];
                        $doc_tag = $rec['Notes'];
                        $filename = $rec['filename'];
                        $fid = $rec['_id'];
                        if (empty($filename)) {
                            $filename = basename($doc_path);
                            $filename = substr(
                                $filename,
                                strpos($filename, '-') + 1,
                            );
                        }

                        if (empty($doc_tag)) {
                            $doc_tag = "$filename";
                        }
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $doc_icon =
                            'https://www.publishat.com/' .
                            $this->get_document_icon($ext);
                        $key =
                            $user_id .
                            '###' .
                            $document_id .
                            '###email-attachment';
                        $doc_link_url =
                            'https://www.publishat.com/mobile_ws/GlobalController/viewattachment?key=' .
                            $this->encript($key);
                        ?>
        <a target="_blank" href="https://www.publishat.com/digital/en/web/docviewer?fid=<?= $fid ?>&type=<?= strtolower(
    $ext,
) ?>"><img src="<?= $doc_icon ?>" width="20" height="20" border="0" align="absmiddle" /></a>&nbsp;
        <a target="_blank" href="https://www.publishat.com/digital/en/web/docviewer?fid=<?= $fid ?>&type=<?= strtolower(
    $ext,
) ?>"><?= strtoupper($filename) ?></a><?php
                    }
                }
            }
        } else {
            echo '<i>No documents are attached to this record</i>';
        }
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function get_document_icon($file_type)
    {
        $file_type = strtolower($file_type);
        switch ($file_type) {
            case 'pdf':
                $icon = 'graphics/icon_pdf.png';
                break;
            case 'doc':
                $icon = 'graphics/icon_doc.png';
                break;
            case 'docx':
                $icon = 'graphics/icon_doc.png';
                break;
            case 'jpg':
                $icon = 'graphics/icon_jpg.png';
                break;
            case 'jpe':
                $icon = 'graphics/icon_jpg.png';
                break;
            case 'jpeg':
                $icon = 'graphics/icon_jpg.png';
                break;
            case 'gif':
                $icon = 'graphics/icon_gif.png';
                break;
            case 'png':
                $icon = 'graphics/icon_png.png';
                break;
            case 'txt':
                $icon = 'graphics/icon_txt.png';
                break;
            case 'xls':
                $icon = 'graphics/icon_xls.png';
                break;
            case 'xlsx':
                $icon = 'graphics/icon_xls.png';
                break;
            case 'xps':
                $icon = 'graphics/icon_xps.png';
                break;
            case 'zip':
                $icon = 'graphics/icon_zip.png';
                break;
            case 'rar':
                $icon = 'graphics/icon_rar.png';
                break;
            case 'ppt':
                $icon = 'graphics/icon_ppt.png';
                break;
            default:
                $icon = 'graphics/icon_pdf.png';
                break;
        }
        return $icon;
    }

    public function encript($value)
    {
        $skey = 'hserus$#@!^&*()-';
        if (!$value) {
            return false;
        }
        $text = $value;

        $crypttext = rijndael256_ecb_encrypt_raw($skey, $text);
        return trim($this->safe_b64encode($crypttext));
    }

    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        return $data;
    }

    public function phpmail_nocc(
        $from_email,
        $to_email,
        $subject,
        $message,
        $type = 'html',
    ) {
        $this->load->library('email');
        $config = [
            'protocol' => protocol,
            'smtp_host' => smtp_host,
            'smtp_port' => smtp_port,
            'smtp_user' => smtp_user,
            'smtp_pass' => smtp_pass,
            'mailpath' => mailpath,
            'charset' => charset,
            'wordwrap' => wordwrap,
        ];

        $this->email->initialize($config);
        $this->email->set_mailtype('html');
        $this->email->set_newline("\r\n");

        $this->email->to($to_email);
        if ($cc) {
            $this->email->cc($cc);
        }

        $this->email->from(smtp_user);
        $this->email->subject("$subject");
        $this->email->message($message);

        if ($this->email->send()) {
        } else {
            log_message(
                'debug',
                'Email Error Response: ' .
                    json_encode($this->email->print_debugger()),
            );

            return $this->email->print_debugger();
        }
    }

    public function date_format_short($date)
    {
        if (!empty($date)) {
            $date = str_replace('/', '-', $date);
            $date = date('d F Y', strtotime($date));
        }
        return $date;
    }

    public function get_med_test_test_html1(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $path,
    ) {
        $qry = "SELECT * FROM MedMedicalTestRecords WHERE ParentRecordId = '$parent_record_id' AND UserId = '$user_id'";
        $res = $this->db->query($qry);
        $output_str = '';
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $rec) {
                $record_id = $rec['RecordId'];
                $parent_record_id = $rec['ParentRecordId'];
                if ($document_id_arr == '-1') {
                    $attachments = $this->get_document_email_links1(
                        23,
                        $record_id,
                    );
                } elseif (
                    !empty($document_id_arr) &&
                    safe_count($document_id_arr ?? []) > 0
                ) {
                    $attachments = $this->get_document_email_links_by_id_arr1(
                        $document_id_arr,
                        23,
                        $record_id,
                        $path,
                    );
                }
            }
        }
        return $output_str;
    }

    public function get_document_email_links1(
        $record_type_id,
        $record_id,
        $path,
    ) {
        ob_start();

        $qry = "SELECT * FROM Documents WHERE RecordTypeId = '$record_type_id' AND RecordId = '$record_id'";
        $res = $this->db->query($qry);

        if ($res->num_rows() > 0) {
            $kartname = $_POST['kart'];
            $kartname1 = $_POST['kart1'];
            if ($kartname1) {
                $kart_name = $_POST['kart1'];
            } else {
                $kart_name = $_POST['kart'];
            }
            foreach ($res->result_array() as $rec) {
                $document_id = $rec['DocumentId'];
                $user_id = $rec['UserId'];
                $file_type = $rec['FileType'];
                $doc_path = $rec['DocumentPath'];

                if (empty($rec['Notes'])) {
                    $doc_tag = 'No TAG';
                } else {
                    $doc_tag = $rec['Notes'];
                }

                $qry1 = "Insert into kart(DocumentId,UserId,KartName,DocumentPath,FileType,Notes,Path) values ('$document_id','$user_id','$kart_name','$doc_path','$file_type','$doc_tag','$path')";
                $res1 = $this->db->query($qry1);
            }
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function get_document_email_links_by_id_arr1(
        $document_id_arr,
        $record_type_id,
        $record_id,
        $path,
    ) {
        ob_start();

        if (safe_count($document_id_arr ?? []) > 0) {
            $$kartname = $_POST['kart'];
            $kartname1 = $_POST['kart1'];
            if ($kartname1) {
                $kart_name = $_POST['kart1'];
            } else {
                $kart_name = $_POST['kart'];
            }
            $doc_id_str = implode(',', $document_id_arr);

            $qry = "SELECT * FROM Documents 
        WHERE RecordTypeId = '$record_type_id' 
        AND RecordId = '$record_id'
        AND DocumentId IN ($doc_id_str)";
            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {
                foreach ($res->result_array() as $rec) {
                    $document_id = $rec['DocumentId'];
                    $user_id = $rec['UserId'];
                    $file_type = $rec['FileType'];
                    $doc_path = $rec['DocumentPath'];
                    $doc_tag = $rec['Notes'];
                    if (empty($rec['Notes'])) {
                        $doc_tag = 'NO TAG';
                    } else {
                        $doc_tag = $rec['Notes'];
                    }

                    $qry2 = "Insert into kart(DocumentId,UserId,KartName,DocumentPath,FileType,Notes,Path) values ('$document_id','$user_id','$kart_name','$doc_path','$file_type','$doc_tag','$path')";
                    $res2 = $this->db->query($qry2);
                }
            } else {
                echo '<i>No documents are attached to this record</i>';
            }
        } else {
            echo '<i>No documents are attached to this record</i>';
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function get_project_task_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('projectinclude');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-professional-projects-task.html';
                        $html_content = $this->read_file($print_template);
                        $record_id = $rec['RecordId'];
                        $task_name = stripslashes($rec['TaskName']);
                        $duration = stripslashes($rec['Duration']);
                        $fromdate = stripslashes($rec['fromdate']);
                        $status = stripslashes($rec['Status']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Projects | Task | $task_name";

                        if ($document_id_arr == '-1') {
                            $attachments = $this->get_document_email_links(
                                45,
                                $record_id,
                            );
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                45,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##TASK-NAME##',
                            $task_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##STATUS##',
                            $status,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##FROM-DATE##',
                            $fromdate,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DURATION##',
                            $duration,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );

                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }

    public function get_ug_marksmemo_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('UndergraduateSub');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-academic-ug-marksmemo.html';
                        $html_content = $this->read_file($print_template);
                        $record_id = $rec['RecordId'];
                        $academic_year = stripslashes($rec['AcademicYear']);
                        $term = stripslashes($rec['Term']);
                        $yop = stripslashes($rec['YearOfPassing']);
                        $marks = stripslashes($rec['Marks']);
                        $max_marks = stripslashes($rec['MaxMarks']);
                        $grade = stripslashes($rec['Grade']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "UG | MarksMemo | $yop";
                        if ($document_id_arr == '-1') {
                            $attachments = $this->get_document_email_links(
                                43,
                                $record_id,
                            );
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                43,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }
                        $html_content = str_replace(
                            '##ACADEMIC-YEAR##',
                            $academic_year,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TERM##',
                            $term,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##YEAR-OF-PASSING##',
                            $yop,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##MARKS##',
                            $marks,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##MAX-MARKS##',
                            $max_marks,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##GRADE##',
                            $grade,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );

                        $output_str .= $html_content;
                    }
                }
            }
        }

        return $output_str;
    }
    public function get_pg_marksmemo_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('PostgraduateSub');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-academic-pg-marksmemo.html';
                        $html_content = $this->read_file($print_template);
                        $record_id = $rec['RecordId'];
                        $academic_year = stripslashes($rec['AcademicYear']);
                        $term = stripslashes($rec['Term']);
                        $yop = stripslashes($rec['YearOfPassing']);
                        $marks = stripslashes($rec['Marks']);
                        $max_marks = stripslashes($rec['MaxMarks']);
                        $grade = stripslashes($rec['Grade']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "UG | MarksMemo | $yop";
                        if ($document_id_arr == '-1') {
                            $attachments = $this->get_document_email_links(
                                44,
                                $record_id,
                            );
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                44,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }
                        $html_content = str_replace(
                            '##ACADEMIC-YEAR##',
                            $academic_year,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TERM##',
                            $term,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##YEAR-OF-PASSING##',
                            $yop,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##MARKS##',
                            $marks,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##MAX-MARKS##',
                            $max_marks,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##GRADE##',
                            $grade,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );

                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }
    public function get_med_family_patient_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        global $record_type_id, $user_email;
        $html_content = '';
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('MedFamilyMember');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-medical-family-patient.html';
                        $html_content = $this->read_file($print_template);

                        $record_id = $rec['RecordId'];
                        $patient_name = stripslashes($rec['PatientName']);
                        $treatment_type = stripslashes($rec['TreatmentType']);
                        $place = stripslashes($rec['Place']);
                        $address = stripslashes($rec['Address']);
                        $from_date = stripslashes($rec['FromDate']);
                        $doctor_name = stripslashes($rec['DoctorName']);
                        $doctor_address = stripslashes($rec['DoctorAddress']);
                        $to_date = stripslashes($rec['ToDate']);
                        $status = stripslashes($rec['Status']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Patient & Family Health | Patient | $patient_name";

                        if ($document_id_arr == '-1') {
                            $attachments = $this->get_document_email_links(
                                26,
                                $record_id,
                            );
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                26,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##PATIENT-NAME##',
                            $patient_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TREATMENT-TYPE##',
                            $treatment_type,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##PLACE##',
                            $place,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ADDRESS##',
                            $address,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##FROM-DATE##',
                            $from_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TO-DATE##',
                            $to_date,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DOC-NAME##',
                            $doctor_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##DOC-ADDRESS##',
                            $doctor_address,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##STATUS##',
                            $status,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );

                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }

    public function get_med_insurance_beneficiary_html(
        $document_id_arr,
        $user_id,
        $parent_record_id,
        $sub_id_arr,
    ) {
        $output_str = '';
        if (safe_count($sub_id_arr ?? []) > 0) {
            for ($i = 0; $i < safe_count($sub_id_arr ?? []); $i++) {
                $this->mongodb->where([
                    'RecordId' => mongo_id($sub_id_arr[$i]),
                    'UserId' => mongo_id($user_id),
                ]);
                $qry = $this->mongodb->get('MedHealthInsuranceBeneficiary');
                if (safe_count($qry ?? []) > 0) {
                    foreach ($qry as $rec) {
                        $print_template =
                            '../../templates/email-medical-health-insurance-beneficiary.html';
                        $html_content = $this->read_file($print_template);

                        $record_id = $rec['RecordId'];
                        $beneficiary_name = stripslashes(
                            $rec['BeneficiaryName'],
                        );
                        $relation = stripslashes($rec['Relation']);
                        $coverage_type = stripslashes($rec['CoverageType']);
                        $percentage_allocation = stripslashes(
                            $rec['PercentageAllocation'],
                        );
                        $tenure = stripslashes($rec['Tenure']);
                        $tenure_amount = stripslashes($rec['TenureAmount']);
                        $status = stripslashes($rec['Status']);
                        $notes = stripslashes($rec['Notes']);
                        $header_title = "Health Insurance Beneficiary | $beneficiary_name";

                        if ($document_id_arr == '-1') {
                            $attachments = $this->get_document_email_links(
                                27,
                                $record_id,
                            );
                        } elseif (
                            safe_count($document_id_arr ?? []) > 0 &&
                            !empty($document_id_arr)
                        ) {
                            $attachments = $this->get_document_email_links_by_id_arr(
                                $document_id_arr,
                                27,
                                $record_id,
                            );
                        } else {
                            $attachments =
                                '<i>No documents are attached to this record</i>';
                        }

                        $html_content = str_replace(
                            '##HEADER-TITLE##',
                            $header_title,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##BENEFICIARY-NAME##',
                            $beneficiary_name,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##RELATIONSHIP##',
                            $relation,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##COVERAGE-TYPE##',
                            $coverage_type,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##PERC-ALLOCATION##',
                            $percentage_allocation,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TENURE##',
                            $tenure,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##TENURE-AMOUNT##',
                            $tenure_amount,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##STATUS##',
                            $status,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##NOTES##',
                            $notes,
                            $html_content,
                        );
                        $html_content = str_replace(
                            '##ATTACHMENTS##',
                            $attachments,
                            $html_content,
                        );

                        $output_str .= $html_content;
                    }
                }
            }
        }
        return $output_str;
    }
}
