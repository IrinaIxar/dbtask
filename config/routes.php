<?
return [
    ['GET', '/', ['user', 'authorization', []]],
    ['GET', '/products', ['product', 'list', ['productListValidation']]],
    ['GET', '/products/create', ['product', 'create', []]],
    ['POST', '/products/add', ['product', 'add', ['productAddValidation']]],
    ['DELETE', '/products/{id}', ['product', 'delete', []]],
    ['GET', '/products/{id}', ['product', 'edit', []]],
    ['PUT', '/products/update', ['product', 'update', ['productUpdateValidation']]],
    ['GET', '/categories', ['category', 'list', ['categoryListValidation']]],
    ['GET', '/users/authorization', ['user', 'authorization', []]],
    ['POST', '/users/login', ['user', 'login', []]],
    ['POST', '/users/add', ['user', 'add', []]]
];