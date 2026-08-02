<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('program')->nullable();
            $table->string('group')->nullable();
            $table->string('session')->nullable();
            $table->string('sNameBangla')->nullable();
            $table->string('sNameEnglish')->nullable();
            $table->string('bloodGroup')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->dateTime('dob')->nullable();
            $table->bigInteger('bitId')->nullable();
            $table->bigInteger('nid')->nullable();
            $table->string('nationality')->nullable();
            $table->string('maritalStatus')->nullable();
            $table->bigInteger('sMobileNo')->nullable();
            $table->string('sPicture')->nullable();
            $table->string('fName')->nullable();
            $table->bigInteger('fNid')->nullable();
            $table->string('fQualification')->nullable();
            $table->string('fOccupation')->nullable();
            $table->bigInteger('fMonthlyIncome')->nullable();
            $table->bigInteger('fMobileNo')->nullable();
            $table->string('mName')->nullable();
            $table->bigInteger('mNid')->nullable();
            $table->string('mQualification')->nullable();
            $table->string('mOccupation')->nullable();
            $table->bigInteger('mMonthlyIncome')->nullable();
            $table->bigInteger('mMobileNo')->nullable();
            $table->string('permanentAddressVil')->nullable();
            $table->string('permanentAddressPO')->nullable();
            $table->string('permanentAddressPS')->nullable();
            $table->string('permanentAddressDist')->nullable();
            $table->string('presentAddressVil')->nullable();
            $table->string('presentAddressPO')->nullable();
            $table->string('presentAddressPS')->nullable();
            $table->string('presentAddressDist')->nullable();
            $table->string('gName')->nullable();
            $table->bigInteger('gNid')->nullable();
            $table->string('gRelation')->nullable();
            $table->bigInteger('gMobileNo')->nullable();
            $table->string('gEmail')->nullable();
            $table->string('gAddress')->nullable();
            $table->string('refName')->nullable();
            $table->bigInteger('refNid')->nullable();
            $table->string('refRelation')->nullable();
            $table->bigInteger('refMobileNo')->nullable();
            $table->string('refEmail')->nullable();
            $table->string('refAddress')->nullable();
            $table->string('examName1')->nullable();
            $table->string('rollNo1')->nullable();
            $table->string('regNo1')->nullable();
            $table->string('sessionExam1')->nullable();
            $table->float('gpa1')->nullable();
            $table->string('passingYear1')->nullable();
            $table->string('Board1')->nullable();
            $table->string('examName2')->nullable();
            $table->string('rollNo2')->nullable();
            $table->string('regNo2')->nullable();
            $table->string('sessionExam2')->nullable();
            $table->float('gpa2')->nullable();
            $table->string('passingYear2')->nullable();
            $table->string('Board2')->nullable();
            $table->string('compulsory1')->nullable();
            $table->string('compulsory2')->nullable();
            $table->string('compulsory3')->nullable();
            $table->string('elective1')->nullable();
            $table->string('elective2')->nullable();
            $table->string('elective3')->nullable();
            $table->string('optional')->nullable();
            $table->integer('status')->default(0);
            $table->string('hobby')->nullable();
            $table->string('extracurriculam')->nullable();
            $table->string('pinCode')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('teacher_applications', function (Blueprint $table) {
            $table->id();
            $table->string('applicationCode')->nullable()->unique();
            $table->string('teacherName')->nullable();
            $table->string('teacherNameBangla')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('motherName')->nullable();
            $table->string('religion')->nullable();
            $table->string('bloodGroup')->nullable();
            $table->string('dob')->nullable();
            $table->string('presentAddress')->nullable();
            $table->string('upazilaThana')->nullable();
            $table->string('zillaPostOffice')->nullable();
            $table->string('designation')->nullable();
            $table->string('indexNo')->nullable();
            $table->string('ein')->nullable();
            $table->string('appointmentType')->nullable();
            $table->string('bankName')->nullable();
            $table->bigInteger('bankAccountNo')->nullable();
            $table->bigInteger('nid')->nullable();
            $table->string('nidScan')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('profileScan')->nullable();
            $table->string('sscExamType')->nullable();
            $table->string('sscBoard')->nullable();
            $table->string('sscRegistrationNo')->nullable();
            $table->string('sscResult')->nullable();
            $table->string('sscYear')->nullable();
            $table->string('sscMarksheetScan')->nullable();
            $table->string('hscExamType')->nullable();
            $table->string('hsceBoard')->nullable();
            $table->string('hscRegistrationNo')->nullable();
            $table->string('hscResult')->nullable();
            $table->string('hscYear')->nullable();
            $table->string('hscMarksheetScan')->nullable();
            $table->string('graduationExamType')->nullable();
            $table->string('graduationSubject')->nullable();
            $table->string('graduationResult')->nullable();
            $table->string('graduationYear')->nullable();
            $table->string('graduationMarksheetScan')->nullable();
            $table->string('mastersExamType')->nullable();
            $table->string('mastersResult')->nullable();
            $table->string('mastersYear')->nullable();
            $table->string('mastersCertificateScan')->nullable();
            $table->string('bedResult')->nullable();
            $table->string('bedYear')->nullable();
            $table->string('bedCertificateScan')->nullable();
            $table->string('medResult')->nullable();
            $table->string('medYear')->nullable();
            $table->string('medCertificateScan')->nullable();
            $table->string('othersExam')->nullable();
            $table->string('othersExamResult')->nullable();
            $table->string('othersExamYear')->nullable();
            $table->string('othersExamDocument')->nullable();
            $table->string('institutionType')->nullable();
            $table->string('sscSubjectTeacher')->nullable();
            $table->dateTime('sscJoiningDate')->nullable();
            $table->string('hscSubjectTeacher')->nullable();
            $table->dateTime('hscJoiningDate')->nullable();
            $table->string('sscWantToBe')->nullable();
            $table->string('hscWantToBe')->nullable();
            $table->string('program')->nullable();
            $table->string('department')->nullable();
            $table->string('subject')->nullable();
            $table->string('previousInstitution')->nullable();
            $table->string('previousDesignation')->nullable();
            $table->dateTime('previousJoinDate')->nullable();
            $table->dateTime('previousRelieveDate')->nullable();
            $table->string('experienceCertificateScan')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
        Schema::dropIfExists('teacher_applications');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('page_contents');
    }
};
