<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => (string) $request->name,
            'email' => (string) $request->email,
            'password' => Hash::make((string) $request->password),
        ]);

        // Cria a família e define o usuário como Owner
        $family = Family::create([
            'name' => 'Minha Família',
            'created_by_user_id' => $user->id,
        ]);

        // Se você tiver factory scope ->owner(), aqui é o equivalente no "real"
        FamilyMember::create([
            'family_id' => $family->id,
            'user_id' => $user->id,
            // Se o seu projeto usa constante:
            'role' => defined(FamilyMember::class . '::ROLE_OWNER') ? FamilyMember::ROLE_OWNER : 'owner',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
