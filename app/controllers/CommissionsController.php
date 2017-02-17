<?php

class CommissionsController extends \BaseController {

	/**
	 * Display a listing of commissions
	 *
	 * @return Response
	 */
	public function index()
	{
		$commissions = Commission::all();

		return View::make('commissions.index', compact('commissions'));
	}

	/**
	 * Show the form for creating a new commission
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('commissions.create');
	}

	/**
	 * Store a newly created commission in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Commission::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Commission::create($data);

		return Redirect::route('commissions.index');
	}

	/**
	 * Display the specified commission.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$commission = Commission::findOrFail($id);

		return View::make('commissions.show', compact('commission'));
	}

	/**
	 * Show the form for editing the specified commission.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$commission = Commission::find($id);

		return View::make('commissions.edit', compact('commission'));
	}

	/**
	 * Update the specified commission in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$commission = Commission::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Commission::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$commission->update($data);

		return Redirect::route('commissions.index');
	}

	/**
	 * Remove the specified commission from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Commission::destroy($id);

		return Redirect::route('commissions.index');
	}

}
