<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StudentRepository;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    protected $studentRepository;
    protected $userRepository;

    public function __construct(StudentRepository $studentRepository, UserRepository $userRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = $this->userRepository->show(Auth::user()->id);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateAvatar(ProfileUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $data['avatar'] = upload_image($request->file('avatar'));
            $user = $this->userRepository->show(Auth::user()->id);
            $this->studentRepository->findOrFail($user->student->id)->avatar ? unlink($this->studentRepository->findOrFail($user->student->id)->avatar) : '';
            $student = $this->studentRepository->update($data, $user->student->id);
            DB::commit();
            if (!$student) {
                return redirect()->back()->with('error', __('Update Failed'));
            }
            return redirect()->back()->with('success', __('Updated Successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
