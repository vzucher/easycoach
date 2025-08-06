import React from 'react';
import './styles.css';

const SearchBar = ({ searchText, setSearchText }) => {
  return (
    <input
      type="search"
      placeholder="Search players…"
      value={searchText}
      onChange={(e) => setSearchText(e.target.value)}
      className="search-input"
      autoComplete="off"
      aria-label="Search players"
    />
  );
};

export default SearchBar; 