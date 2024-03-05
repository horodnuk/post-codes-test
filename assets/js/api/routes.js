const API_VER_PREF = '/api/v1';

const API_ROUTES = {
  'postal_codes.all': `${API_VER_PREF}/postal_codes`,
  'postal_codes.get': `${API_VER_PREF}/postal_codes/{code}`,
  'postal_codes.create': `${API_VER_PREF}/postal_codes`,
  'postal_codes.remove': `${API_VER_PREF}/postal_codes/{code}`,
};

const getRoute = (route, params = {}) => {
  let preparedUrl = route;

  const prepareRouteParams = (param) => {
    const [paramKey, paramValue] = param;

    preparedUrl = preparedUrl.replace(`{${paramKey}}`, paramValue);
  };

  Object.entries(params).forEach(prepareRouteParams);

  return preparedUrl;
};

export {
  API_ROUTES,
  getRoute,
};
