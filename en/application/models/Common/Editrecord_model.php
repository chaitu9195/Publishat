<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Editrecord_model extends CI_Model
{
    public function update_record($params)
    {
        $user_id = $this->session->userdata('user_id');
        $addrelated = [];
        $RecordTypeId = $params['record_type_id'];

        $label = $params['uploadedfile_tag'];
        $fileids = $params['fileids'];
        $fileids = explode(',', $fileids);
        $RecordId = $params['RecordId'];
        unset($params['record_type_id']);
        unset($params['module']);
        unset($params['fileids']);
        unset($params['RecordId']);
        unset($params['parent_record_type_id']);
        unset($params['ParentRecordId']);
        $params = array_filter($params);

        if ($RecordTypeId == 1) {
            $headers = ['key1' => 'Class', 'key2' => 'SchoolName', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 2) {
            $headers = ['key1' => 'Degree', 'key2' => 'Term', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 3) {
            $headers = ['key1' => 'Degree', 'key2' => 'Term', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 4) {
            $headers = ['key1' => 'Degree', 'key2' => 'Term', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 5) {
            $headers = ['key1' => 'CertificationType', 'key2' => 'CertificateName', 'key3' => 'ValidFrom'];
        }
        if ($RecordTypeId == 6) {
            $headers = ['key1' => 'ExamType', 'key2' => 'ExamName', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 7) {
            $headers = ['key1' => 'ProjectType', 'key2' => 'Title', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 8) {
            $headers = ['key1' => 'Location', 'key2' => 'Purpose', 'key3' => 'FromDate'];
        }
        if ($RecordTypeId == 9) {
            $headers = ['key1' => 'DocumentType', 'key2' => 'IssuedDate', 'key3' => 'ReferenceNo'];
        }
        if ($RecordTypeId == 10) {
            $headers = ['key1' => 'Name', 'key2' => 'RelationshipType', 'key3' => 'ContactMode'];
        }
        if ($RecordTypeId == 11) {
            $headers = ['key1' => 'SiteName', 'key2' => 'Usage', 'key3' => 'DocumentStatus'];
        }
        if ($RecordTypeId == 12) {
            $headers = ['key1' => 'TravelType', 'key2' => 'FromDate', 'key3' => 'ToPlace'];
        }
        if ($RecordTypeId == 13) {
            $headers = ['key1' => 'DeviceName', 'key2' => 'Brand', 'key3' => 'ReferenceNumber'];
        }
        if ($RecordTypeId == 14) {
            $headers = ['key1' => 'ContactName', 'key2' => 'MobileNumber', 'key3' => 'PersonalEmail'];
        }
        if ($RecordTypeId == 15) {
            $headers = ['key1' => 'DocumentType', 'key2' => 'OrganisationName', 'key3' => 'IssuedDate'];
        }
        if ($RecordTypeId == 16) {
            $headers = ['key1' => 'ProjectName', 'key2' => 'FromDate', 'key3' => 'ToDate'];
        }
        if ($RecordTypeId == 17) {
            $headers = ['key1' => 'SkillType', 'key2' => 'SkillName', 'key3' => 'DocumentType'];
        }
        if ($RecordTypeId == 18) {
            $headers = ['key1' => 'AppType', 'key2' => 'AppName', 'key3' => 'PasswordChangeStatus'];
        }
        if ($RecordTypeId == 38) {
            $headers = ['key1' => 'ResumeType', 'key2' => 'Name', 'key3' => 'FunctionalArea'];
        }
        if ($RecordTypeId == 19) {
            $addrelated = ['addrelated' => 1];
            $headers = ['key1' => 'TestName', 'key2' => 'TestType', 'key3' => 'TestDate'];
        }
        if ($RecordTypeId == 20) {
            $addrelated = ['addrelated' => 1];
            $headers = ['key1' => 'PrescriptionType', 'key2' => 'DiseaseName', 'key3' => 'MedicineType'];
        }
        if ($RecordTypeId == 21) {
            $addrelated = ['addrelated' => 1];
            $headers = ['key1' => 'DiseaseType', 'key2' => 'TreatmentType', 'key3' => 'FromDate'];
        }
        if ($RecordTypeId == 22) {
            $addrelated = ['addrelated' => 1];
            $headers = ['key1' => 'PolicyType', 'key2' => 'PolicyName', 'key3' => 'FromDate'];
        }
        if ($RecordTypeId == 28) {
            $headers = ['key1' => 'DisputeType', 'key2' => 'PartyName', 'key3' => 'FromDate'];
        }
        if ($RecordTypeId == 29) {
            $headers = ['key1' => 'TransferType', 'key2' => 'AssetName', 'key3' => 'ValidFrom'];
        }
        if ($RecordTypeId == 30) {
            $headers = ['key1' => 'AccountType', 'key2' => 'AccountNumber', 'key3' => 'BranchName'];
        }
        if ($RecordTypeId == 31) {
            $headers = ['key1' => 'AssetType', 'key2' => 'AssetName', 'key3' => 'ValidFrom'];
        }
        if ($RecordTypeId == 32) {
            $addrelated = ['addrelated' => 1];
            $headers = ['key1' => 'RevenueType', 'key2' => 'ItemName', 'key3' => 'Term'];
        }
        if ($RecordTypeId == 33) {
            $headers = ['key1' => 'CardType', 'key2' => 'ServiceProviderName', 'key3' => 'CardNumber'];
        }
        if ($RecordTypeId == 34) {
            $headers = ['key1' => 'LiabilityType', 'key2' => 'LiabilityName', 'key3' => 'FromDate'];
        }
        if ($RecordTypeId == 35) {
            $addrelated = ['addrelated' => 1];
            $headers = ['key1' => 'PaymentType', 'key2' => 'ItemName', 'key3' => 'Term'];
        }
        if ($RecordTypeId == 36) {
            $headers = ['key1' => 'TaxDocumentType', 'key2' => 'Date', 'key3' => 'AssessmentYear'];
        }
        if ($RecordTypeId == 37) {
            $headers = ['key1' => 'InsuranceType', 'key2' => 'PolicyName', 'key3' => 'FromDate'];
        }

        $recordNames = $headers['key1'];
        $RecordName = $params[$recordNames];

        $this->mongodb->where(['RecordTypeId' => $RecordTypeId]);
        $dbresult = $this->mongodb->get(TBL_RECORDTYPE);
        $RecordDetails = $dbresult;
        $params['TS'] = TimeStamp;

        $this->mongodb->set($params);

        $this->mongodb->where(['RecordId' => mongo_id($RecordId)]);
        $result = $this->mongodb->update($RecordDetails[0]['DBTable']);

        if ($result) {
            if (count($fileids ?? []) > 0) {
                for ($i = 0; $i < count($fileids ?? []); $i++) {
                    $file_id = $fileids[$i];
                    if ($file_id != '') {
                        $this->mongodb->where(['_id' => mongo_id($file_id), 'UserId' => mongo_id($user_id)]);
                        $file_qry = $this->mongodb->get('fs.files');
                        if (count($file_qry ?? []) > 0) {
                            $this->mongodb->where(['_id' => mongo_id($file_id)]);
                            $this->mongodb->set([
                                'RecordId' => mongo_id($RecordId),
                                'UploadedFrom' => 'FTR',
                                'DocumentId' => mongo_id($file_id),
                                'RecordTypeId' => $RecordTypeId,
                            ]);
                            $result = $this->mongodb->update('fs.files');
                        }
                    }
                }
            }

            if ($RecordTypeId == 14) {
                $checkdupgrp = $this->db->query(
                    'SELECT * FROM ' .
                        TBL_GROUPNAMES .
                        " WHERE UserId = '$params[UserId]' AND GroupName = '$params[GroupName]' ",
                );
                if ($checkdupgrp->num_rows() == 0) {
                    $insrtgrpname = $this->db->query(
                        'INSERT INTO ' .
                            TBL_GROUPNAMES .
                            " (UserId,GroupName) VALUES('$params[UserId]','$params[GroupName]') ",
                    );
                }
            }
            $eventdata = [
                'UserId' => $user_id,
                'EventType' => 'Modified',
                'Module' => $RecordDetails[0]['Module'],
                'RecordName' => $RecordName,
                'RecordType' => $RecordDetails[0]['RecordType'],
                'DocumentType' => $params['DocumentType'],
                'Date' => TimeStamp,
            ];
            $qry1 = $this->mongodb->insert(TBL_EVENTS, $eventdata);

            if (empty($addrelated)) {
                return ['status' => 'success', 'data' => 'record updated successfully'];
            } else {
                return [
                    'status' => 'success',
                    'data' => 'record updated successfully',
                    'addrelated' => '1',
                    'record_id' => $RecordId,
                ];
            }
        } else {
            return ['data' => 'Updation Failed'];
        }
    }

    public function create_folder($path)
    {
        $folder_name = strtolower($path);

        if (!is_dir($folder_name)) {
            if (!mkdir($folder_name, 0755, true)) {
                die('Failed to create folder...' . $folder_name);
                return false;
            } else {
                return true;
            }
        }
    }
}
