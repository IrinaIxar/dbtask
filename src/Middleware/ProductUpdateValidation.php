<?

class ProductUpdateValidation {
	public function handle($request)
	{
		$paramsString = $request->getBody()->__toString();
		$params = [];
		foreach (explode('&', $paramsString) as $param) {
			$params[urldecode(array_shift(explode('=', $param)))] = urldecode(end(explode('=', $param)));
		}
		$params['count'] = (int)$params['count'];
		$params['price'] = (float)$params['price'];
		return $request->withParsedBody($params);
	}
}