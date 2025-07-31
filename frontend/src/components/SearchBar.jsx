import { useState, useEffect } from 'react'

export const SearchBar = ({ disabled = false, onSearch }) => {
  const [searchText, setSearchText] = useState('');

  return (
    <input
      type="text"
      placeholder="Search players…"
      value={searchText}
      onChange={(e) => {
        setSearchText(e.target.value)
        onSearch(e.target.value)
      }}
      disabled={disabled}
      className="w-full p-3 mb-8 text-lg transition-colors duration-200 border-2 border-gray-300 rounded-lg focus:border-easycoach-primary focus:outline-none"
    />
  )
}