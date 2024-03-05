const changeSearchPage = (page) => {
  const searchParams = new URLSearchParams(window.location.search);

  searchParams.set('page', page);
  const newRelativePathQuery = `${window.location.pathname}?${searchParams.toString()}`;

  window.history.replaceState(null, '', newRelativePathQuery);
};

export {
  changeSearchPage,
};
