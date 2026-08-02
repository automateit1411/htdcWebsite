<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Setting;
use App\Models\Gallery;
use App\Models\PageContent;
use App\Models\TeacherApplication;
use App\Models\Visitor;
use App\Models\FormDownload;
use App\Models\TeacherVacantPost;
use App\Models\StaffVacantPost;
use App\Models\WebsiteLink;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $apiService;

    public function __construct(ExternalApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    /**
     * Display home page
     */
    public function home()
    {
        $totalVisitors = Visitor::totalCount();
        $todayVisitors = Visitor::todayCount();
        return view('welcome', compact('totalVisitors', 'todayVisitors'));
    }

    /**
     * Display founder page
     */
    public function founder()
    {
        $setting = Setting::first();
        return view('founder', compact('setting'));
    }

    /**
     * Display principal page
     */
    public function principal()
    {
        $setting = Setting::first();
        return view('principal', compact('setting'));
    }

    /**
     * Display principal list page
     */
    public function principalList()
    {
        return view('principal.index');
    }

    /**
     * Display principal detail page
     */
    public function principalDetail($index)
    {
        return view('principal.show', compact('index'));
    }

    /**
     * Display vice-principal list page
     */
    public function vicePrincipalList()
    {
        return view('vice-principal.index');
    }

    /**
     * Display vice-principal detail page
     */
    public function vicePrincipalDetail($index)
    {
        return view('vice-principal.show', compact('index'));
    }

    /**
     * Display ex-teacher list page
     */
    public function exTeacherList()
    {
        return view('ex-teacher.index');
    }

    /**
     * Display ex-teacher detail page
     */
    public function exTeacherDetail($index)
    {
        return view('ex-teacher.show', compact('index'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        // Fetch active settings from database
        $settings = Setting::where('is_active', true)->first();
        
        // If no active settings, create a default one
        if (!$settings) {
            $settings = Setting::create([
                'college_name' => 'Hazera-Taju Degree College',
                'location' => 'Chandgaon, Chittagong',
                'telephone' => '031-671018',
                'cell_phone' => '+880-1535-454836',
                'ein' => '104237',
                'nu_code' => '4303',
                'email' => 'info@htdc.edu.bd',
                'website' => 'https://www.htdc.edu.bd',
                'address' => 'Chandgaon, Chittagong, Bangladesh',
                'facebook_url' => 'https://www.facebook.com/Hazera-Taju-Degree-College-2072979046361536/',
                'youtube_url' => null,
                'google_map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3688.5406849339657!2d91.8539242!3d22.3779746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ad27a3cc1a7345%3A0x62679e6bebe98bb4!2z4Ka54Ka-4Kac4KeH4Kaw4Ka-LeCmpOCmnOCngSDgpqHgpr_gppfgp43gprDgp4Ag4KaV4Kay4KeH4Kac!5e0!3m2!1sen!2sbd!4v1693469827997!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'is_active' => true,
            ]);
        }

        return view('contact', compact('settings'));
    }

    /**
     * Display gallery page
     */
    public function gallery()
    {
        $items = Gallery::latest()->get();

        return view('gallery', compact('items'));
    }

    /**
     * Display public notices page
     */
    public function notices()
    {
        $notices = Notice::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('notices', compact('notices'));
    }

    public function formDownloads()
    {
        $notices = FormDownload::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $pageTitle = 'Form Downloads';
        return view('notices', compact('notices', 'pageTitle'));
    }

    public function teacherVacantPosts()
    {
        $notices = TeacherVacantPost::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $pageTitle = 'Teacher Vacant Posts';
        return view('notices', compact('notices', 'pageTitle'));
    }

    public function staffVacantPosts()
    {
        $notices = StaffVacantPost::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $pageTitle = 'Staff Vacant Posts';
        return view('notices', compact('notices', 'pageTitle'));
    }

    /**
     * Display teacher information list page
     */
    public function teacherInformation()
    {
        $totalTeachers = TeacherApplication::count();
        return view('teacher.index', compact('totalTeachers'));
    }

    /**
     * Display teacher detail page
     */
    public function teacherInformationDetail($employeeCode)
    {
        return view('teacher.show', compact('employeeCode'));
    }

    /**
     * Display teacher login panel
     */
    public function teacherPanel()
    {
        return view('teacher.login');
    }

    /**
     * Display staff information list page
     */
    public function staffInformation()
    {
        return view('staff.index');
    }

    /**
     * Display staff detail page
     */
    public function staffInformationDetail($employeeCode)
    {
        return view('staff.show', compact('employeeCode'));
    }

    /**
     * Display staff login panel
     */
    public function staffPanel()
    {
        return view('staff.login');
    }

    /**
     * Display employee login page (Teacher & Staff)
     */
    public function employeeLogin()
    {
        return view('employee.login');
    }

    /**
     * Display results search page
     */
    public function results()
    {
        $options = [
            'programs' => $this->apiService->getPrograms() ?: [],
            'admissionSessions' => $this->apiService->getAdmissionSessions() ?: [],
            'groups' => [],
            'constants' => $this->apiService->getConstants() ?: [],
        ];
        return view('results.index', compact('options'));
    }

    /**
     * Display daily attendance page
     */
    public function attendance()
    {
        $attendances = \App\Models\DailyAttendance::with('programGroup')
            ->latest('date')
            ->limit(30)
            ->get()
            ->groupBy(function ($item) {
                return $item->date->format('d-m-Y');
            });

        $programGroups = \App\Models\ProgramGroup::where('is_active', true)->get();

        return view('attendance.index', compact('attendances', 'programGroups'));
    }

    /**
     * Display feedback page
     */
    public function feedback()
    {
        return view('feedback.index');
    }

    /**
     * Display useful links page
     */
    public function usefulLinks()
    {
        $links = WebsiteLink::active()->ordered()->get();
        return view('useful-links', compact('links'));
    }

    /**
     * Handle feedback form submission
     */
    public function sendFeedback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $body = "Name: {$validated['name']}\nMobile: {$validated['mobile']}\nSubject: {$validated['subject']}\n\nMessage:\n{$validated['message']}";

            \Illuminate\Support\Facades\Mail::raw($body, function ($message) use ($validated) {
                $message->to('info@htdc.edu.bd')
                    ->subject('Website Feedback: ' . $validated['subject']);
            });

            return back()->with('success', 'Thank you for your feedback! It has been sent successfully.');
        } catch (\Exception $e) {
            \Log::error('Feedback email failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send email. Please try again later.');
        }
    }

    /**
     * Display a custom dynamic page by id
     */
    public function showCustomPage($id)
    {
        $page = \App\Models\CustomPage::where('status', true)->findOrFail($id);
        return view('pages.page', compact('page'));
    }

    /**
     * Display a dynamic page by name/slug
     */
    public function dynamicPage($slug)
    {
        // First check Custom Page 2 custom routes
        $cp2Page = \App\Models\CustomPage2::where('route', $slug)
            ->orWhere('route', '/' . $slug)
            ->where('status', true)->first();
        if ($cp2Page) {
            return view('custom-page2.show', ['page' => $cp2Page]);
        }

        // Convert slug back to a searchable name (e.g., 'digital-content' to 'Digital Content')
        $name = str_replace('-', ' ', $slug);

        $page = \App\Models\CustomPage::where(function($query) use ($name, $slug) {
                if ($slug === 'bou') {
                    $query->where('page_name', 'BOU')
                          ->orWhere('page_name', 'like', '%Board%')
                          ->orWhere('route', 'bou');
                } else {
                    $query->where('page_name', 'like', '%' . $name . '%')
                          ->orWhere('route', 'like', '%' . $slug . '%');
                }
            })
            ->where('status', true)
            ->first();

        if (!$page) {
            // Specific fallbacks for core pages
            if ($slug === 'bou') {
                $setting = \App\Models\Setting::first();
                $page = (object)[
                    'title' => $setting?->bou_body ?? 'Board of Trustees',
                    'description' => $setting?->bou_description ?? 'The Board of Trustees is the governing body responsible for overseeing the administration and strategic direction of the institution.',
                    'image_path' => null,
                    'file_path' => null,
                    'page_name' => 'BOU',
                ];
            } elseif ($slug === 'about') {
                $page = (object)[
                    'title' => 'About Hazera-Taju Degree College',
                    'description' => 'Hazera-Taju Degree College is committed to quality education and student development.',
                    'image_path' => null,
                    'file_path' => null,
                    'page_name' => 'About Us',
                ];
            } elseif ($slug === 'at-a-glance') {
                $page = (object)[
                    'title' => 'At a Glance',
                    'description' => 'Information about Hazera-Taju Degree College at a glance.',
                    'image_path' => null,
                    'file_path' => null,
                    'page_name' => 'At a Glance',
                ];
            } else {
                abort(404);
            }
        }

        return view('pages.page', compact('page'));
    }

    /**
     * Display a custom page 2 by slug or route (public)
     */
    public function customPage2($slug)
    {
        $page = \App\Models\CustomPage2::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
              ->orWhere('route', $slug)
              ->orWhere('route', '/' . $slug);
        })->where('status', true)->firstOrFail();
        return view('custom-page2.show', compact('page'));
    }

    /**
     * Display a custom page 2 by custom route (fallback)
     */
    public function customPage2Route($slug)
    {
        $page = \App\Models\CustomPage2::where('route', $slug)
            ->orWhere('route', '/' . $slug)
            ->where('status', true)->first();
        if ($page) {
            return view('custom-page2.show', compact('page'));
        }
        abort(404);
    }

    /**
     * Proxy employees data (teachers/staff) from external API
     */
    public function proxyEmployees($type)
    {
        $data = $this->apiService->getEmployees($type);
        return response()->json($data);
    }
}
