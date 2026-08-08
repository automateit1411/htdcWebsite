<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'sNameEnglish',
        'sNameBangla',
        'program',
        'session',
        'group',
        'sMobileNo',
        'bloodGroup',
        'religion',
        'gender',
        'dob',
        'bitId',
        'nid',
        'nationality',
        'maritalStatus',
        'sPicture',
        'fName',
        'fNid',
        'fQualification',
        'fOccupation',
        'fMonthlyIncome',
        'fMobileNo',
        'mName',
        'mNid',
        'mQualification',
        'mOccupation',
        'mMonthlyIncome',
        'mMobileNo',
        'gName',
        'gNid',
        'gRelation',
        'gMobileNo',
        'gEmail',
        'gAddress',
        'refName',
        'refNid',
        'refRelation',
        'refMobileNo',
        'refEmail',
        'refAddress',
        'permanentAddressVil',
        'permanentAddressPO',
        'permanentAddressPS',
        'permanentAddressDist',
        'presentAddressVil',
        'presentAddressPO',
        'presentAddressPS',
        'presentAddressDist',
        'examName1',
        'rollNo1',
        'regNo1',
        'sessionExam1',
        'gpa1',
        'passingYear1',
        'Board1',
        'examName2',
        'rollNo2',
        'regNo2',
        'sessionExam2',
        'gpa2',
        'passingYear2',
        'Board2',
        'compulsory1',
        'compulsory2',
        'compulsory3',
        'elective1',
        'elective2',
        'elective3',
        'optional',
        'hobby',
        'extracurriculam',
        'pinCode',
        'status',
    ];

    /**
     * Get the absolute URL for the student picture.
     */
    public function getSPictureAttribute($value)
    {
        if (empty($value)) return null;

        // Return full URL if it's already a full URL or base64
        if (filter_var($value, FILTER_VALIDATE_URL) || preg_match('/^data:image/', $value)) {
            return $value;
        }

        return asset($value);
    }
}
