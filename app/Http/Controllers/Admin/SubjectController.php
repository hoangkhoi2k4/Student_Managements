<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectFormRequest;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectReposittory;
    protected $studentReposittory;
    public function __construct(SubjectRepository $subjectReposittory, StudentRepository $studentReposittory)
    {
        $this->middleware('permission:list_subject')->only(['index']);
        $this->middleware('permission:create_subject')->only(['create', 'store']);
        $this->middleware('permission:show_subject')->only(['show']);
        $this->middleware('permission:update_subject')->only(['edit', 'update']);
        $this->middleware('permission:destroy_subject')->only(['destroy']);
        $this->subjectReposittory = $subjectReposittory;
        $this->studentReposittory = $studentReposittory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subjectsHasScores = $this->subjectReposittory->getSubjectHasScores();
        $unregistedSubject = [];
        if (isset(auth()->user()->student->id)) {
            $unregistedSubject = $this->studentReposittory->show(auth()->user()->student->id)->subjects->pluck('id')->toArray();
        }
        $subjects = $this->subjectReposittory->getAll($request->all());
        return view('admin.subjects.index', compact('subjects', 'subjectsHasScores', 'unregistedSubject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectFormRequest $request)
    {
        $this->subjectReposittory->create($request->all());
        return redirect()->route('subjects.index')->with('success', __('Created Successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subjectsHasScores = $this->subjectReposittory->getSubjectHasScores();

        $subject = $this->subjectReposittory->findOrFail($id);
        return view('admin.subjects.form', compact('subject', 'subjectsHasScores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectFormRequest $request, string $id)
    {
        $this->subjectReposittory->update($request->all(), $id);
        return redirect()->route('subjects.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hasScores = $this->subjectReposittory->getSubjectHasScore($id);
        if (!$hasScores) {
            $this->subjectReposittory->deleteSubject($id);
            return redirect()->back()->with('success', __('Deleted Successfully'));
        } else {
            return redirect()->back()->with('error', __('Can not delete because subject has scores'));
        }
    }
}
