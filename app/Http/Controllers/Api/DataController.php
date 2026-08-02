<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getPrograms()
    {
        $programs = [
            ['id' => 1, 'name' => 'HSC', 'admissionStatus' => true],
            ['id' => 2, 'name' => 'Degree (Pass)', 'admissionStatus' => true],
            ['id' => 3, 'name' => 'Honours', 'admissionStatus' => true],
        ];
        return response()->json($programs)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    public function getAdmissionSessions()
    {
        return response()->json([]);
    }

    public function getAllSessions()
    {
        return response()->json([]);
    }

    public function getGroups()
    {
        return response()->json([]);
    }

    public function getGroupsByProgram($id)
    {
        // Mock data - replace with actual database query
        $groups = [
            ['id' => 5, 'name' => 'BSS', 'admissionStatus' => true, 'program_id' => 2],
            ['id' => 6, 'name' => 'BBS', 'admissionStatus' => true, 'program_id' => 2],
            ['id' => 7, 'name' => 'Accounting', 'admissionStatus' => true, 'program_id' => 3],
            ['id' => 8, 'name' => 'Management', 'admissionStatus' => true, 'program_id' => 3],
            ['id' => 9, 'name' => 'Economics', 'admissionStatus' => true, 'program_id' => 3],
        ];
        
        // Filter by program ID
        $filteredGroups = array_filter($groups, function($group) use ($id) {
            return $group['program_id'] == $id;
        });
        
        return response()->json(array_values($filteredGroups))
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    public function getOccupations()
    {
        return response()->json([['id' => 1, 'name' => 'Doctor']]);
    }

    public function getQualifications()
    {
        return response()->json([['id' => 1, 'name' => 'oc1']]);
    }

    public function getDistricts()
    {
        return response()->json([['id' => 1, 'name' => 'Dhaka']]);
    }

    public function getBoards()
    {
        return response()->json([['id' => 1, 'name' => 'Dhaka']]);
    }

    public function getConstants()
    {
        $constants = [
            "BLOOD_GROUPS" => ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
            "RELIGIONS" => ["Islam", "Hinduism", "Buddhism", "Christianity", "Others"],
            "GENDERS" => ["Male", "Female", "Other"],
            "NATIONALITY" => ["Bangladeshi", "Indian", "Pakistani", "Others"],
            "MARITAL_STATUS" => ["Single", "Married", "Divorced", "Widowed"],
            "RELATIONSHIP" => ["Father", "Mother", "Brother", "Sister", "Uncle", "Aunt", "Grandfather", "Grandmother", "Others"],
            "YEAR_CHOICES" => [2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026],
            "SECTION_CHOICES" => ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"],
            "PROMOTION_CHOICES" => ["0" => "Not Promoted", "1" => "1st Year", "2" => "2nd Year", "3" => "3rd Year", "4" => "4th Year", "5" => "5th Year", "6" => "6th Year", "7" => "7th Year", "8" => "8th Year"],
            "Student_Status_CHOICES" => ["ACTIVE", "TC", "Passed Out", "Suspended", "Admission Cancelled", "Dropped"]
        ];

        return response()->json($constants)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    public function getHscCourses($program_id, $group_id)
    {
        $courses = [
            ["id" => 1, "name" => "BENGALI", "code" => "101-102", "type" => 1, "status" => "Compulsory1", "credits" => 1.0, "program_id" => 1, "group_id" => null],
            ["id" => 2, "name" => "ENGLISH", "code" => "107-108", "type" => 2, "status" => "Compulsory2", "credits" => 1.0, "program_id" => 1, "group_id" => null],
            ["id" => 3, "name" => "ICT", "code" => "275", "type" => 3, "status" => "Compulsory3", "credits" => 1.0, "program_id" => 1, "group_id" => null],
            ["id" => 4, "name" => "PHYSICS ", "code" => "174-175", "type" => 4, "status" => "Elective1", "credits" => 1.0, "program_id" => 1, "group_id" => 1],
            ["id" => 5, "name" => "CHEMISTRY", "code" => "176-177", "type" => 5, "status" => "Elective2", "credits" => 1.0, "program_id" => 1, "group_id" => 1],
            ["id" => 6, "name" => "HIGHER MATHEMATICS ", "code" => "265-266", "type" => 0, "status" => "selectable", "credits" => 1.0, "program_id" => 1, "group_id" => 1],
            ["id" => 7, "name" => "BIOLOGY ", "code" => "178-179", "type" => 0, "status" => "selectable", "credits" => 1.0, "program_id" => 1, "group_id" => 1]
        ];

        return response()->json($courses);
    }
}
