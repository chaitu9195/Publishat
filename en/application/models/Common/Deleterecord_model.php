<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Deleterecord_model extends CI_Model
{
    public function delete_record($params)
    {
        $user_id = $this->session->userdata('user_id');
        $ids = explode(',', $params['RecordId']);
        $RecordTypeId = $params['record_type_id'];
        $recordDeleted = 0;
        $this->mongodb->where(['RecordTypeId' => $RecordTypeId]);
        $getTableName = $this->mongodb->get(TBL_RECORDTYPE);
        if (count($getTableName ?? []) > 0) {
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
                $headers = ['key1' => 'TestName', 'key2' => 'TestType', 'key3' => 'TestDate'];
            }
            if ($RecordTypeId == 20) {
                $headers = ['key1' => 'PrescriptionType', 'key2' => 'DiseaseName', 'key3' => 'MedicineType'];
            }
            if ($RecordTypeId == 21) {
                $headers = ['key1' => 'DiseaseType', 'key2' => 'TreatmentType', 'key3' => 'FromDate'];
            }
            if ($RecordTypeId == 22) {
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
                $headers = ['key1' => 'RevenueType', 'key2' => 'ItemName', 'key3' => 'Term'];
            }
            if ($RecordTypeId == 33) {
                $headers = ['key1' => 'CardType', 'key2' => 'ServiceProviderName', 'key3' => 'CardNumber'];
            }
            if ($RecordTypeId == 34) {
                $headers = ['key1' => 'LiabilityType', 'key2' => 'LiabilityName', 'key3' => 'FromDate'];
            }
            if ($RecordTypeId == 35) {
                $headers = ['key1' => 'PaymentType', 'key2' => 'ItemName', 'key3' => 'Term'];
            }
            if ($RecordTypeId == 36) {
                $headers = ['key1' => 'TaxDocumentType', 'key2' => 'Date', 'key3' => 'AssessmentYear'];
            }
            if ($RecordTypeId == 37) {
                $headers = ['key1' => 'InsuranceType', 'key2' => 'PolicyName', 'key3' => 'FromDate'];
            }

            $recordNames = $headers['key1'];

            $tableName = $getTableName;
            $moduledetails = $getTableName;
            $tableName = $tableName[0]['DBTable'];

            foreach ($ids as $id) {
                $this->mongodb->where(['UserId' => mongo_id($user_id), 'RecordId' => mongo_id($id)]);
                $recordData = $this->mongodb->get($tableName);
                if (count($recordData ?? []) > 0) {
                    $rdresult = $recordData;

                    $RecordName = $rdresult[0][$recordNames];

                    $document_type = $rdresult[0]['DocumentType'];

                    $this->mongodb->where(['UserId' => mongo_id($user_id), 'RecordId' => mongo_id($id)]);
                    $qresult = $this->mongodb->delete($tableName);
                    $m = new MongoClient();
                    $con = $m->SelectDB('publisha_dbase')->getGridFS();
                    $con->remove(['RecordId' => mongo_id($id)]);
                    if ($qresult) {
                        $temp = [
                            '19' => 'MedMedicalTestRecords',
                            '20' => 'MedPrescriptionMedicine',
                            '21' => 'MedFamilyMember',
                            '22' => 'MedHealthInsuranceBeneficiary',
                            '32' => 'revenue',
                            '35' => 'payments',
                        ];
                        $temprectypes = [19, 20, 21, 22, 32, 35];
                        if (in_array($RecordTypeId, $temprectypes ?? [])) {
                            $relatedTableName = $temp[$RecordTypeId];

                            $this->mongodb->where(['ParentRecordId' => mongo_id($id), 'UserId' => mongo_id($user_id)]);
                            $checkrelatedrecsqry = $this->mongodb->get($relatedTableName);
                            if (count($checkrelatedrecsqry ?? []) > 0) {
                                foreach ($checkrelatedrecsqry as $singlerelatedrec) {
                                    $temprelatedrecid = $singlerelatedrec['RecordId'];
                                    if ($RecordTypeId == 19) {
                                        $tempRecordTypeId = 23;
                                    }
                                    if ($RecordTypeId == 20) {
                                        $tempRecordTypeId = 24;
                                    }
                                    if ($RecordTypeId == 21) {
                                        $tempRecordTypeId = 26;
                                    }
                                    if ($RecordTypeId == 22) {
                                        $tempRecordTypeId = 27;
                                    }
                                    if ($RecordTypeId == 32) {
                                        $tempRecordTypeId = 41;
                                    }
                                    if ($RecordTypeId == 35) {
                                        $tempRecordTypeId = 39;
                                    }
                                }
                            }
                            $qury = $this->mongodb->get($relatedTableName);

                            $delqry = $this->mongodb->delete($relatedTableName);
                        }

                        $eventdata = [
                            'UserId' => $user_id,
                            'EventType' => 'Deleted',
                            'Module' => $moduledetails[0]['Module'],
                            'RecordName' => $RecordName,
                            'RecordType' => $moduledetails[0]['RecordType'],
                            'DocumentType' => $document_type,
                            'Date' => TimeStamp,
                        ];
                        $eventquery = $this->mongodb->insert(TBL_EVENTS, $eventdata);

                        return ['status' => 'success', 'data' => 'Selected record has been deleted successfully'];
                    } else {
                        return ['status' => 'failed', 'data' => 'Not deleted'];
                    }
                }
            }
        }
    }

    public function deleltedocumentsfromfolder($user_id, $id, $RecordTypeId)
    {
        $this->mongodb->where([
            'UserId' => mongo_id($user_id),
            'RecordId' => mongo_id($id),
            'RecordTypeId' => $RecordTypeId,
        ]);
        $qry = $this->mongodb->get('fs.files');
        if (count($qry ?? []) > 0) {
            $this->mongodb->where([
                'UserId' => mongo_id($user_id),
                'RecordId' => mongo_id($id),
                'RecordTypeId' => $RecordTypeId,
            ]);
            $qry = $this->mongodb->delete('fs.files');
        }
    }
}
