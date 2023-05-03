<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->userRepository->create($request->all());
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = $this->userRepository->getById($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->getById($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->userRepository->update($id, $request->all());
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return redirect()->route('users.index');
    }
}
