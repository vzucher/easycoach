import { useState, useEffect, useCallback, useRef } from 'react';
import API_CONFIG from '../config/api';

export function usePlayers() {
  const [players, setPlayers] = useState([]);
  const [searchText, setSearchText] = useState('');
  const [debouncedSearchText, setDebouncedSearchText] = useState('');
  const [pagination, setPagination] = useState({
    page: 1,
    perPage: 10,
    total: 0,
    totalPages: 0
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const searchTimeoutRef = useRef(null);

  useEffect(() => {
    if (searchTimeoutRef.current) {
      clearTimeout(searchTimeoutRef.current);
    }

    searchTimeoutRef.current = setTimeout(() => {
      setDebouncedSearchText(searchText);
    }, 500);

    return () => {
      if (searchTimeoutRef.current) {
        clearTimeout(searchTimeoutRef.current);
      }
    };
  }, [searchText]);

  useEffect(() => {
    const abortController = new AbortController();
    let isCurrentRequest = true;

    const fetchPlayers = async () => {
      setLoading(true);
      try {
        const params = new URLSearchParams({
          page: pagination.page.toString(),
          perPage: pagination.perPage.toString(),
          ...(debouncedSearchText && { search: debouncedSearchText })
        });
        
        const response = await fetch(`${API_CONFIG.BASE_URL}/api/players?${params}`, {
          signal: abortController.signal
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (isCurrentRequest) {
          setPlayers(data.players || []);
          setPagination(prev => ({
            ...prev,
            ...data.pagination,
            total: data.pagination?.total || 0,
            totalPages: data.pagination?.totalPages || 0
          }));
        }
      } catch (err) {
        if (isCurrentRequest && err.name !== 'AbortError') {
          console.error('Failed to fetch players from backend:', err);
          setError(err.message || 'Failed to fetch players');
          setPlayers([]);
          setPagination(prev => ({
            ...prev,
            total: 0,
            totalPages: 0
          }));
        }
      } finally {
        if (isCurrentRequest) {
          setLoading(false);
        }
      }
    };

    fetchPlayers();

    return () => {
      isCurrentRequest = false;
      abortController.abort();
    };
  }, [pagination.page, pagination.perPage, debouncedSearchText]);

  const handlePageChange = useCallback((newPage) => {
    setPagination(prev => ({ ...prev, page: newPage }));
  }, []);

  const handlePerPageChange = useCallback((newPerPage) => {
    setPagination(prev => ({ ...prev, page: 1, perPage: newPerPage }));
  }, []);

  const handleSearchChange = useCallback((newSearchText) => {
    setSearchText(newSearchText);
    setError(null);
    setPagination(prev => ({ ...prev, page: 1 }));
  }, []);

  return {
    players,
    searchText,
    pagination,
    loading,
    error,
    handlePageChange,
    handlePerPageChange,
    handleSearchChange
  };
} 