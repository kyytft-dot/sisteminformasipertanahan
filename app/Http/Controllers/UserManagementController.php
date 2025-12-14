<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteUserMail;
use App\Mail\AccountApprovedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    public function list(Request $request)
    {
        try {
            $query = User::with('roles');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Filter by role
            if ($request->has('role') && !empty($request->role)) {
                $query->whereHas('roles', function($q) use ($request) {
                    $q->where('name', $request->role);
                });
            }

            // Filter by approval status
            if ($request->has('approved')) {
                if ($request->approved === '1') {
                    $query->where('is_approved', true);
                } elseif ($request->approved === '0') {
                    $query->where('is_approved', false);
                }
            }

            $users = $query->orderBy('created_at', 'desc')
                          ->paginate($request->get('per_page', 10));

            return response()->json([
                'users' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load users'], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::with('roles')->findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,staff,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : null,
                'email_verified_at' => $request->password ? now() : null,
                'is_approved' => $request->password ? true : false,
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user->load('roles')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create user'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,staff,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $user->update([
                    'password' => Hash::make($request->password),
                    'email_verified_at' => now(),
                    'is_approved' => true,
                ]);
            }

            $user->syncRoles([$request->role]);

            DB::commit();

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user->load('roles')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update user'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting self
            if ($user->id === auth()->id()) {
                return response()->json(['error' => 'Cannot delete your own account'], 403);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }

    public function invite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,staff,admin',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Generate invite code
            $inviteCode = strtoupper(substr(md5(uniqid()), 0, 8));

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => null,
                'invite_code' => $inviteCode,
                'is_approved' => false,
            ]);

            // Skip role assignment for now to ensure user creation works
            // $user->assignRole($request->role);

            // Prepare Gmail URL with pre-filled content
            $inviteUrl = url('/register?invite=' . $inviteCode);
            $subject = 'Undangan Bergabung - Sistem Informasi Pertanahan';
            $body = "Halo {$user->name},\n\n" .
                   "Anda telah diundang untuk bergabung dengan Sistem Informasi Pertanahan Nasional.\n\n" .
                   "Silakan klik link berikut untuk mendaftar:\n" .
                   "{$inviteUrl}\n\n" .
                   "Kode Undangan: {$inviteCode}\n\n" .
                   "Salam,\n" .
                   "Tim Sistem Informasi Pertanahan Nasional";

            $gmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($user->email) .
                       "&su=" . urlencode($subject) .
                       "&body=" . urlencode($body);

            return response()->json([
                'message' => 'User berhasil dibuat! Gmail akan terbuka untuk mengirim undangan.',
                'user' => $user,
                'invite_code' => $inviteCode,
                'gmail_url' => $gmailUrl
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat user: ' . $e->getMessage()], 500);
        }
    }

    public function approve($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['is_approved' => true]);

            // Send approval email
            Mail::to($user->email)->send(new AccountApprovedMail($user));

            return response()->json(['message' => 'User approved successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to approve user'], 500);
        }
    }

    public function manualInvite($inviteCode)
    {
        try {
            $user = User::where('invite_code', $inviteCode)->firstOrFail();

            $inviteUrl = url('/register?invite=' . $inviteCode);

            // Prepare email content
            $subject = 'Undangan Bergabung - Sistem Informasi Pertanahan Nasional';
            $body = "Halo {$user->name},\n\n" .
                   "Anda telah diundang untuk bergabung dengan Sistem Informasi Pertanahan Nasional.\n\n" .
                   "Silakan klik link berikut untuk mendaftar:\n" .
                   "{$inviteUrl}\n\n" .
                   "Kode Undangan: {$inviteCode}\n\n" .
                   "Salam,\n" .
                   "Tim Sistem Informasi Pertanahan Nasional";

            // URL encode for Gmail compose
            $gmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($user->email) .
                       "&su=" . urlencode($subject) .
                       "&body=" . urlencode($body);

            return redirect($gmailUrl);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Kode undangan tidak valid');
        }
    }
}
