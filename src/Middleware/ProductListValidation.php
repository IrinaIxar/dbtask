<?

class ProductListValidation {
	public function handle($request)
	{
		$params = $request->getQueryParams();
		$params['page'] = $params['page'] ?: 1;
		$params['countPerPage'] = $params['countPerPage'] ?: 10;
		$params['sort'] = $params['sort'] ?: 'name';
		$params['order'] = $params['order'] ?: 'asc';
		return $request->withQueryParams($params);
	}
}