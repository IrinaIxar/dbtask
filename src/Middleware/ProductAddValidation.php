<?

class ProductAddValidation {
	public function handle($request)
	{
		$params = $request->getParsedBody();
		$params['count'] = (int)$params['count'];
		$params['price'] = (float)$params['price'];
		return $request->withParsedBody($params);
	}
}