<?
 class CategoryListValidation {
 	public function handle($request)
	{
		$params = $request->getQueryParams();
		$params['sort'] = $params['sort'] ?: 'name';
		$params['order'] = $params['order'] ?: 'asc';
		return $request->withQueryParams($params);
	}
 }