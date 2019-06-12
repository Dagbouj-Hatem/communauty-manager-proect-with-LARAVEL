<?php

namespace App\Http\Controllers;

use App\DataTables\AuthenticationLogDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAuthenticationLogRequest;
use App\Http\Requests\UpdateAuthenticationLogRequest;
use App\Repositories\AuthenticationLogRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AuthenticationLogController extends AppBaseController
{
    /** @var  AuthenticationLogRepository */
    private $authenticationLogRepository;

    public function __construct(AuthenticationLogRepository $authenticationLogRepo)
    {
        $this->authenticationLogRepository = $authenticationLogRepo;
    }

    /**
     * Display a listing of the AuthenticationLog.
     *
     * @param AuthenticationLogDataTable $authenticationLogDataTable
     * @return Response
     */
    public function index(AuthenticationLogDataTable $authenticationLogDataTable)
    {
        return $authenticationLogDataTable->render('authentication_logs.index');
    }

    /**
     * Show the form for creating a new AuthenticationLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('authentication_logs.create');
    }

    /**
     * Store a newly created AuthenticationLog in storage.
     *
     * @param CreateAuthenticationLogRequest $request
     *
     * @return Response
     */
    public function store(CreateAuthenticationLogRequest $request)
    {
        $input = $request->all();

        $authenticationLog = $this->authenticationLogRepository->create($input);

        Flash::success('Authentication Log saved successfully.');

        return redirect(route('authenticationLogs.index'));
    }

    /**
     * Display the specified AuthenticationLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $authenticationLog = $this->authenticationLogRepository->findWithoutFail($id);

        if (empty($authenticationLog)) {
            Flash::error('Authentication Log not found');

            return redirect(route('authenticationLogs.index'));
        }

        return view('authentication_logs.show')->with('authenticationLog', $authenticationLog);
    }

    /**
     * Show the form for editing the specified AuthenticationLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $authenticationLog = $this->authenticationLogRepository->findWithoutFail($id);

        if (empty($authenticationLog)) {
            Flash::error('Authentication Log not found');

            return redirect(route('authenticationLogs.index'));
        }

        return view('authentication_logs.edit')->with('authenticationLog', $authenticationLog);
    }

    /**
     * Update the specified AuthenticationLog in storage.
     *
     * @param  int              $id
     * @param UpdateAuthenticationLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuthenticationLogRequest $request)
    {
        $authenticationLog = $this->authenticationLogRepository->findWithoutFail($id);

        if (empty($authenticationLog)) {
            Flash::error('Authentication Log not found');

            return redirect(route('authenticationLogs.index'));
        }

        $authenticationLog = $this->authenticationLogRepository->update($request->all(), $id);

        Flash::success('Authentication Log updated successfully.');

        return redirect(route('authenticationLogs.index'));
    }

    /**
     * Remove the specified AuthenticationLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $authenticationLog = $this->authenticationLogRepository->findWithoutFail($id);

        if (empty($authenticationLog)) {
            Flash::error('Authentication Log not found');

            return redirect(route('authenticationLogs.index'));
        }

        $this->authenticationLogRepository->delete($id);

        Flash::success('Authentication Log deleted successfully.');

        return redirect(route('authenticationLogs.index'));
    }
}
