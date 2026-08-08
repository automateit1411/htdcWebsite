<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacherName',
        'teacherNameBangla',
        'mobile',
        'email',
        'fatherName',
        'motherName',
        'religion',
        'bloodGroup',
        'dob',
        'nid',
        'presentAddress',
        'upazilaThana',
        'zillaPostOffice',
        'sscExamType',
        'sscBoard',
        'sscYear',
        'sscResult',
        'sscRegistrationNo',
        'hscExamType',
        'hsceBoard',
        'hscYear',
        'hscResult',
        'hscRegistrationNo',
        'graduationExamType',
        'graduationSubject',
        'graduationResult',
        'graduationYear',
        'mastersExamType',
        'mastersResult',
        'mastersYear',
        'bedResult',
        'medResult',
        'othersExam',
        'othersExamResult',
        'institutionType',
        'subject',
        'sscSubjectTeacher',
        'hscSubjectTeacher',
        'previousInstitution',
        'previousDesignation',
        'previousJoinDate',
        'previousRelieveDate',
        'profileScan',
        'nidScan',
        'sscMarksheetScan',
        'hscMarksheetScan',
        'graduationMarksheetScan',
        'mastersCertificateScan',
        'bedCertificateScan',
        'othersExamDocument',
        'experienceCertificateScan',
        'applicationCode',
    ];
}
