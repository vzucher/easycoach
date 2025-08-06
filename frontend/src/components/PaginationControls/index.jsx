import React, { useCallback } from 'react';
import './styles.css';

const PaginationControls = ({ 
  pagination, 
  handlePageChange, 
  handlePerPageChange 
}) => {
  const startItem = pagination.total > 0 ? ((pagination.page - 1) * pagination.perPage) + 1 : 0;
  const endItem = Math.min(pagination.page * pagination.perPage, pagination.total);

  const totalPages = pagination.totalPages || 0;
  const isFirstPage = pagination.page <= 1;
  const isLastPage = pagination.page >= totalPages;
  const hasPages = totalPages > 0;
  const handlePrevious = useCallback(() => {
    if (!isFirstPage) {
      handlePageChange(pagination.page - 1);
    }
  }, [isFirstPage, handlePageChange, pagination.page]);

  const handleNext = useCallback(() => {
    if (!isLastPage) {
      handlePageChange(pagination.page + 1);
    }
  }, [isLastPage, handlePageChange, pagination.page]);

  const handlePerPageSelect = useCallback((e) => {
    handlePerPageChange(parseInt(e.target.value));
  }, [handlePerPageChange]);

  return (
    <div className="pagination-controls" role="navigation" aria-label="Pagination">
      <div className="pagination-info">
        <span className="pagination-text">
          {pagination.total > 0 ? (
            `Showing ${startItem} to ${endItem} of ${pagination.total} players`
          ) : (
            'No players found'
          )}
        </span>
        
        <label htmlFor="per-page-select" className="sr-only">
          Items per page
        </label>
        <select
          id="per-page-select"
          value={pagination.perPage}
          onChange={handlePerPageSelect}
          className="per-page-select"
          aria-label="Select number of items per page"
        >
          <option value={5}>5 per page</option>
          <option value={10}>10 per page</option>
          <option value={20}>20 per page</option>
          <option value={50}>50 per page</option>
        </select>
      </div>

      <div className="pagination-buttons">
        <button
          onClick={handlePrevious}
          disabled={isFirstPage || !hasPages}
          className="pagination-button"
          aria-label={`Go to previous page${isFirstPage ? ' (disabled)' : ''}`}
          aria-disabled={isFirstPage || !hasPages}
        >
          Previous
        </button>
        
        <span className="page-info" aria-live="polite">
          Page {pagination.page} of {totalPages || 1}
        </span>
        
        <button
          onClick={handleNext}
          disabled={isLastPage || !hasPages}
          className="pagination-button"
          aria-label={`Go to next page${isLastPage ? ' (disabled)' : ''}`}
          aria-disabled={isLastPage || !hasPages}
        >
          Next
        </button>
      </div>
    </div>
  );
};

export default PaginationControls; 